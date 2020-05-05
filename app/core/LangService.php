<?php

namespace Application\Core;

class LangService
{
    private const SUPPORTED_LANGS = ['en', 'ru'];

    public static $translations = [];

    /**
     * Проверяет, поддерживается ли язык $lang
     *
     * @param [type] $lang
     * @return boolean
     */
    public static function langIsSupported($lang)
    {
        return in_array($lang, self::SUPPORTED_LANGS);
    }


    /**
     * Возвращает язык, сохранённый в $_SESSION, 
     * или анализирует HTTP_ACCEPT_LANGUAGE и возвращает 
     * первый поддерживаемый язык
     *
     * @return string
     */
    public static function getLang()
    {
        if (isset($_SESSION['lang']) && self::langIsSupported($_SESSION['lang'])) {
            $lang = $_SESSION['lang'];
        } elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
            echo '<pre>' . print_r('$langs') . '</pre>';
            array_walk($langs, function (&$lang) {
                $lang = strtok($lang, ';');
            });
            foreach ($langs as $l) {
                if (self::langIsSupported($l)) {
                    $lang = $l;
                    break;
                }
            }
        }
        return $lang ?? self::SUPPORTED_LANGS[0];
    }

    /**
     * Сохраняет указанный язык в $_SESSION
     *
     * @param [type] $lang
     * @return boolean
     */
    public static function setLang($lang)
    {
        if (self::langIsSupported($lang)) {
            $_SESSION['lang'] = $lang;
            $filePath = "{$_SERVER['DOCUMENT_ROOT']}/lang/{$lang}.php";
            if (file_exists($filePath)) {
                self::$translations = include $filePath;
            } else {
                self::$translations = [];
            }
            return true;
        } else {
            throw new \RuntimeException('This language is not supported');
        }
    }

    /**
     * Возвращает перевод по указанному ключу.
     * Поддерживает вложенные ключи через . (например 'validation.required')
     *
     * @param [type] $key
     * @return void
     */
    public static function translate($key)
    {
        $keys = explode('.', $key);
        if (count($keys) == 1) {
            return self::$translations[$key] ?? $key;
        }
        $translation = self::$translations[$keys[0]];
        if (empty($translation)) {
            return $key;
        }
        unset($keys[0]);
        foreach ($keys as $k) {
            if (isset($translation[$k]))
                $translation = $translation[$k];
            else
                return $k;
        }
        return $translation;
    }
}
