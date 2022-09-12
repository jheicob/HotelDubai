<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PartialTemplateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'attributes' => [
                'deleted_at'     => $this->resource->deleted_at,
            ],
            'relationships' => [
                'roomType'    => $this->whenLoaded('roomType', fn() => RoomTypeResource::make($this->resource->roomType)),
                'partialRate' => $this->whenLoaded('partialRate', fn() => RoomTypeResource::make($this->resource->partialRate)),
                'dayWeek'     => $this->whenLoaded('dayWeek', fn() => RoomTypeResource::make($this->resource->dayWeek)),
                'systemTime'  => $this->whenLoaded('systemTime', fn() => RoomTypeResource::make($this->resource->systemTime)),
                'shiftSystem' => $this->whenLoaded('shiftSystem', fn() => RoomTypeResource::make($this->resource->shiftSystem)),
                'partialRate' => $this->whenLoaded('partialRate', fn() => RoomTypeResource::make($this->resource->partialRate)),
            ],
        ];
    }
}




