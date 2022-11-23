<?php

namespace App\Http\Resources\Tarifas\DayTemplate;

use App\Http\Resources\RoomTypeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DayTemplateResource extends JsonResource
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
                'rate' => $this->resource->rate,
                'hour_start' => $this->resource->hour_start,
                'hour_end' => $this->resource->hour_end,
                'deleted_at' => $this->resource->deleted_at
            ],
            'relationships' => [
                'roomType' => $this->whenLoaded('roomType',fn () => RoomTypeResource::make($this->resource->roomType)),
                'dayWeek'  => $this->whenLoaded('dayWeek',fn () => RoomTypeResource::make($this->resource->dayWeek)),
                'partialRate' => $this->whenLoaded('partialRate', fn() => \App\Http\Resources\PartialRateResource::make($this->resource->partialRate)),
            ],
        ];
    }
}
