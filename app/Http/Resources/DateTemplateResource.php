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
                'deleted_at'     => $this->resource->deleted_at,
            ],
            'relationships' => [
                'roomType'    => $this->whenLoaded('roomType', fn() => RoomTypeResource::make($this->resource->roomType)),
            ],
        ];
    }
}
