<?php if(isset($_SESSION['articoli']) && count($_SESSION['articoli']) > 0 && isset($_SESSION['ordine']) && count($_SESSION['ordine']) > 0): ?>
    <div class="container padding-footer">
        <?php $ordine = $_SESSION['ordine']; ?>
        <?php $articoli = $_SESSION['articoli']; ?>
        <h1 class="text-center">ORDINAZIONE #<?php echo $ordine[0][0]['id'] ?></h1>
        <br>
        <h3>Cliente</h3>
        <div class="row">
            <table class="table table-borderless col-md-6 text-left">
                <tbody>
                    <tr>
                        <td><b>Nome</b>: <?php echo $ordine[0][0]['nomeCliente']; ?></td>
                    </tr>
                    <tr>
                        <td><b>Cognome</b>: <?php echo $ordine[0][0]['cognomeCliente']; ?></td>
                    </tr>
                    <tr>
                        <td><b>Telefono</b>: <?php echo $ordine[0][0]['numeroTelefonoCliente']; ?></td>
                    </tr>
                    <tr>
                        <td><b>Via:</b> <?php echo $ordine[0][0]['via']; ?></td>
                    </tr>
                </tbody>
            </table>
            <div class="col-md-6" id='map' style="min-height: 200px;"></div>
        </div>
        <br>
        <br>
        <h3>Prodotti ordinati</h3>
        <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Prezzo</th>
                    <th scope="col">Totale</th>
                </tr>
            </thead>
            <tbody>
            <?php if(isset($_SESSION['ordine']) && count($_SESSION['ordine']) > 0): ?>
                <?php foreach ($ordine[1] as $elemento): ?>
                    <tr>
                        <td><?php echo $elemento['quantita'] . "x " . $articoli[$elemento['articolo']-1]['nome']; ?></td>
                        <td><?php echo $articoli[$elemento['articolo']-1]['prezzo']; ?></td>
                        <td><?php echo $elemento['quantita']*$articoli[$elemento['articolo']-1]['prezzo']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <?php echo "<tr><td colspan='3'>Nessuna elemento trovato.</td></tr>"?>
            <?php endif; ?>
            </tbody>
        </table>
        </div>
        <div class="text-center">
            <a href="<?php echo URL?>ordinazioni/home" class="btn btn-danger btn-lg">Torna agli ordini</a>
        </div>
    </div>
<?php else: ?>
    <?php echo "Session articoli or/and cart not found."; ?>
<?php endif; ?>

<script>

    var request = "https://api.mapbox.com/geocoding/v5/mapbox.places/<?php echo $ordine[0][0]['via']; ?>.json?limit=1&access_token=pk.eyJ1IjoiamFyaS1uYWVzZXIiLCJhIjoiY2sybHc4YjliMGFsbTNvcDBoNnJvZXludCJ9.b_eEj1vnKie7ZjsR4wNqdA";
    var requestResponse = null;

    //Make request
    $.getJSON(request, function(data){
        console.log(data);
        var lat = data.features.0.geometry.coordinates.0;
        //var lon = data[features][0][geometry][coordinates][1];
        console.log(lat + " " + lon);
    });






    //Map

    //Pointer size
    var size = 150;

    mapboxgl.accessToken = 'pk.eyJ1IjoiamFyaS1uYWVzZXIiLCJhIjoiY2sybHc4YjliMGFsbTNvcDBoNnJvZXludCJ9.b_eEj1vnKie7ZjsR4wNqdA';
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [0, 0],
        zoom: 10
    });

    var pulsingDot = {
        width: size,
        height: size,
        data: new Uint8Array(size * size * 4),

        onAdd: function() {
            var canvas = document.createElement('canvas');
            canvas.width = this.width;
            canvas.height = this.height;
            this.context = canvas.getContext('2d');
        },

        render: function() {
            var duration = 1000;
            var t = (performance.now() % duration) / duration;

            var radius = size / 2 * 0.3;
            var outerRadius = size / 2 * 0.7 * t + radius;
            var context = this.context;

            // draw outer circle
            context.clearRect(0, 0, this.width, this.height);
            context.beginPath();
            context.arc(this.width / 2, this.height / 2, outerRadius, 0, Math.PI * 2);
            context.fillStyle = 'rgba(255, 200, 200,' + (1 - t) + ')';
            context.fill();

            // draw inner circle
            context.beginPath();
            context.arc(this.width / 2, this.height / 2, radius, 0, Math.PI * 2);
            context.fillStyle = 'rgba(255, 100, 100, 1)';
            context.strokeStyle = 'white';
            context.lineWidth = 2 + 4 * (1 - t);
            context.fill();
            context.stroke();

            // update this image's data with data from the canvas
            this.data = context.getImageData(0, 0, this.width, this.height).data;

            // keep the map repainting
            map.triggerRepaint();

            // return `true` to let the map know that the image was updated
            return true;
        }
    };

    map.on('load', function () {

        map.addImage('pulsing-dot', pulsingDot, { pixelRatio: 2 });

        map.addLayer({
            "id": "places",
            "type": "symbol",
            "source": {
                "type": "geojson",
                "data": {
                    "type": "FeatureCollection",
                    "features": [{
                        "type": "Feature",
                        "properties": {
                            "description": "<strong>Fattorino: <?php echo ""; ?></strong><p>Posizione attuale [<?php echo "0"; ?> , <?php echo "0"; ?>]</p>",
                            "icon": "theatre"
                        },
                        "geometry": {
                            "type": "Point",
                            "coordinates": [<?php echo "0"; ?>, <?php echo "0"; ?>]
                        }
                    }]
                }
            },
            "layout": {
                "icon-image": "pulsing-dot",
                "icon-allow-overlap": true
            }
        });
    });

    //Add popup actions

    // Create a popup, but don't add it to the map yet.
    var popup = new mapboxgl.Popup({
        closeButton: false,
        closeOnClick: false
    });

    map.on('mouseenter', 'places', function(e) {
        // Change the cursor style as a UI indicator.
        map.getCanvas().style.cursor = 'pointer';

        var coordinates = e.features[0].geometry.coordinates.slice();
        var description = e.features[0].properties.description;

        // Ensure that if the map is zoomed out such that multiple
        // copies of the feature are visible, the popup appears
        // over the copy being pointed to.
        while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
            coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
        }

        // Populate the popup and set its coordinates
        // based on the feature found.
        popup.setLngLat(coordinates)
            .setHTML(description)
            .addTo(map);
    });

    map.on('mouseleave', 'places', function() {
        map.getCanvas().style.cursor = '';
        popup.remove();
    });

</script>
