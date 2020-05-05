<?php
namespace Application\Core;


class PasswordMaster
{
    /**
     * Возвращает хэш пароля
     *
     * @param string $password
     * @return string
     */
    public static function getPasswordHash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Сравнивает пароль с хэшем
     *
     * @param string $password
     * @param string $hash
     * @return boolean
     */
    public static function verify($password, $hash)
    {
        return password_verify($password, $hash);
    }
}