<?php

namespace App\Http\Resources\Invoice;

use App\Http\Resources\Client\ClientResource;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceDetailResource extends JsonResource
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
                // productable_id,
                'productable_type' => $this->resource->productable_type,
                'price' => $this->resource->price,
                'quantity' => $this->resource->quantity,
                'product_name' =>  self::getProductName()
            ],
            'relationships' => [

            ],
        ];
    }

    private function getProductName(){
        $field = 'name';
        if(strpos($this->resource->productable_type,'App\Models\ReceptionDetai') !== false){
            $field = 'partial_min';
        }else
        if(strpos($this->resource->productable_type,'App\Models\Product') !== false){
            $field = 'name';
        }else{
            return $this->resource->description;
        }
        return $this->resource->productable_type::find($this->resource->productable_id)->$field;
    }
}
