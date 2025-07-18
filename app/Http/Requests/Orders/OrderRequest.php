<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !Auth::guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "order" => "required|array|min:1",
            "order.*.product_id" => "required|integer|min:1|exists:products,id",
            "order.*.count" => "required|integer|min:1",
            "cart_id" => "required|string|min:10"
        ];
    }
}
