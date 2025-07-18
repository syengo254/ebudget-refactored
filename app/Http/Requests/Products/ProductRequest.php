<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->has_store;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:400',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:1',
            "image" => ["required", File::types(["jpg", "jpeg", "png", "webp"])->min(2)->max(1024 * 5)],
            'category' => "sometimes|integer|min:1|exists:categories,id",
            'categoryname' => "sometimes|string|min:4|alpha",
        ];
    }
}
