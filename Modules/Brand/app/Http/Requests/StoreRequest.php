<?php

namespace Modules\Brand\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'dark_image' => 'nullable|image|mimes:jpeg,png,jpg',
            'white_image' => 'nullable|image|mimes:jpeg,png,jpg',
            'background' => 'required|image|mimes:jpeg,png,jpg',
            'description' => 'required',
            'title' => 'required'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
