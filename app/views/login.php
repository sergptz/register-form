<html>

<head>
    <title>Вход</title>
</head>

<body>
    <div class="mt-5 login-form">
        <div class="card ">
            <div class="card-body">
                <h2><?= __('login') ?></h2>
                <form method="POST" action="/<?= getLang() ?>/login/login">
                    <div class="form-group">
                        <label><?= __('email') ?></label>
                        <input class="form-control <?= isset($data['errors']['email']) ? 'is-invalid' : '' ?>"
                            name="email" type="email" value="<?= $data['data']['email'] ?? '' ?>" required>
                        <div class="invalid-feedback">
                            <?= $data['errors']['email'] ?? '' ?>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label><?= __('password') ?></label>
                        <input class="form-control <?= isset($data['errors']['password']) ? 'is-invalid' : '' ?>"
                            name="password" type="password" required>
                        <div class="invalid-feedback">
                            <?= $data['errors']['password'] ?? '' ?>
                        </div>
                    </div>
                    <span><?= __('no account?') ?> <a href="/register"> <?= __('register!') ?> </a> </span>
                    <button type="submit" class="btn btn-success float-right"> <?= __('enter') ?> </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
