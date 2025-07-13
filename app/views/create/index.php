<?php require_once 'app/views/templates/headerPublic.php' ?>
<main role="main" class="container">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>Create an Account</h1>
            </div>
        </div>
    </div>

    <?php if (isset($_SESSION['register_error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['register_error']; unset($_SESSION['register_error']); ?>
        </div>
    <?php elseif (isset($_SESSION['register_success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['register_success']; unset($_SESSION['register_success']); ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-sm-auto">
            <form action="/create/submit" method="post">
                <fieldset>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input required type="text" class="form-control" name="username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input required type="password" class="form-control" name="password">
                    </div>
                    <div class="form-group">
                        <label for="confirm">Confirm Password</label>
                        <input required type="password" class="form-control" name="confirm">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Register</button>
                </fieldset>
            </form> 
        </div>
    </div>
</main>
<?php require_once 'app/views/templates/footer.php' ?>
