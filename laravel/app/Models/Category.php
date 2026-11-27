<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    public $timestamps = false;

    // Связь: в одной категории много товаров
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}