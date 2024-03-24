<?php

declare(strict_types=1);

namespace Code\Models;

use Code\Models\Queries;

class UserModel
{
    public function __construct(private Queries $query)
    {
    }

    public function loginUser()
    {
        $nome = $_POST["user"];
        $senha = $_POST["senha"];

        $result = $this->query->returnSql("SELECT id FROM usuarios WHERE user = ? AND senha = ? ", [$nome, $senha]);

        if (!empty($result)) {
            $_SESSION['id'] = $result['id'];
            header('Location: /perfil');
        } else {
            return "Usuário ou senha inválidos";
        }
    }

    public function registerUser()
    {
        $user = $_POST["user"];
        $senha1 = $_POST["senha1"];
        $senha2 = $_POST["senha2"];

        if ($senha1 === $senha2) {
            $userLen = strlen($user);
            $senhaLen = strlen(($senha1));

            if($userLen > 1 && $userLen < 50 && $senhaLen > 1 && $senhaLen < 15){
                $result = $this->query->returnSql("SELECT user FROM usuarios WHERE user = ?", [$user]);
            } else {
                return 'Dados Inválidos';
            }           

            if (!empty($result)) {
                return 'Usuário já cadastrado';
            } else {
                $_SESSION['id'] = $this->query->simpleSql("INSERT INTO usuarios (user, senha) VALUES (?, ?)", [$user, $senha1], true);
                header('Location: /perfil');
            }
        } else {
            return 'Senhas diferentes';
        }
    }
}
