<?php

namespace Modules\CustomerReview\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $reviews = $this->route()->parameter('customer-review')->id;
        return [
            'name' => ['required',Rule::unique('customer_reviews')->ignore($reviews)],
            'city' => 'required',
            'image' => 'nullable',
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
