<?php

namespace App\Services;

use App\Models\Directory;
use App\Services\CustomerData;

class DirectoryService
{
    public function getLoadDir($uri)
    {
        $directoryUsers = CustomerData::getLoadDir($uri);
        foreach ($directoryUsers->objects as $directoryUser) {
            $email = $directoryUser->correo ?? $directoryUser->email;
            $ddUser = Directory::where('email',  $email)->first();

            if (!$ddUser) {
                $ddUser = new Directory();
                $ddUser->position = $directoryUser->cargo ?? $directoryUser->job_title;
                $ddUser->email = $email;
                $ddUser->document = $directoryUser->cedula ?? $directoryUser->document;
                $ddUser->name = $directoryUser->primer_nombre ?? $directoryUser->first_name;
                $ddUser->lastname = $directoryUser->apellido ?? $directoryUser->last_name;
                $ddUser->phone = $directoryUser->telefono ?? $directoryUser->phone_number;
                $ddUser->country = $directoryUser->pais ?? $directoryUser->country;
                $ddUser->city = $directoryUser->ciudad ?? $directoryUser->city;
                $ddUser->department = $directoryUser->departamento ?? $directoryUser->state;
                $ddUser->birthdate = $directoryUser->fecha_nacimiento ?? null;
                $ddUser->save();
            }
        }

        return Directory::all();
    }

    public function search($search)
    {
        return Directory::where('email',  $search)->orWhere('name', $search)->get() ?? [];
    }
}
