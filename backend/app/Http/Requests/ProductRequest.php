<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $productId = $this->route('product');

        return [
            'name' => 'required|string|max:255|unique:products,name,' . $productId,
            'price' => 'required|numeric',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'image_url' => 'nullable|url',
        ];
    }
}
