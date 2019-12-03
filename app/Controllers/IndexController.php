<?php

namespace App\Controllers;

use App\Models\User;

class IndexController extends BaseController
{
    public function indexAction()
    {
        $users = User::all();
        return $this->renderHTML('index.twig', [
            "users" => $users
        ]);
    }
}
