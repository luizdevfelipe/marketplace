<?php

declare(strict_types=1);

namespace Code\Service;

use Code\Models\Produtos;
use Code\Models\Usuarios;

class ProfileService
{
    public function requestData(): array
    {
        $user = Usuarios::select('*')
            ->where('id', $_SESSION['id'])
            ->get()->toArray();

        $product = Produtos::select('*')
            ->where('vendedor', $_SESSION['id'])
            ->get()->toArray();

        $purchases = Produtos::select('compras.idproduto', 'produtos.nome')
        ->join('compras', 'produtos.id', 'compras.idproduto')
        ->where('compras.iduser', $_SESSION['id'])
        ->get()->toArray();
        
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
                Usuarios::where('id', $_SESSION['id'])
                ->update([
                    'foto' => $path
                ]);
            } else {
                echo 'Erro ao salvar o arquivo!';
            }
        }    
    }
}
