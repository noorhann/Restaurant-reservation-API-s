<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderSingleResource extends JsonResource
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
            'table_id' => $this->table_id,
            'reservation_id' => $this->reservation_id,
            'total' => $this->total, 
            'total_includ_tax_service' => $this->paid,
            'waiter' => new UserSingleResource($this->user),
            'customer' => $this->customer->name,
            'Items' => OrderDetailListResource::collection($this->orderDetails),
        ];
    }
}
