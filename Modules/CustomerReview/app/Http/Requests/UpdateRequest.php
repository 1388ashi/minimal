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
        $reviewsId = $this->route('customer-reviews')->param('customer-review');
        return [
            'name' => ['required', Rule::unique('customer_reviews')->ignore($reviewsId)],
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
