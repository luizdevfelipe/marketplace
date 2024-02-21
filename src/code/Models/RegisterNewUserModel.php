<?php

declare(strict_types=1);

namespace Code\Models;

use Code\Models\Queries;

class RegisterNewUserModel
{
    public function __construct(private Queries $query)
    {
    }

    public function registerUser()
    {
        if (count($_POST) == 2) {
            $nome = $_POST["user"];
            $senha = $_POST["senha"];

            $result = $this->query->returnSql("SELECT id FROM usuarios WHERE user = ? AND senha = ? ", [$nome, $senha]);

            if ($result !== null) {
                header('Location: /perfil');
                $_SESSION['id'] = $vet["id"];
            } else {
                $erro = "Usuário ou senha inválidos";
                $cor = "text-danger";
            }
        }
    }

    public function loginUser()
    {
        $user = $_POST["user"];
        $senha1 = $_POST["senha1"];
        $senha2 = $_POST["senha2"];

        if ($senha1 === $senha2) {            

            $result = $this->query->returnSql("SELECT user FROM usuarios WHERE user = ?", [$user]);

            if ($result !== null) {
                $p = "Registrar()";
                $erro = 'Usuário já cadastrado!';
                $cor = "text-danger";
            } else {
                $this->query->simpleSql("INSERT INTO usuarios (user, senha) VALUES (?, ?)", [$user, $senha1]);
                $erro = "Cadastro Realizado!";
                $cor = "text-success";
            }
        } else {
            $erro = 'Senhas Diferentes!';
            $cor = "text-danger";
            $p = "Registrar()";
        }
    }
}
