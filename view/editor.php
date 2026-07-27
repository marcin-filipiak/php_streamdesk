<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="author" content="Marcin Filipiak">
    <meta name="application-name" content="StreamDesk">
    <meta name="repository" content="https://github.com/marcin-filipiak/php_streamdesk">
    <meta property="og:url" content="https://github.com/marcin-filipiak/php_streamdesk">
    <title>Editor – <?= htmlspecialchars(SITE_TITLE) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">

<?php if (!$logged): ?>
    <h3 class="mb-3">Logowanie</h3>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="index.php?op=editor">
        <div class="mb-3">
            <label class="form-label">Haslo</label>
            <input type="password" name="password" class="form-control">
        </div>
        <button class="btn btn-primary">Zaloguj</button>
    </form>

<?php else: ?>

    <div class="row">
        <div class="col-md-7">
            <h3 class="mb-3">Edycja zrodel danych</h3>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="post" action="index.php?op=editor&action=save">
                <textarea name="json" class="form-control" rows="25"><?= htmlspecialchars($jsonContent) ?></textarea>
                <button class="btn btn-success mt-3">Zapisz</button>
                <a class="btn btn-warning mt-3" href="index.php?op=editor&action=logout">Wyloguj</a>
            </form>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Dostepne pluginy</h5>
                </div>
                <div class="card-body">
                    <?php $i = 0; $total = count($plugins); ?>
                    <?php foreach ($plugins as $p): ?>
                        <div class="mb-3">
                            <h6 class="fw-bold"><?= htmlspecialchars($p['name']) ?> <span class="badge bg-secondary"><?= htmlspecialchars($p['type']) ?></span></h6>
                            <p class="mb-1 small"><?= htmlspecialchars($p['description']) ?></p>
                            <p class="mb-1 small text-muted">Uzycie: <?= htmlspecialchars($p['usage']) ?></p>
                            <code class="small"><?= htmlspecialchars($p['example']) ?></code>
                        </div>
                        <?php if (++$i < $total): ?><hr><?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>

</div>

<footer class="text-center text-muted py-3 small border-top mt-4">
    <a href="https://github.com/marcin-filipiak/php_streamdesk" target="_blank" class="text-decoration-none text-muted">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
            <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0 0 16 8c0-4.42-3.58-8-8-8"/>
        </svg>
        StreamDesk na GitHub
    </a>
</footer>

</body>
</html>