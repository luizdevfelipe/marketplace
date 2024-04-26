<?php

declare(strict_types=1);

namespace Code\Service;

class UserService
{

    public function loginUser()
    {
        $nome = $_POST["email"];
        $senha = $_POST["senha"];

        $result = $this->query->returnSql("SELECT id FROM usuarios WHERE email = ? AND senha = ? ", [$nome, $senha]);

        if (!empty($result)) {
            $_SESSION['id'] = $result['id'];
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
                $result = $this->query->returnSql("SELECT email FROM usuarios WHERE email = ?", [$email]);
            } else {
                return 'Dados Inválidos';
            }

            if (!empty($result)) {
                return 'Usuário já cadastrado';
            } else {
                $_SESSION['id'] = $this->query->simpleSql("INSERT INTO usuarios (email, senha, nome, sobrenome, estado, cidade) VALUES (?, ?, ?, ?, ?, ?)", [$email, $senha1, $nome, $sobrenome, $estado, $cidade], true);
                header('Location: /perfil');
            }
        } else {
            return 'Senhas diferentes';
        }
    }
}
