<?php
if (!isset($loginCounts)) $loginCounts = [];
require_once 'app/views/templates/header.php';
?>

<div class="container mt-4">
    <h1>Login Counts by Username</h1>

    <!-- Chart canvas -->
    <canvas id="loginChart" width="400" height="200"></canvas>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Username</th>
                <th>Total Logins</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($loginCounts) > 0): ?>
                <?php foreach ($loginCounts as $entry): ?>
                    <tr>
                        <td><?= htmlspecialchars($entry['username']) ?></td>
                        <td><?= htmlspecialchars($entry['total']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="2">No login data found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Chart.js CDN and script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('loginChart').getContext('2d');
  const labels = <?= json_encode(array_column($loginCounts, 'username')) ?>;
  const counts = <?= json_encode(array_column($loginCounts, 'total')) ?>;
  const chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Total Logins',
        data: counts,
        backgroundColor: 'rgba(54, 162, 235, 0.7)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          precision: 0
        }
      }
    }
  });
</script>

<?php require_once 'app/views/templates/footer.php'; ?>
