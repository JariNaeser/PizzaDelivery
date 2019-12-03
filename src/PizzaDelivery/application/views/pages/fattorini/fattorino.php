<div class="container padding-footer text-center">
    <?php if(isset($_SESSION['fattorino']) && count($_SESSION['fattorino']) > 0 && isset($_SESSION['userFattorino']) && count($_SESSION['userFattorino']) > 0): ?>
        <?php $fattorino = $_SESSION['fattorino'][0]; ?>
        <?php $userFattorino = $_SESSION['userFattorino'][0]; ?>
        <h1>Fattorino <?php echo $fattorino['username']; ?></h1>
        <br>
        <br>
        <div class="row">
            <table class="table table-borderless col-md-6 text-left">
                <tbody>
                <tr>
                    <td><b>Nome</b>: <?php echo $userFattorino['nome']; ?></td>
                </tr>
                <tr>
                    <td><b>Cognome</b>: <?php echo $userFattorino['cognome']; ?></td>
                </tr>
                <tr>
                    <td><b>E-mail</b>: <?php echo $userFattorino['email']; ?></td>
                </tr>
                <tr>
                    <td><b>Via:</b> <?php echo $userFattorino['via']; ?></td>
                </tr>
                <tr>
                    <td><b>Stato:</b> <?php if($fattorino['inServizio'] == 1){
                                                echo "<span class=\"badge badge-danger\">In Servizio</span>";
                                            }else{
                                                echo "<span class=\"badge badge-success\">Libero</span>";
                                            } ?>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="col-md-6" id='map' style="min-height: 200px;"></div>
        </div>
        <br>
        <br>
        <h3 class="text-left">Consegne <span style="color: gray;">[<?php echo date("d.m.Y"); ?>]</span></h3>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">ID Consegna</th>
                    <th scope="col">Orario Inserimento</th>
                    <th scope="col">Orario Consegna</th>
                    <th scope="col">Via</th>
                    <th scope="col">Tipologia</th>
                    <th scope="col">Incasso</th>
                </tr>
                </thead>
                <tbody>
                    <?php if(isset($_SESSION['consegneFattorino']) && count($_SESSION['consegneFattorino']) > 0):?>
                        <?php foreach ($_SESSION['consegneFattorino'] as $consegna): ?>
                            <tr>
                                <td class="align-middle"><?php echo $consegna['id'];?></td>
                                <td class="align-middle"><?php echo $consegna['dataInserimento'];?></td>
                                <td class="align-middle"><?php if(isset($consegna['dataConsegna'])){echo $consegna['dataConsegna'];}else{echo "-";}?></td>
                                <td class="align-middle"><?php echo $consegna['via'][0]['via'];?></td>
                                <td class="align-middle"><?php if(strcmp($consegna['tipoConsegna'], "da effettuare") == 0){
                                                echo "<span class='badge badge-danger'>Da Effettuare</span>";
                                            }else if(strcmp($consegna['tipoConsegna'], "in corso") == 0){
                                                echo "<span class='badge badge-warning'>In Corso</span>";
                                            }else{
                                                echo "<span class='badge badge-success'>Terminata</span>";
                                            } ?>
                                </td>
                                <td>
                                    <?php if(isset($consegna['costoTotale'][0]['SommaCosti'])){
                                                echo $consegna['costoTotale'][0]['SommaCosti'];
                                            }else{
                                                echo "-";
                                            }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <?php echo "<tr><td colspan='6'>Nessuna consegna trovata.</td>"; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="text-center">
            <a href="<?php echo URL?>fattorini/home" class="btn btn-danger btn-lg">Torna ai fattorini</a>
        </div>
    <?php else: ?>
        <div class="centerVerticallyDiv">
            <h1 class="text-danger">ERRORE: Il fattorino non è stato trovato.</h1>
            <br>
            <a href="<?php echo URL?>fattorini/home" class="btn btn-danger btn-lg">Torna ai fattorini</a>
        </div>
    <?php endif; ?>
</div>

<script>

    //Map

    //Pointer size
    var size = 150;

    mapboxgl.accessToken = 'pk.eyJ1IjoiamFyaS1uYWVzZXIiLCJhIjoiY2sybHc4YjliMGFsbTNvcDBoNnJvZXludCJ9.b_eEj1vnKie7ZjsR4wNqdA';
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [<?php echo $fattorino['posizioneLat']; ?>, <?php echo $fattorino['posizioneLon']; ?>],
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
                            "description": "<strong>Fattorino: <?php echo $userFattorino['nome'] . " " . $userFattorino['cognome']; ?></strong><p>Posizione attuale [<?php echo $fattorino['posizioneLat']; ?>, <?php echo $fattorino['posizioneLon']; ?>]</p>",
                            "icon": "theatre"
                        },
                        "geometry": {
                            "type": "Point",
                            "coordinates": [<?php echo $fattorino['posizioneLat']; ?>, <?php echo $fattorino['posizioneLon']; ?>]
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