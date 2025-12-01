<!doctype html>
<html lang="pl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
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
            <label class="form-label">Hasło</label>
            <input type="password" name="password" class="form-control">
        </div>
        <button class="btn btn-primary">Zaloguj</button>
    </form>

<?php else: ?>

    <h3 class="mb-3">Edycja pliku JSON</h3>

    <form method="post" action="index.php?op=editor&action=save">
        <textarea name="json" class="form-control" rows="25"><?= htmlspecialchars($jsonContent) ?></textarea>
        <button class="btn btn-success mt-3">Zapisz</button>
        <a class="btn btn-secondary mt-3" href="index.php?op=index">Powrót</a>
    </form>

<?php endif; ?>

</div>

</body>
</html>

