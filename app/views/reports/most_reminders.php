<?php require_once 'app/views/templates/header.php'; ?>

<div class="container mt-4">
<h1>User with Most Reminders</h1>

<?php if ($data && isset($data['username'])): ?>
<div class="alert alert-info mt-3">
<strong><?= htmlspecialchars($data['username']) ?></strong> has the most reminders (<?= htmlspecialchars($data['total']) ?>).
</div>
<?php else: ?>
<div class="alert alert-warning">No reminder data found.</div>
<?php endif; ?>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>