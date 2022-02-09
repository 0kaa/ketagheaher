<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomOrderListResource extends JsonResource
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
            'id'                    => $this->id,
            'piece_name'            => $this->piece_name,
            'piece_image'           => $this->piece_image ? url('storage/' . $this->piece_image) : null,
            'car_name'              => $this->car->name,
            'car_image'             => $this->car->image ? url('storage/' . $this->car->image) : null,
            'piece_description'     => $this->piece_description,
        ];
    }
}
