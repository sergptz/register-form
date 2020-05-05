<?php
require_once('vendor/autoload.php');
use Application\Core\LangService;
use Application\Core\Router;

session_start();

function __($key)
{
    return LangService::translate($key);
}

function getLang()
{
    return LangService::getLang();
}

Router::handle();