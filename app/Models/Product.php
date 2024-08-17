<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function compras()
    {
        return $this->hasMany(Purchase::class, 'product_id');
    }

    public function usuarios()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function carrinho()
    {
        return $this->belongsToMany(User::class, 'carts', 'product_id', 'user_id');
    }
}