<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    public $timestamps = false;

    // Связь: товар принадлежит одному складу
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}