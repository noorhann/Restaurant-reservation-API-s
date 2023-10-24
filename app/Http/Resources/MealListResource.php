<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MealListResource extends JsonResource
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
            'price' => $this->price,
            'discount' => $this->discount,
            'description' => $this->description,
            'available_quantity' => ($this->available_quantity == 0) ? 'unavailable today' : $this->available_quantity  ,

        ];
    }
}
