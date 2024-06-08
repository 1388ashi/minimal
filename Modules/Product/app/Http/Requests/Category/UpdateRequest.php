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
            'parent_id' => ['nullable', 'numeric'],
            'image' => 'required|image|mimes:jpeg,png,jpg',
        ];
    }
    protected function passedValidation(): void
    {
        if (!empty($this->parent_id)) {
            $category = Category::query()->where('id', $this->parent_id)->exists();
            if ($category == null) {
                throw ValidationException::withMessages([
                    'parent_id' => ['دسته بندی با این شناسه وجود ندارد']
                ])
                ->errorBag('default');
            }
        }
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
