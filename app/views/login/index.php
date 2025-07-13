<main role="main" class="container">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>You are not logged in please do </h1>
            </div>
        </div>
    </div>

    <?php if (isset($_SESSION['auth_error'])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_SESSION['auth_error']) ?>
        </div>
        <?php unset($_SESSION['auth_error']); ?>
    <?php endif; ?>

    <div class="row">
        <div class="col-sm-auto">
            <form action="/login/verify" method="post">
                <fieldset>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input class="form-control" type="text" name="username" id="username" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="password">Password</label>
                        <input class="form-control" type="password" name="password" id="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Login</button>
                </fieldset>
            </form>
        </div>
    </div>
</main>
