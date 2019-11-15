<?php

namespace App\Controllers;

use App\Models\User;
use Zend\Diactoros\Response\RedirectResponse;

class AuthController extends BaseController
{
    public function getLogin()
    {
        return $this->renderHTML('login.twig');
    }

    public function postLogin($request)
    {
        $responseMessage = null;
        $postData = $request->getParsedBody();
        $user = User::where('email', $postData['inputEmail'])->first();
        if ($user) {
            if (password_verify($postData['inputPassword'], $user->password)) {
                $_SESSION['userID'] = $user->ID;
                return new RedirectResponse('/');
            } else {
                $responseMessage = "Login Incorrecto";
            }
        } else {
            $responseMessage = "Login Incorrecto";
        }

        return $this->renderHTML('login.twig', ['responseMessage' => $responseMessage]);
    }

    public function getLogout()
    {
        unset($_SESSION['userID']);
        return new RedirectResponse('/login');
    }
}
