<div class="background" style="background: url(<?php echo URL . "application/img/i10.jpg"; ?>) no-repeat center center fixed; -webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
    <div class="wrapper col-md-4 mx-auto">
        <br>
        <h1 class="text-center">Login</h1>
        <br>
        <br>
        <div class="row">
            <div class="col-md-12"></div>
            <form class="text-center col-md-12" action="<?php echo URL ?>login/login" method="post">
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" placeholder="Username" name="username" required>
                </div>
                <div class="form-group col-md-12">
                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                </div>
                <div class="form-group">
                    <!-- Email che attualmente non esiste ancora -->
                    <p>&#9432; Se non possiedi ancora un'account contatta <a href="mailto:admin@pizzadelivery.com?Subject=Creazione%20nuovo%20account" target="_top">l'admin</a> del sistema.</p>
                </div>
                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-danger btn-lg col-md-12">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>