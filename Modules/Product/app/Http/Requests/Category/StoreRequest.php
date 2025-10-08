<?php

namespace Modules\Product\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Core\Helpers\Helpers;
use Modules\Product\Models\Category;
use Illuminate\Validation\ValidationException;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|unique:categories,title',
            'slug' => 'required|unique:categories,slug',
            'parent_id' => ['nullable', 'numeric'],
            'image' => 'nullable|image',
            'dark_image' => 'nullable|image',
            'featured' => 'nullable',
        ];
    }
    protected function passedValidation(): void
    {
        if(filled($this->featured) && empty($this->image)){
            throw ValidationException::withMessages([
                'parent_id' => ['دسته بندی ویژه تصویر الزامی دارد']
            ])
            ->errorBag('default');
        }elseif (!empty($this->parent_id)) {
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
