<?php

namespace App\Http\Resources\TypeDocument;

use Illuminate\Http\Resources\Json\JsonResource;

class TypeDocumentResource extends JsonResource
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
                'description' => $this->resource->description
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
