<?php

namespace App\Controllers;

use App\Services\DirectoryService;

class DirectoryController extends BaseController
{

    private $directoryService;

    public function __construct(DirectoryService $directoryService)
    {
        parent::__construct();
        $this->directoryService = $directoryService;
    }

    public function getLoadDir1()
    {
        $directory = $this->directoryService->getLoadDir("http://www.mocky.io/v2/5d9f39263000005d005246ae");
        return $this->renderHTML('directory.twig', ['directory' => $directory]);
    }

    public function getLoadDir2()
    {
        $directory = $this->directoryService->getLoadDir("http://www.mocky.io/v2/5d9f38fd3000005b005246ac");
        return $this->renderHTML('directory.twig', ['directory' => $directory]);
    }
}
