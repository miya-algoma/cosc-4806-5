<?php require_once 'app/views/templates/header.php'; ?>

<div class="container mt-4">
    <h1>Login Activity Report</h1>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Username</th>
                <th>Attempt</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $entry): ?>
                <tr>
                    <td><?= htmlspecialchars($entry['username']) ?></td>
                    <td><?= htmlspecialchars($entry['attempt']) ?></td>
                    <td><?= htmlspecialchars($entry['timestamp']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>
