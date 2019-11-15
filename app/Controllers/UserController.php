<?php

namespace App\Controllers;

use App\Models\{User, Country};
use Respect\Validation\Validator;

class UserController extends BaseController
{
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

        $userInvalid = $this->validateUser($userData);

        if (!$userInvalid) {
            try {
                $user = new User();
                $user->name = $userData['inputName'];
                $user->document = $userData['inputDocument'];
                $user->email = $userData['inputEmail'];
                $user->password = password_hash($userData['inputPassword'], PASSWORD_DEFAULT);
                $user->country = $userData['inputCountry'];
                $user->save();
                $responseMessage = "Usuario Creado con éxito";
            } catch (\Exception $e) {
                $responseMessage = $e->getMessage();
            }
        } else {
            $responseMessage = $userInvalid;
        }
        return $this->renderHTML('addUser.twig', ['responseMessage' => $responseMessage, 'countries' => $countries]);
    }

    public function validateUser($userData)
    {
        $userValidator = Validator::key('inputName', Validator::stringType()->length(3))
            ->key('inputDocument', Validator::stringType()->notEmpty())
            ->key('inputEmail', Validator::email()->notEmpty())
            ->key('inputPassword', Validator::stringType()->length(6));

        $userDocument = User::where('document',  $userData['inputDocument'])->first();

        $userEmail = User::where('email', $userData['inputEmail'])->first();

        if (!$userDocument) {
            if (!$userEmail) {
                try {
                    $userValidator->assert($userData);
                    return false;
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
            } else {
                return "Correo " . $userData['inputEmail'] . " repetido.";
            }
        } else {
            return "Documento " . $userData['inputDocument'] . " repetido.";
        }
    }
}
