<?php

namespace App\Controllers;

use App\Models\User;

class UserController extends BaseController
{
    public function getAddUserAction()
    {
        echo $this->renderHTML('addUser.twig');
    }

    public function saveAddUserAction($request)
    {
        $userData = $request->getParsedBody();
        $user = new User();
        $user->name = $userData['inputName'];
        $user->document = $userData['inputDocument'];
        $user->email = $userData['inputEmail'];
        $user->password = $userData['inputPassword'];
        $user->country = "CO";
        $user->save();
    }
}
