<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DateTemplateResource extends JsonResource
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
                'date'           => $this->resource->date,
                'rate'           => $this->resource->rate,
                'hour_start'           => $this->resource->hour_start,
                'hour_end'           => $this->resource->hour_end,
                'deleted_at'     => $this->resource->deleted_at,
            ],
            'relationships' => [
                'roomType'    => $this->whenLoaded('roomType', fn() => RoomTypeResource::make($this->resource->roomType)),
                'partialRate'    => $this->whenLoaded('partialRate', fn() => RoomTypeResource::make($this->resource->partialRate)),
            ],
        ];
    }
}
