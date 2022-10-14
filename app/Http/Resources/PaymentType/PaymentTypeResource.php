<?php

namespace App\Http\Resources\PaymentType;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentTypeResource extends JsonResource
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
                /*
                  'attribute'           => $this->resource->attribute,
                */
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
