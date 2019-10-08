<div class="col-md-12">
    <br>
    <h1 class="text-center">Login</h1>
    <br>
    <br>
    <br>
    <div class="row">
        <div class="col-md-4"></div>
        <form class="text-center col-md-4" action="<?php echo URL ?>login/login" method="post">
            <div class="form-group col-md-12">
                <input type="text" class="form-control" placeholder="Username" name="username" required>
            </div>
            <div class="form-group col-md-12">
                <input type="password" class="form-control" placeholder="Password" name="password" required>
            </div>
            <div class="form-group col-md-12">
                <button type="submit" class="btn btn-danger btn-lg col-md-12">Login</button>
            </div>
        </form>
    </div>
</div>