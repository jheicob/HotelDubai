<?php

namespace App\Http\Resources\ProductCategory;

use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryResource extends JsonResource
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
                'deleted_at' => $this->resource->deleted_at
                /*
                  'attribute'           => $this->resource->attribute,
                */
            ],
            'relationships' => [

                'products' => $this->whenLoaded('products', function() {
                    return ProductResource::collection($this->resource->products);
                }),
                /*
                    'relation' => $this->whenLoaded('relation', function() {
                        return relationResource::make($this->resource->relation);
                    }),
                */
            ],
        ];
    }
}
