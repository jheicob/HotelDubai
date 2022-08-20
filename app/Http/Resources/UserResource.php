<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
                'name'      => $this->resource->name,
                'email'     => $this->resource->email,
                'deleted_at'     => $this->resource->deleted_at 
            ],
            'relationships' => [
                'roles' => $this->whenLoaded('roles', function() {
                    return RolResource::collection($this->resource->roles);
                }),
            ],
        ];
    }
}
