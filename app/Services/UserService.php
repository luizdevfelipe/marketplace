<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;

class UserService
{

    public function loginUser()
    {
        $email = $_POST["email"];
        $senha = $_POST["senha"];

        $result = User::select('id')
            ->where('email', $email)
            ->where('senha', $senha)
            ->get()->toArray();   

        if (!empty($result)) {
            $_SESSION['id'] = $result[0]['id'];
            header('Location: /perfil');
        } else {
            return "Usuário ou senha inválidos";
        }
    }

    public function registerUser()
    {
        $email = $_POST['email'];
        $nome = $_POST["nome"];
        $senha1 = $_POST["senha1"];
        $senha2 = $_POST["senha2"];
        $sobrenome = $_POST['sobrenome'];
        $estado = $_POST['estado'];
        $cidade = $_POST['cidade'];

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
                User::select('email')
                    ->where('email', $email)
                    ->get()->toArray();
            } else {
                return 'Dados Inválidos';
            }

            if (!empty($result)) {
                return 'Usuário já cadastrado';
            } else {
                $_SESSION['id'] = User::insertGetId([
                    'email' => $email,
                    'senha' => $senha1,
                    'nome' => $nome,
                    'sobrenome' => $sobrenome,
                    'estado' => $estado,
                    'cidade' => $cidade,
                ]);             
                header('Location: /perfil');
            }
        } else {
            return 'Senhas diferentes';
        }
    }
}