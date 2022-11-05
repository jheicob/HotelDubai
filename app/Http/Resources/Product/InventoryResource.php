<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
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
                'stock_min' => $this->resource->stock_min,
                'stock' => $this->resource->stock,
            ],
            'relationships' => [
                'product' => $this->whenLoaded('product', fn () => ProductResource::make($this->resource->product))
            ]
        ];
    }
}
