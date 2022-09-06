<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductsWithCategoriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'productId' => $this->id,
            'productName' => $this->name,
            //'categories' => CategoryResource::collection($this->categories),
            'categories' => CategoryResource::collection($this->whenLoaded('categories'))
        ];
    }
}
