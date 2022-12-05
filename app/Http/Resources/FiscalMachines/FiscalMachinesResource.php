<?php

namespace App\Http\Resources\FiscalMachines;

use App\Http\Resources\RoomTypeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FiscalMachinesResource extends JsonResource
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
                'name' => $this->resource->name,
                'serial' => $this->resource->serial,
                'deleted_at' => $this->resource->deleted_at,
            ],
            'relationships' => [
                'estateType' => $this->whenLoaded('estateType',fn() => RoomTypeResource::make($this->resource->estateType)),
                /*
                    'relation' => $this->whenLoaded('relation', function() {
                        return relationResource::make($this->resource->relation);
                    }),
                */
            ],
        ];
    }
}
