<?php

namespace App\Http\Resources\Invoice;

use App\Http\Resources\Client\ClientResource;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
                'total' => $this->resource->total,
                'date'  => $this->resource->date,
                'observation' => $this->resource->observation,
                'num_fiscal' => $this->resource->num_fiscal,
                'date_fiscal' => $this->resource->date_fiscal,
                'cancelled' => $this->resource->cancelled,
                'status' => $this->resource->status,
            ],
            'relationships' => [
                'client' => $this->whenLoaded('client', function () {
                    return ClientResource::make($this->resource->client);
                }),
                'details' => $this->whenLoaded('details', function () {
                    return InvoiceDetailResource::collection($this->resource->details);
                }),
            ],
        ];
    }
}
