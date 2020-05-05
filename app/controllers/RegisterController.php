<?php

namespace Application\Controllers;

use Application\Core\Controller;
use Application\Core\FileMaster;
use Application\Models\User;
use Application\Core\PasswordMaster;
use Application\Core\Router;
use RuntimeException;

class RegisterController extends Controller
{
    public function index($data = [])
    {
        $this->view->generate($_SERVER['DOCUMENT_ROOT'] . '/app/views/register.php', null, $data);
    }

    public function register()
    {
        $data = User::sanitizeData($_POST);
        $validationResult = User::validateData($data, 'register');

        $userExists = (new User)->get("COUNT(*) as count", ['email' => $data['email']])[0]['count'] > 0;
        if ($userExists) {
            $this->index(['data' => $data, 'errors' => ['email' => __('validation.email exists')]]);
            die();
        }

        if ($validationResult['success'] !== true) {
            $this->index(['data' => $data, 'errors' => $validationResult['errors']]);
            die();
        }

        try {
            $avatarPath = FileMaster::upload($_FILES['avatar']);
        } catch (RuntimeException $e) {
            $this->index(['data' => $data, 'errors' => ['avatar' => $e->getMessage()]]);
            die();
        }

        $data['password_hash'] = PasswordMaster::getPasswordHash($data['password']);
        unset($data['password']);
        unset($data['password_confirmation']);

        $data['avatar_path'] = $avatarPath;

        $user = new User($data);
        try {
            $user->save();
            Router::redirectTo('register/thanks');
        } catch (\Throwable $e) {
            print_r("Error saving user: $e");
            die();
        }
    }

    public function thanks()
    {
        $this->view->generate($_SERVER['DOCUMENT_ROOT'] . '/app/views/thanks.php');
    }
}
