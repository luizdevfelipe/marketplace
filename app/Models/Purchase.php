<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public function usuarios()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function produto()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}