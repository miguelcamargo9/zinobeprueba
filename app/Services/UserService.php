<?php

namespace App\Services;

use App\Models\User;
use Respect\Validation\Validator;

class UserService
{
    public function addUser($userData)
    {
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
                return "Usuario Creado con éxito";
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
            return $userInvalid;
        }
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
