<?php

namespace Modules\Slider\Http\Requests\BrandSlider;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
             'title' => 'required',
            'link' => [
                'nullable',
                'string',
                'url',
            ],
            'type' => 'required|in:up,down',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg',
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
