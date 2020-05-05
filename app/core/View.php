<?php
namespace Application\Core;

class View
{
    /**
     * Генерирует представление
     * $defaultTemplate - стандартный шаблон, в подключается $content 
     * $data - используемые в представлении данные
     *
     * @param string $content
     * @param string $defaultTemplate
     * @param array $data
     * @return void
     */
    public function generate($content, $defaultTemplate = null, $data = null)
    {
        include  $defaultTemplate ?? $_SERVER['DOCUMENT_ROOT'] . '/app/views/defaultTemplate.php';
    }
}