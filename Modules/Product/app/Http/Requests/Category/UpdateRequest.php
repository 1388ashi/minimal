<?php

namespace Modules\Product\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Modules\Product\Models\Category;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $categoryId = $this->route()->parameter('category')->id;
        return [
            'title' => ['required',Rule::unique('categories')->ignore($categoryId)],
            'parent_id' => ['nullable'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'dark_image' => 'nullable|image',
            'featured' => 'nullable',
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
