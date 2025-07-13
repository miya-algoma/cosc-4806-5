<?php
if (!isset($data)) $data = [];
require_once 'app/views/templates/header.php';
?>

<div class="container mt-4">
<h1>All User Reminders</h1>

<table class="table table-striped mt-3">
<thead>
<tr>
<th>Username</th>
<th>Reminder</th>
<th>Created At</th>
</tr>
</thead>
<tbody>
<?php if (count($data) > 0): ?>
<?php foreach ($data as $r): ?>
<tr>
<td><?= htmlspecialchars($r['username']) ?></td>
<td><?= htmlspecialchars($r['subject']) ?></td>
<td><?= htmlspecialchars($r['created_at']) ?></td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr><td colspan="3">No reminders found.</td></tr>
<?php endif; ?>
</tbody>
</table>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>