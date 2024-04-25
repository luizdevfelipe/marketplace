<?php

declare(strict_types=1);

namespace Code\Models;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    protected $table = 'usuarios';
    public $timestamps = false;
    
    public function compras()
    {
        return $this->hasMany(Compras::class, 'iduser');
    }

    public function produtos()
    {
        return $this->hasMany(Produtos::class, 'vendedor');
    }

    public function carrinho()
    {
        return $this->belongsToMany(Produtos::class, 'carrinho', 'iduser', 'idproduto');
    }
}
