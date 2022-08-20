<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
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
                'name'           => $this->resource->name,
                'guard_name'     => $this->resource->guard_name,
                'updated_at'     => $this->resource->updated_at,
                'created_at'     => $this->resource->created_at,
            ],
        ];
    }
}
