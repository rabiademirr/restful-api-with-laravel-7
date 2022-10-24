<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Laravel Api Documentation",
 *     description="This is a sample API documentation.",
 *     @OA\Contact(email="rabiademirr@gmail.com")
 * )
 * @OA\Schema Product(
 *   title="Product",
 *   description="Product Model"
 * )
 */
class Product extends Model
{
    use HasFactory;

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'product_categories');
    }
}
