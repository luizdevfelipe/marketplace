<?php

declare(strict_types=1);

namespace Code\Models;

class ProfileModel
{
    public function __construct(private Queries $query)
    {
    }

    public function requestData(): array
    {
        $user = $this->query->returnSql("SELECT * FROM usuarios WHERE id = ?", [$_SESSION['id']]);

        $product = $this->query->returnSql("SELECT * FROM produtos WHERE vendedor = ?", [$_SESSION['id']] , true);

        $purchases = $this->query->returnSql("SELECT c.idproduto, p.nome FROM produtos p JOIN compras c ON p.id = c.idproduto WHERE c.iduser = ?", [$_SESSION['id']], true);

        return [$user, $product, $purchases];
    }

    public function newPhoto()
    {
        if (isset($_FILES["foto"])) {
            $foto = $_FILES["foto"];
            $pasta = "storage/users/perfil/";

            if ($foto["error"]) {
                echo 'Erro ao enviar o arquivo!';
            }

            if ($foto["size"] > 2097152) {
                echo 'Arquivo máximo de 2Mb, tente novamente';
            }

            $nomeOriginal = $foto["name"];
            $nomeCodificado = uniqid();
            $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));

            $path = $pasta . $nomeCodificado . '.' . $extensao;

            if ($extensao != 'jpg' && $extensao != 'png') {
                echo 'Arquivo não suportado!';
            }

            if (move_uploaded_file($foto["tmp_name"], $path)) {
                $this->query->simpleSql("UPDATE usuarios SET foto = (?) WHERE id = ?", [$path, $_SESSION['id']]);
            } else {
                echo 'Erro ao salvar o arquivo!';
            }
        }    
    }
}
