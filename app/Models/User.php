<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
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