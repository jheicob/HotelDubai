<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LogsResource extends JsonResource
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
                'event'           => $this->resource->event,
                'auditable_type'           => $this->resource->auditable_type,
                'auditable_id'           => $this->resource->auditable_id,
                'old_values'           => $this->resource->old_values,
                'new_values'           => $this->resource->new_values,
            ],
            'relationships' => [
                'user' => $this->whenLoaded('user', function() {
                    return UserResource::make($this->resource->user);
                }),
                'auditable' => $this->whenLoaded('auditable', function() {
                    return $this->resource->auditable;
                }),
            ],
        ];
    }
}
