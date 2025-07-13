    <?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (isset($_SESSION['auth'])) {
        header('Location: /home');
        exit;
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
        <link rel="icon" href="/favicon.png">
        <title>COSC 4806</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="mobile-web-app-capable" content="yes" />
    </head>
    <body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
      <div class="container-fluid">
        <a class="navbar-brand" href="/home">COSC 4806</a>
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
