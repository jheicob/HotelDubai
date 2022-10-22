<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReceptionDetailResource extends JsonResource
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
                'partial_min'      => $this->resource->partial_min,
                'rate'             => $this->resource->rate,
                'observation'      => $this->resource->observation,
                'quantity_partial' => $this->resource->quantity_partial,
                'time_additional'  => $this->resource->time_additional,
                'price_additional' => $this->resource->price_additional,
            ],
            'relationships' => [
            ],
        ];
    }
}
