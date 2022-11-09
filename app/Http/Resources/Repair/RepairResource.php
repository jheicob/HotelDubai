<?php

namespace App\Http\Resources\Repair;

use App\Http\Resources\Room\RoomResource;
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
                'description'      => $this->resource->description,
                'observation'      => $this->resource->observation,
                'report_date'      => $this->resource->report_date,
                'maintenance_date'      => $this->resource->maintenance_date,
            ],
            'relationships' => [
                'reportUser' => $this->whenLoaded('reportUser', function () {
                    return UserResource::make($this->resource->reportUser);
                }),
                'maintenanceUser' => $this->whenLoaded('maintenanceUser', function () {
                    return UserResource::make($this->resource->maintenanceUser);
                }),
                'room' => $this->whenLoaded('room', function () {
                    return RoomResource::make($this->resource->room);
                }),
            ]
        ];
    }
}
