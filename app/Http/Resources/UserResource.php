<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "email" => $this->email,
            "name" => $this->name,
            "hasStore" => $this->has_store,
            "profile" => $this->profile,
            "phone" => $this->when($this->profile, $this->profile->phone ?? null),
            "address" => $this->when($this->profile, $this->profile->getActiveAddress()),
            "store" => $this->when($this->has_store, $this->store),
            "verified" => boolval($this->email_verified_at)
        ];
    }
}
