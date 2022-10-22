<?php

namespace App\Http\Resources\Invoice;

use App\Http\Resources\Client\ClientResource;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceDetailResource extends JsonResource
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
                // productable_id,
                'productable_type' => $this->resource->productable_type,
                'price' => $this->resource->price,
                'quantity' => $this->resource->quantity,
                'product_name' => $this->resource->product_name
            ],
            'relationships' => [

            ],
        ];
    }
}
