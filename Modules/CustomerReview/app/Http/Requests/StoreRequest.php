<?php

namespace Modules\CustomerReview\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'city' => 'required',
            'image' => 'required|image',
            'video' => 'nullable|file|mimetypes:video/mp4,video/avi',
            'description' => 'required'
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
