<?php

namespace App\Controllers;

use Zend\Diactoros\Response\HtmlResponse;

class BaseController
{
    protected $templateEngine;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('../views');
        $this->templateEngine = new \Twig\Environment($loader, [
            'debud' => true,
            'cache' => false,
        ]);
    }

    public function renderHTML($fileNme, $data = [])
    {
        return new HtmlResponse($this->templateEngine->render($fileNme, $data));
    }
}
