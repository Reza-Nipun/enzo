<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    public function productimages()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
}
