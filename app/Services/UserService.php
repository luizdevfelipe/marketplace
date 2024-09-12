<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function registerUser(array $data): bool|int
    {
        $result = User::select('email')
            ->where('email', $data['email'])
            ->get()->toArray();    

        if (!empty($result)) {
            return false;
        }

        return User::insertGetId([
            'email' => $data['email'],
            'password' => Hash::make($data['pass1'], ['rounds' => 12]),
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'state' =>  $data['state'],
            'city' => $data['city'],
        ]);
    }
}
