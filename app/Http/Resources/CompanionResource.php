<?php

namespace App\Http\Resources;

use App\Http\Resources\Client\ClientResource;
use App\Http\Resources\ExtraGuest\ExtraGuestResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanionResource extends JsonResource
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
            'id' => $this->id,
            'attributes' => [
                'extra_guest_id' => $this->resource->extra_guest_id,
                'client_id' => $this->resource->client_id,
            ],
            'relationships' => [
                'extraGuest' => $this->whenLoaded('extraGuest',function(){
                    return ExtraGuestResource::make($this->resource->extraGuest);
                }),
                'client' => $this->whenLoaded('client',function(){
                    return ClientResource::make($this->resource->client);
                })
            ]
        ];
    }
}
