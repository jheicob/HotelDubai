<?php

namespace App\Http\Resources\RangeTemplate;

use App\Http\Resources\PartialRateResource;
use App\Http\Resources\RoomTypeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RangeTemplateResource extends JsonResource
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
                'room_type_id' => $this->resource->room_type_id,
                'partial_rate_id' => $this->resource->partial_rate_id,
                'date_start' => $this->resource->date_start,
                'date_end' => $this->resource->date_end,
                'rate' => $this->resource->rate,
            ],
            'relationships' => [
                'roomType'    => $this->whenLoaded('roomType', fn () => RoomTypeResource::make($this->resource->roomType)),
                'partialRate' => $this->whenLoaded('roomType', fn () => PartialRateResource::make($this->resource->partialRate)),

            ],
        ];
    }
}
