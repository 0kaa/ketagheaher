<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            'product_name'  => $this->product->name,
            'product_image' => $this->product->image ? url('/storage') . '/' . $this->product->image : url('/product-no-img.jpg'),
            'product_price' => $this->product->price . ' SAR',
            'product_id'    => $this->product->id,
            'product_rating' => $this->product->ratings()->avg('rating') ? $this->product->ratings()->avg('rating') : 0,
            'quantity'      => $this->quantity,

        ];
    }
}
