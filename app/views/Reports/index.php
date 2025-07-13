<?php require_once 'app/views/templates/header.php'; ?>

<div class="container mt-4">
    <h1>Admin Report Dashboard</h1>

    <!-- 🔹 Login Activity Table -->
    <h3 class="mt-5">Login Activity</h3>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Username</th>
                <th>Total Login Attempts</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['loginCounts'] as $entry): ?>
                <tr>
                    <td><?= htmlspecialchars($entry['username']) ?></td>
                    <td><?= htmlspecialchars($entry['attempts']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- 🔹 All Reminders -->
    <h3 class="mt-5">All Reminders</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Username</th>
                <th>Subject</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['allReminders'] as $reminder): ?>
                <tr>
                    <td><?= htmlspecialchars($reminder['username']) ?></td>
                    <td><?= htmlspecialchars($reminder['subject']) ?></td>
                    <td><?= htmlspecialchars($reminder['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- 🔹 User With Most Reminders -->
    <h3 class="mt-5">Top User</h3>
    <div class="alert alert-info">
        <?php if ($data['topUser']): ?>
            <?= htmlspecialchars($data['topUser']['username']) ?> has the most reminders (<?= $data['topUser']['reminder_count'] ?>).
        <?php else: ?>
            No reminders found yet.
        <?php endif; ?>
    </div>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>
