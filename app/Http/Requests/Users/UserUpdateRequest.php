<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard("web")->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "name" => "sometimes|string",
            "password" => "sometimes|string|confirmed|min:8",
            "logo" => ["sometimes", File::types(["jpg", "jpeg", "png", "webp", "bmp"])->min(1)->max(1024 * 5)],
        ];
    }
}
