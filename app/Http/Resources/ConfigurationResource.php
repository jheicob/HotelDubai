<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConfigurationResource extends JsonResource
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
                'env' => $this->resource->env,
                'fiscal_machine_serial' => $this->resource->fiscal_machine_serial,
                'exchange_rate' => $this->resource->exchange_rate,
                'warning_time' => $this->resource->warning_time,
                'cancel_time' => $this->resource->cancel_time,
                'color_warning_time' => $this->resource->color_warning_time,
                'color_past_time' => $this->resource->color_past_time,
            ]
        ];
    }
}
