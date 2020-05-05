<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/src/styles/style.css">
</head>

<body>
    <div class="pl-3 bg-dark">
        <div class="container d-flex align-items-center">
            <a class="navbar-brand text-light" href="/<?= getLang() ?>/">My register form</a>
            <?php if (empty($_SESSION['authenticated'])) { ?>
                <a class="nav-link text-white bg-primary" href="/<?= getLang() ?>/login"> <?= __('login') ?> </a>
                <a class="nav-link text-white bg-primary" href="/<?= getLang() ?>/register"><?= __('registration') ?></a>
            <?php } ?>
            <a class="ml-3 mr-3" href="/ru/<?= substr($_SERVER['REQUEST_URI'], 4) ?>">
                <image class="lang-icon" src="/src/images/ru_icon.svg" /></a>
            <a href="/en/<?= substr($_SERVER['REQUEST_URI'], 4) ?>">
                <image class="lang-icon" src="/src/images/en_icon.svg" /></a>
            <?php if (!empty($_SESSION['authenticated'])) { ?>
                <a href="/<?= getLang() ?>/login/logout" class="nav-link text-white bg-danger ml-auto"><?= __('logout') ?></a>
            <?php } ?>
        </div>
    </div>
    <div class="container">
        <?php include $content; ?>
    </div>
</body>

</html>