<?php

declare(strict_types=1);

namespace Code\Models;

use Illuminate\Database\Eloquent\Model;

class Produtos extends Model
{
    protected $table = 'produtos';
    public $timestamps = false;

    public function compras()
    {
        return $this->hasMany(Compras::class, 'idproduto');
    }

    public function usuarios()
    {
        return $this->belongsTo(Usuarios::class, 'vendedor');
    }

    public function carrinho()
    {
        return $this->belongsToMany(Usuarios::class, 'carrinho', 'idproduto', 'iduser');
    }
}
