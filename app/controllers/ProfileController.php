<?php

namespace Application\Controllers;

use Application\Core\Auth;
use Application\Core\Controller;
use Application\Core\FileMaster;
use Application\Core\Router;
use Application\Models\User;

class ProfileController extends Controller
{
    public function index($errors = [])
    {
        $user = Auth::getUser();
        if ($user !== false) {
            $this->view->generate($_SERVER['DOCUMENT_ROOT'] . '/app/views/profile.php', null, ['data' => $user, 'errors' => $errors]);
        } else {
            Router::redirectTo('login');
        }
    }

    public function updateAvatar()
    {
        try {
            $avatarPath = FileMaster::upload($_FILES['avatar']);
        } catch (\RuntimeException $e) {
            $this->index(['avatar' => $e->getMessage()]);
            die();
        }
        $user = Auth::getUser();
        (new User)->update($user['id'], ['avatar_path' => $avatarPath]);
        Router::redirectTo('profile');
    }
}
