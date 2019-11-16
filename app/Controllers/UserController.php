<?php

namespace App\Controllers;

use App\Models\Country;
use App\Services\UserService;

class UserController extends BaseController
{

    private $userService;

    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }

    public function getAddUserAction()
    {
        $countries = Country::all();
        return $this->renderHTML('addUser.twig', ['responseMessage' => null, 'countries' => $countries]);
    }

    public function saveAddUserAction($request)
    {
        $responseMessage = null;
        $countries = Country::all();
        $userData = $request->getParsedBody();
        $responseMessage = $this->userService->addUser($userData);
        return $this->renderHTML('addUser.twig', ['responseMessage' => $responseMessage, 'countries' => $countries]);
    }
}
