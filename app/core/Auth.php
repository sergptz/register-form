<?php
namespace Application\Core;

use Application\Models\User;

class Auth
{

    /**
     * Проверяет правильность данных пользователя и сохраняет данные о нем в $_SESSION
     * Возращает массив со статусом выполнения авторизации и массивом ошибок, если такие есть
     *
     * @param string $email
     * @param string $password
     * @return array
     */
    public static function login($email, $password)
    {
        $user = (new User)->get('*', ['email' => $email])[0] ?? false;
        if ($user === false) {
            return ['success' => false, 'errors' => ['email' => __('email not found')]];
        } elseif (!PasswordMaster::verify($password, $user['password_hash'])) {
            return ['success' => false, 'errors' => ['password' => __('wrong password')]];
        }
        $_SESSION['user_email'] = $email;
        $_SESSION['authenticated'] = true;
        return ['success' => true];
    }

    /**
     * Удаляет данные о пользователе из $_SESSION
     *
     * @return void
     */
    public static function logout()
    {
        $_SESSION['user_email'] = null;
        $_SESSION['authenticated'] = null;
    }

    /**
     * Проверяет, авторизован ли какой-нибудь пользователь
     *
     * @return boolean
     */
    public static function isLogged()
    {
        return !empty($_SESSION['authenticated']) && !empty($_SESSION['user_email']);
    }

    /**
     * Возвращает информацию об авторизованном пользователе или false, если такого нет
     *
     * @return void
     */
    public static function getUser()
    {
        if (self::isLogged()) {
            return (new User)->get('*', ['email' => $_SESSION['user_email']])[0] ?? false;
        } else {
            return false;
        }
    }
}