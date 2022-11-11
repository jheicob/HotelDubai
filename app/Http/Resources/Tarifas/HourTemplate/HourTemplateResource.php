<?php

namespace App\Http\Resources\Tarifas\HourTemplate;

use App\Http\Resources\RoomTypeResource;
use App\Http\Resources\ShiftSystemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class HourTemplateResource extends JsonResource
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
                'hour'           => $this->resource->hour,
                'hour_end'  => $this->resource->hour_end,
                'rate'           => $this->resource->rate,
                'deleted_at'     => $this->resource->deleted_at,
            ],
            'relationships' => [
                'roomType'    => $this->whenLoaded('roomType', fn () => RoomTypeResource::make($this->resource->roomType)),
                'shiftSystem' => $this->whenLoaded('shiftSystem', fn () => ShiftSystemResource::make($this->resource->roomType)),
                'partialRate' => $this->whenloaded('partialRate', fn () => RoomTypeResource::make($this->resource->partialRate))
            ],
        ];
    }
}
