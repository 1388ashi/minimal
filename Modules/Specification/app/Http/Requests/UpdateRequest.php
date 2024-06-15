<?php

namespace Modules\Specification\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $specificationId = $this->route()->parameter('specification')->id;
        return [
            'name' => ['required',Rule::unique('specifications')->ignore($specificationId)],

            'categories.*' => 'required',
            'categories' => 'required|array',  
            'categories.id' => 'integer|exists:categories,id',  
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
