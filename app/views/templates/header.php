  <?php
  if (session_status() === PHP_SESSION_NONE) session_start();
  require_once 'app/models/User.php';
  $user = new User();
  if (isset($_SESSION['auth']['username'])) {
      $user->username = $_SESSION['auth']['username'];
  }
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="icon" href="/favicon.png">
      <title>COSC 4806</title>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width">
      <style>
          body { background: #fafbfc; }
          .navbar { margin-bottom: 24px; }
          .container { max-width: 850px; }
      </style>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="/home">COSC 4806</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

          <li class="nav-item">
            <a class="nav-link" href="/home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/about">About Me</a>
          </li>

          <!-- User Area Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              User Area
            </a>
            <ul class="dropdown-menu" aria-labelledby="userDropdown">
              <li><a class="dropdown-item" href="/reminders">Reminders</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="/logout">Logout</a></li>
            </ul>
          </li>

          <!-- Admin Area Dropdown (shows only for admin) -->
          <?php if ($user->isAdmin()): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Admin Area
            </a>
            <ul class="dropdown-menu" aria-labelledby="adminDropdown">
              <li><a class="dropdown-item" href="/reports">Login Report</a></li>
              <li><a class="dropdown-item" href="/reports/all_reminders">All Reminders</a></li>
              <li><a class="dropdown-item" href="/reports/most_reminders">Most Reminders</a></li>
              <li><a class="dropdown-item" href="/reports/login_counts">Login Counts</a></li>
            </ul>
          </li>
          <?php endif; ?>

        </ul>
      </div>
    </div>
  </nav>

  <!-- Breadcrumbs -->
  <nav aria-label="breadcrumb" class="mt-2">
    <ol class="breadcrumb container">
      <?php
        $segments = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
      ?>
      <li class="breadcrumb-item"><a href="/home">Home</a></li>
      <?php if (isset($segments[0]) && $segments[0] !== 'home'): ?>
        <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars(ucfirst($segments[0])) ?></li>
      <?php endif; ?>
      <?php if (isset($segments[1])): ?>
        <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $segments[1]))) ?></li>
      <?php endif; ?>
    </ol>
  </nav>
