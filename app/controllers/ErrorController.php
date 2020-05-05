<?php
namespace Application\Controllers;
use Application\Core\Controller;

class ErrorController extends Controller
{
    public function index()
    {
        $this->view->generate($_SERVER['DOCUMENT_ROOT'] . '/app/views/error.php');
    }
}