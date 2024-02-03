<?php

namespace App\Http\Requests\Stores;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegisterFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
            "email" => 'required|email|unique:stores,email|max:100|min:8',
            "password" => 'required|confirmed|min:8|max:20',
            "logo" => 'file|mimes:jpg,bmp,png|max:1024',
        ];
    }
}
