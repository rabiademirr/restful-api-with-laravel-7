<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 *   @OA\Schema Product(
 *   title="Product",
 *   description="Product Model",
 *   type="object",
 *   schema="Product",
 *   properties={
 *   required={"id"},
 *   @OA\Property(property="id",type="integer", format="int32", description="id column"),
 *   @OA\Property(property="name",type="string", description="name column"),
 *   @OA\Property(property="slug",type="string", description="slug column"),
 *   @OA\Property(property="description",type="string"),
 *   @OA\Property(property="price",type="number"),
 *   @OA\Property(property="sku",type="string"),
 *   @OA\Property(property="created_at",type="date"),
 *   @OA\Property(property="updated_at",type="date")
 * },
 *    required={"id"}
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
