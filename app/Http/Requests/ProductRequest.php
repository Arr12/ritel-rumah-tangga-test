<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'description' => ['string', 'max:255'],
            'rating' => ['required', 'string', 'max:255'],
            'price' => ['required', 'string', 'max:255'],
            'images' => ['required', 'string', 'max:255'],
            'stock' => ['required', 'string', 'max:255'],
        ];
    }
}
