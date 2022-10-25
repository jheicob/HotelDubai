<?php

namespace App\Http\Resources\Invoice;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoicePaymentResource extends JsonResource
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
                'type' => $this->resource->type, // ['divisa', 'Bs']
                'method' => $this->resource->method, // ['efectivo', 'digital', 'tarjeta']
                'quantity' => $this->resource->quantity,
                'description' => $this->resource->description,
            ],
        ];
    }
}
