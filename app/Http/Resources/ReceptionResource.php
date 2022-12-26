<?php

namespace App\Http\Resources;

use App\Http\Resources\Client\ClientResource;
use App\Http\Resources\Invoice\InvoiceResource;
use App\Http\Resources\Room\RoomResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReceptionResource extends JsonResource
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
                'date_in' => $this->resource->date_in,
                'date_out' => $this->resource->date_out,
                'invoiced' => $this->resource->invoiced,
                'invoice_id' => $this->resource->invoice_id,
                'observation' => $this->resource->observation,
            ],
            'relationships' => [
                'client' => $this->whenLoaded('client', function() {
                    return ClientResource::make($this->resource->client);
                }),
                'invoice' => $this->whenLoaded('invoice', function() {
                    return InvoiceResource::make($this->resource->invoice);
                }),
                'room' => $this->whenLoaded('room', function() {
                    return RoomResource::make($this->resource->room);
                }),
                'details' => $this->whenLoaded('details', function() {
                    return ReceptionDetailResource::collection($this->resource->details);
                }),
                'companions' => $this->whenLoaded('companions', function() {
                    return CompanionResource::collection($this->resource->companions);
                })
            ],
        ];
    }
}
