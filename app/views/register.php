<html>

<head>
    <title>Регистрация</title>
    <script src="/src/js/register.js"></script>
</head>

<body>
    <div class="register-form">
        <div class="card mt-5">
            <div class="card-body">
                <h2 class="card-title"> <?= __('registration') ?> </h2>
                <form id="register" method="POST"
                    action="/<?= getLang() ?>/register/register"
                    enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label> <?= __('first name') ?> </label>
                            <input
                                class="form-control <?= (isset($data['errors']['first_name']) ? 'is-invalid' : '') ?>"
                                name="first_name" value="<?= $data['data']['first_name'] ?? '' ?>" placeholder="<?= __('placeholders.first name') ?>"
                                title="<?= __('how call you') ?>" required>
                            <div class="invalid-feedback">
                                <?= $data['errors']['first_name'] ?? '' ?>
                            </div>

                        </div>
                        <div class="form-group col-md-6">
                            <label> <?= __('last name') ?> </label>
                            <input class="form-control <?= (isset($data['errors']['last_name']) ? 'is-invalid' : '') ?>"
                                name="last_name" value="<?= $data['data']['last_name'] ?? '' ?>" placeholder="<?= __('placeholders.last name') ?>"
                                title="<?= __('how call you') ?>" required>
                            <div class="invalid-feedback">
                                <?= $data['errors']['last_name'] ?? '' ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label><?= __('email') ?></label>
                            <input class="form-control <?= (isset($data['errors']['email']) ? 'is-invalid' : '') ?>"
                                value="<?= $data['data']['email'] ?? '' ?>" name="email" type="email" 
                                placeholder="supercool2000@yahoo.com" required
                                title="<?= __('letter will be sent') ?>" >
                            <div class="invalid-feedback">
                                <?= $data['errors']['email'] ?? '' ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label><?= __('birth date') ?></label>
                            <input class="form-control <?= isset($data['errors']['birth_date']) ? 'is-invalid' : '' ?>"
                                max="<?= (new DateTime)->format('Y-m-d'); ?>" required
                                value="<?= $data['data']['birth_date'] ?? '' ?>" name="birth_date" type="date" >
                            <div class="invalid-feedback">
                                <?= $data['errors']['birth_date'] ?? '' ?>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label><?= __('gender') ?></label>
                            <select class="form-control <?= (isset($data['errors']['gender']) ? 'is-invalid' : '') ?>"
                                name="gender" value="<?= $data['data']['gender'] ?? 'male' ?>" required>
                                <option <?= (isset($data['data']['gender']) && $data['data']['gender'] == 'male') ? 'selected' : '' ?> value="male"><?= __('genders.male') ?></option>
                                <option <?= (isset($data['data']['gender']) && $data['data']['gender'] == 'female') ? 'selected' : '' ?> value="female"><?= __('genders.female') ?></option>
                            </select>
                            <div class="invalid-feedback">
                                <?= $data['errors']['gender'] ?? '' ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label><?= __('password') ?></label>
                            <input class="form-control <?= (isset($data['errors']['password']) ? 'is-invalid' : '') ?>"
                                id="password" name="password" type="password" required>
                            <div class="invalid-feedback">
                                <?= $data['errors']['password'] ?? '' ?>
                            </div>

                        </div>
                        <div class="form-group col-md-6">
                            <label><?= __('password confirmation') ?></label>
                            <input
                                class="form-control <?= (isset($data['errors']['password_confirmation']) ? 'is-invalid' : '') ?>"
                                name="password_confirmation" type="password" id="password_confirmation" required
                                data-toggle="tooltip" data-placement="bottom" title="<?= __('passwords must be same') ?>">
                            <div class="invalid-feedback">
                                <?= $data['errors']['password_confirmation'] ?? '' ?>
                            </div>

                        </div>
                    </div>
                    <div class="form-row password-rules p-2">
                        <strong class="mb-2 col-12"><?= __('password must contain') ?> </strong>
                        <span class="col-md-5 password-rule">
                            <span class="circle"></span><span class="rule" id="rule-length"><?= __('pwd rules.length') ?></span>
                        </span>
                        <span class="col-md-5 password-rule">
                            <span class="circle"></span><span class="rule" id="rule-upper"><?= __('pwd rules.upper letters') ?></span>
                        </span>
                        <span class="col-md-5 password-rule">
                            <span class="circle"></span><span class="rule" id="rule-digit"><?= __('pwd rules.digit') ?></span>
                        </span>
                    </div>
                    <div class="mt-3">
                        <input type="hidden" name="MAX_FILE_SIZE" value="<?= 10 * 1024 * 1024 ?>" />
                        <input class="input-file <?= (isset($data['errors']['avatar']) ? 'is-invalid' : '') ?>"
                            accept="image/*" type="file" name="avatar" id="input-file"/>
                        <label id="label-file" class="btn <?= (isset($data['errors']['avatar']) ? 'btn-danger' : 'btn-success') ?> w-100" for="input-file"><?= __('choose image') ?></label>
                        <div class="invalid-feedback">
                            <?= $data['errors']['avatar'] ?? '' ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary float-right"><?= __('register') ?></button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>