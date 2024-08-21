<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;

class UserService
{

    public function loginUser(array $data): bool|string
    {
        $email = $data["email"];
        $senha = $data["senha"];

        $result = User::select('id')
            ->where('email', $email)
            ->where('password', $senha)
            ->get()->toArray();

        if (!empty($result)) {
            session()->put('id', $result[0]['id']);
            return true;
        } else {
            return "Usuário ou senha inválidos";
        }
    }

    public function registerUser(array $data)
    {
        $email = $data['email'];
        $nome = $data["nome"];
        $senha1 = $data["senha1"];
        $senha2 = $data["senha2"];
        $sobrenome = $data['sobrenome'];
        $estado = $data['estado'];
        $cidade = $data['cidade'];

        if ($senha1 === $senha2) {
            $nomeLen = strlen($nome);
            $senhaLen = strlen(($senha1));
            $emailLen = strlen(($email));
            $sobrenomeLen = strlen(($sobrenome));
            $estadoLen = strlen(($estado));
            $cidadeLen = strlen(($cidade));

            $testNome = $nomeLen > 1 && $nomeLen <= 50;
            $testSenha = $senhaLen > 1 && $senhaLen <= 50;
            $testEmail = $emailLen > 1 && $emailLen <= 50;
            $testSobrenome = $sobrenomeLen > 1 && $sobrenomeLen <= 50;
            $testEstado = $estadoLen > 1 && $estadoLen <= 50;
            $testCidade = $cidadeLen > 1 && $nomeLen <= 50;

            if ($testNome && $testSenha && $testEmail && $testSobrenome && $testEstado && $testCidade) {
                $result = User::select('email')
                    ->where('email', $email)
                    ->get()->toArray();
            } else {
                return 'Dados Inválidos';
            }

            if (!empty($result)) {
                return 'Usuário já cadastrado';
            } else {
                session()->put('id', User::insertGetId([
                    'email' => $email,
                    'password' => $senha1,
                    'name' => $nome,
                    'lastname' => $sobrenome,
                    'state' => $estado,
                    'city' => $cidade,
                ]));
                return true;
            }
        } else {
            return 'Senhas diferentes';
        }
    }
}
