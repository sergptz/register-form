<?php
namespace Application\Controllers;

use Application\Core\Auth;
use Application\Core\Controller;
use Application\Core\LangService;
use Application\Core\Router;
use Application\Models\User;

class LoginController extends Controller
{
    public function index($data = [])
    {
        $this->view->generate('app/views/login.php', null, $data);
    }

    public function login()
    {
        $data = User::sanitizeData($_POST);
        $validationResult = User::validateData($data);

        if ($validationResult['success'] === false) {
            $this->index(['data' => $_POST, 'errors' => $validationResult['errors']]);
            die();
        } else {
            $loginResult = Auth::login($data['email'], $data['password']);
            if (!$loginResult['success']) {
                $this->index(['data' => $data, 'errors' => $loginResult['errors']]);
                die();
            }
        }
        Router::redirectTo('profile');
    }

    public function logout()
    {
        Auth::logout();
        $lang = LangService::getLang();
        header("location: /$lang/");
    }
}