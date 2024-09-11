<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function registerUser(array $data): bool
    {
        $email = $data['email'];
        $password = Hash::make($data['pass1'], ['rounds' => 12]);
           
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
