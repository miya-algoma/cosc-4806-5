<?php
if (!isset($data)) $data = [];
require_once 'app/views/templates/header.php';
?>

<div class="container mt-4">
    <h1>Login Counts by Username</h1>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Username</th>
                <th>Total Logins</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($data) > 0): ?>
                <?php foreach ($data as $entry): ?>
                    <tr>
                        <td><?= htmlspecialchars($entry['username']) ?></td>
                        <td><?= htmlspecialchars($entry['login_count']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="2">No login data found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>
