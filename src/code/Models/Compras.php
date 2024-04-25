<?php

declare(strict_types=1);

namespace Code\Models;

use Illuminate\Database\Eloquent\Model;

class Compras extends Model
{
    protected $table = 'compras';
    CONST CREATED_AT = 'data';
    CONST UPDATED_AT = null;

    public function usuarios()
    {
        return $this->belongsTo(Usuarios::class, 'iduser');
    }
    
    public function produto()
    {
        return $this->belongsTo(Produtos::class, 'idproduto');
    }
}