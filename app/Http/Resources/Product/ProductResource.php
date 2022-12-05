<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\ProductCategory\ProductCategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'id' => $this->resource->id,
            'attributes' => [
                'name' => $this->resource->name,
                'description' => $this->resource->description,
                'purchase_price' => $this->resource->purchase_price,
                'sale_price' => $this->resource->sale_price,
                'visible' => $this->resource->visible,
                'slash_code' => $this->resource->slash_code,
                'deleted_at' => $this->resource->deleted_at,
            ],
            'relationships' => [
                'inventory' => $this->whenLoaded('inventory', fn () => InventoryResource::make($this->resource->inventory)),
                'category'  => $this->whenLoaded('category',fn() => ProductCategoryResource::make($this->resource->category))            ],
        ];
    }
}
