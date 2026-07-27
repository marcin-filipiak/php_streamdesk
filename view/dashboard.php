<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="author" content="Marcin Filipiak">
    <meta name="application-name" content="StreamDesk">
    <meta name="repository" content="https://github.com/marcin-filipiak/php_streamdesk">
    <meta property="og:url" content="https://github.com/marcin-filipiak/php_streamdesk">
    <title><?= htmlspecialchars(SITE_TITLE) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/css/styles.css?v=<?= date('YmdHi') ?>" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="#">
    <?php if (file_exists(__DIR__ . '/../assets/img/logo.svg')): ?>
        <img src="<?= BASE_URL ?>/assets/img/logo.svg" alt="Logo" width="30" class="me-2">
    <?php endif; ?>
    <?= htmlspecialchars(NAVBAR_BRAND) ?>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainMenu">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <?php foreach ($links as $title => $url): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= htmlspecialchars($url) ?>" target="_blank"><?= htmlspecialchars($title) ?></a>
            </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</nav>

<main class="container py-2">

<?php foreach ($media as $category => $catData): ?>
    <h3 class="mt-4 mb-3">
        <a href="<?= htmlspecialchars($catData['source'] ?? '#') ?>" target="_blank">
            <?= htmlspecialchars($category) ?>
        </a>
    </h3>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 mb-4">
        <?php foreach ($catData['items'] as $item): ?>
            <div class="col">
                <div class="card h-100 shadow-sm<?= $pluginManager->has($item['type']) ? '' : ' border-danger' ?>"<?php if (!empty($item['refresh'])): ?> data-refresh="<?= (int)$item['refresh'] ?>"<?php endif; ?>>
                    <div class="ratio ratio-16x9 position-relative">
                        <?= $pluginManager->render($item['type'], $item, $category) ?>
                        <div class="card-img-overlay d-none">OFFLINE</div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>/assets/js/main.js?v=<?= date('YmdHi') ?>"></script>
</body>
</html>

