<!DOCTYPE html>
<html>

<head>
    <title><?= __('profile') ?></title>
    <script src="/src/js/profile.js"></script>
</head>

<body>
    <div class="card profile-block mt-5">
        <div class="card-body">
            <h2 class="card-title"><?= __('profile') ?></h2>
            <div class="row">
                <div class="col-lg-6">
                    <div class="d-flex flex-column justify-content-center align-items-center h-100">
                        <image src="<?= $data['data']['avatar_path'] ?? '' ?>" class="avatar-img" />
                        <form id="avatar-form" class="mt-4" action="/<?= getLang() ?>/profile/updateAvatar"
                            method="POST" enctype="multipart/form-data">
                            <div class="form-group col-md-12">
                                <input class="input-file <?= (isset($data['errors']['avatar']) ? 'is-invalid' : '') ?>"
                                    id="input-file" type="file" name="avatar" accept="image/*" />
                                <label id="label-file" class="btn btn-success"
                                    for="input-file"><?= __('change image') ?></label>
                                <div class="invalid-feedback">
                                    <?= $data['errors']['avatar'] ?? '' ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-6 profile-data">
                    <div class="form-row">
                        <div class="col-12">
                            <div class="form-group">
                                <span><?= __('first name') ?></span>
                                <p class="form-control"><?= $data['data']['first_name'] ?></p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <span><?= __('last name') ?></span>
                                <p class="form-control"><?= $data['data']['last_name'] ?></p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <span><?= __('birth date') ?></span>
                                <p class="form-control"><?= $data['data']['birth_date'] ?></p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <span><?= __('email') ?></span>
                                <p class="form-control"><?= $data['data']['email'] ?></p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <span><?= __('gender') ?></span>
                                <p class="form-control"><?= __('genders.' . $data['data']['gender']) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
