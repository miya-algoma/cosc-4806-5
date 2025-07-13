<?php require_once 'app/views/templates/headerPublic.php'; ?>

<main role="main" class="container">
	<div class="page-header" id="banner">
		<div class="row">
			<div class="col-lg-12">
				<h1>You are not logged in</h1>
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
						<input required type="text" class="form-control" name="username" id="username">
					</div>

					<div class="form-group">
						<label for="password">Password</label>
						<input required type="password" class="form-control" name="password" id="password">
					</div>

					<br>
					<button type="submit" class="btn btn-primary">Login</button>
				</fieldset>
			</form>
		</div>
	</div>
</main>

<?php require_once 'app/views/templates/footer.php'; ?>
