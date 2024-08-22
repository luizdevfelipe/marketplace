<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;

class UserService
{

    public function loginUser(array $data): bool
    {
        $result = User::select('id')
            ->where('email',  $data["email"])
            ->where('password', $data["senha"])
            ->get()->toArray();

        if (!empty($result)) {
            session()->put('id', $result[0]['id']);
            return true;
        } 
        return false;
    }

    public function registerUser(array $data): bool
    {
        $email = $data['email'];
        $password = $data['pass1'];
           
        $result = User::select('email')
            ->where('email', $email)
            ->get()->toArray();    

        if (!empty($result)) {
            return false;
        }

        session()->put('id', User::insertGetId([
            'email' => $email,
            'password' => $password,
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'state' =>  $data['state'],
            'city' => $data['city'],
        ]));
        return true;                
    }
}
