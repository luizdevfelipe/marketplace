<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use App\Models\User;

class ProfileService
{
    public function requestData(): array
    {
        $user = User::select('*')
            ->where('id', session()->get('id'))
            ->get()->toArray();

        $product = Product::select('*')
            ->where('user_id', session()->get('id'))
            ->get()->toArray();

        $purchases = Product::select('purchases.product_id', 'products.name')
            ->join('purchases', 'products.id', 'purchases.product_id')
            ->where('purchases.user_id', session()->get('id'))
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
                User::where('id', session('id'))
                    ->update([
                        'foto' => $path
                    ]);
            } else {
                echo 'Erro ao salvar o arquivo!';
            }
        }
    }
}
