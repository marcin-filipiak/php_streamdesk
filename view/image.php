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
</head>

<body class="bg-light">
<div class="container py-4 text-center">

    <a href="index.php?op=index" class="btn btn-secondary mb-3">← Powrót</a>

    <div class="card shadow">
        <img src="<?= htmlspecialchars($this->imageUrl) ?>"
             class="img-fluid"
             alt="obraz"
             onerror="this.onerror=null;this.src='<?= DEFAULT_OFFLINE ?>';">
    </div>

</div>
</body>
</html>

