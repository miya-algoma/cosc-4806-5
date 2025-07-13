<?php require_once 'app/views/templates/header.php'; ?>

<div class="container mt-4">
    <h2>Your Reminders</h2>
    <p><a class="btn btn-success" href="/reminders/create">+ New Reminder</a></p>

    <?php if (count($data) == 0): ?>
        <p>No reminders yet.</p>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($data as $reminder): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?= htmlspecialchars($reminder['subject']) ?>
                    <span>
                        <a href="/reminders/edit/<?= $reminder['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="/reminders/delete/<?= $reminder['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>
