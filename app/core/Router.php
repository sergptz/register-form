<?php
namespace Application\Core;

class Router
{
    /**
     * Производит адресацию запросов в методы контроллеров
     *
     * @return void
     */
    public static function handle()
    {
        $controllerPrefix = 'login';
        $action = 'index';
        $offset = 0;

        $pathData = explode('/', $_SERVER['REQUEST_URI']);

        if (LangService::langIsSupported($pathData[1])) {
            $lang = $pathData[1];
            LangService::setLang($lang);
            $offset++;
        } else {
            $lang = LangService::getLang();
            header('location:/' . $lang . $_SERVER['REQUEST_URI']);
            die();
        }

        if (!empty($pathData[1 + $offset])) {
            $controllerPrefix = $pathData[1 + $offset];
        }
        if (!empty($pathData[2 + $offset])) {
            $action = $pathData[2 + $offset];
        }

        if ($controllerPrefix == 'profile' && !Auth::isLogged()) {
            self::redirectTo('login');
            die();
        }

        if (($controllerPrefix == 'login' || $controllerPrefix == 'register') && $action != 'logout' && Auth::isLogged()) {
            self::redirectTo('profile');
            die();
        }

        $controllerName = '\\Application\\Controllers\\' . strtoupper($controllerPrefix[0]) . substr($controllerPrefix, 1) . 'Controller';

        if (class_exists($controllerName)) {
            $instance = new $controllerName;
        } else {
            self::errorPage();
        }

        if (method_exists($instance, $action)) {
            $instance->$action();
        } else {
            self::errorPage();
        }
    }

    /**
     * Перенаправляет по указанному в $path пути
     *
     * @param string $path
     * @return void
     */
    public static function redirectTo($path)
    {
        if ($path[0] != '/') {
            $path = '/' . $path;
        }
        $lang = LangService::getLang();
        $pathData = explode('/', $path);
        if (!LangService::langIsSupported($pathData[1])) {
            $path = "/{$lang}{$path}";
        }
        header("location: $path");
        die();
    }

    /**
     * Перенаправляет на страницу ошибки
     *
     * @return void
     */
    public static function errorPage()
    {
        self::redirectTo('error');
        die();
    }
}