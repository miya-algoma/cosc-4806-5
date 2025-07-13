<?php require_once 'app/views/templates/header.php'; ?>

<style>
body {
font-family: 'Segoe UI', 'Helvetica Neue', sans-serif;
}
</style>

<div class="container">
<div class="page-header" id="banner">
<div class="row">
<div class="col-lg-12">
<h1>Reminders</h1>
<p class="lead"><?= date("F jS, Y"); ?></p>
</div>
</div>
</div>

<div class="row mb-3">
<div class="col-lg-12">
<p><a href="/reminders/create">Create a new reminder</a></p>
<p><a href="/logout">Click here to logout</a></p>
</div>
</div>

<?php if (!empty($data)): ?>
<ul class="list-group">
<?php foreach ($data as $reminder): ?>
<li class="list-group-item d-flex justify-content-between align-items-center">
<?= htmlspecialchars($reminder['subject']) ?>
<div>
<a href="/reminders/edit/<?= $reminder['id'] ?>" class="btn btn-outline-primary btn-sm">Update</a>
<form action="/reminders/complete/<?= $reminder['id'] ?>" method="post" style="display:inline;">
<button class="btn btn-success btn-sm">Completed</button>
</form>
</div>
</li>
<?php endforeach; ?>
</ul>
<?php else: ?>
<p>No reminders found.</p>
<?php endif; ?>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>