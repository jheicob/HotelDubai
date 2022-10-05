<?php

namespace App\Http\Resources\Room;

use App\Http\Resources\PartialTemplateResource;
use App\Http\Resources\RoomStatusResource;
use App\Http\Resources\ThemeTypeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
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
                'description' => $this->resource->description,
            ],
            'relationships' => [
                'roomStatus' => $this->whenLoaded('roomStatus', function() {
                    return RoomStatusResource::make($this->resource->roomStatus);
                }),
                'partialTemplate' => $this->whenLoaded('partialTemplate', function() {
                    return PartialTemplateResource::make($this->resource->partialTemplate);
                }),
                'themeType' => $this->whenLoaded('themeType', function() {
                    return ThemeTypeResource::make($this->resource->themeType);
                }),
            ],
        ];
    }
}
