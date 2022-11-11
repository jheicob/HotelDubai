<?php

namespace App\Http\Resources\Room;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RepairResource extends JsonResource
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
                'description'     => $this->resource->description,
                'observation'     => $this->resource->observation,
                'report_date'     => $this->resource->report_date,
                'maintenance_date' => $this->resource->maintenance_date,
            ],
            'relationships' => [
                'room' => $this->whenLoaded('room', fn () => RoomResource::make($this->resource->room)),
                'reportUser' => $this->whenLoaded('reportUser', fn () => UserResource::make($this->resource->reportUser)),
                'maintenanceUser' => $this->whenLoaded('maintenanceUser', fn () => UserResource::make($this->resource->maintenanceUser)),

            ]
        ];
    }
}
