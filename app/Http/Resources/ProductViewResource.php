<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductViewResource extends JsonResource
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
            "id" => $this->id,
            "name" => $this->name,
            "price" => $this->price,
            "stock_amount" => $this->stock_amount,
            "image" => $this->image,
            "category" => CategoryViewResource::make($this->category),
            "store" => StoreViewResource::make($this->store),
        ];
    }
}
