<?php

namespace Application\Core;

use Exception;
use finfo;
use RuntimeException;

class FileMaster
{

    public const TYPES = [
        'image'
    ];

    public const PATHS_BY_TYPES = [
        'image' => '/images/'
    ];

    public const EXTENSIONS_BY_TYPES = [
        'image' => [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif'
        ]
    ];

    public const MAX_SIZE = 10 * 1024 * 1024;

    /**
     * Загружает файл на сервер и возвращает путь к файлу
     *
     * @param file $file
     * @param string $type
     * @return void
     */
    public static function upload($file, $type = 'image')
    {
        if (!in_array($type, self::TYPES)) {
            throw new Exception('Wrong file type');
        }
        if (!isset($file['error']) || is_array($file['error'])) {
            throw new RuntimeException(__('filemaster.failed'));
        }
        switch ($file['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new RuntimeException(__('filemaster.no file'));
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new RuntimeException(__('filemaster.too large'));
            default:
                throw new RuntimeException(__('filemaster.failed'));
        }
        if ($file['size'] > self::MAX_SIZE) {
            throw new RuntimeException(__('filemaster.size limit') . self::MAX_SIZE / 1024 . ' ' . __('filemaster.kb'));
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $ext = self::EXTENSIONS_BY_TYPES[$type][$finfo->file($file['tmp_name'])] ?? false;
        if ($ext === false) {
            throw new RuntimeException(__('filemaster.invalid'));
        }
        
        $path = self::PATHS_BY_TYPES[$type] . sha1_file($file['tmp_name']) . '.' . $ext;
        
        if (!move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $path)) {
            throw new RuntimeException(__('filemaster.failed'));
        }

        return $path;
    }
}