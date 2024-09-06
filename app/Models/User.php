<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public function compras()
    {
        return $this->hasMany(Purchase::class, 'user_id');
    }

    public function produtos()
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    public function carrinho()
    {
        return $this->belongsToMany(Product::class, 'carts', 'user_id', 'product_id');
    }
}