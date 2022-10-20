<?php

namespace App\Http\Resources\Room;

use App\Http\Resources\PartialCostResource;
use App\Http\Resources\PartialRateResource;
use App\Http\Resources\PartialTemplateResource;
use App\Http\Resources\ReceptionResource;
use App\Http\Resources\RoomStatusResource;
use App\Http\Resources\RoomTypeResource;
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
                'name'  => $this->resource->name,
                'description' => $this->resource->description,
                'rate_current' => $this->whenAppended('rate_current',fn () => $this->resource->rate_current),
                'deleted_at'     => $this->resource->deleted_at,
            ],
            'relationships' => [
                'roomStatus' => $this->whenLoaded('roomStatus', function() {
                    return RoomStatusResource::make($this->resource->roomStatus);
                }),
                'partialCost' => $this->whenLoaded('partialCost', function() {
                    return PartialCostResource::make($this->resource->partialCost);
                }),
                'receptionActive' => $this->whenLoaded('receptionActive', function() {
                    if($this->resource->receptionActive->first()){
                        return ReceptionResource::make($this->resource->receptionActive->first());
                    }
                    return null;
                }),

            ],
        ];
    }

}
