<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard("web")->guest();;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "name" => 'required|string|min:8',
            "email" => 'required|email|unique:users,email',
            "password" => [Password::defaults()->min(6)->symbols()->numbers()->mixedCase(), "confirmed"],
            "has_store" => "sometimes|boolean"
        ];
    }
}
