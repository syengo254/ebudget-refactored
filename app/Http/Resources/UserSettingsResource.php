<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSettingsResource extends JsonResource
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
            "isAdmin" => $this->is_admin,
            "isStaff" => $this->is_staff,
            "isBlocked" => $this->is_blocked,
            "twoFaEnabled" => $this->two_fa_enabled,
        ];
    }
}
