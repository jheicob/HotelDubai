<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
                'document' => $this->resource->document,
                'first_name' => $this->resource->first_name,
                'last_name' => $this->resource->last_name,
                'phone' => $this->resource->phone,
                'email' => $this->resource->email,
            ],
            'relationships' => [
                /*
                    'relation' => $this->whenLoaded('relation', function() {
                        return relationResource::make($this->resource->relation);
                    }),
                */
            ],
        ];
    }
}
