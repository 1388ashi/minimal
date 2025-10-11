<?php

namespace Modules\Product\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function prepareForValidation(){
        if (filled($this->price)) {
            $this->merge([
                'price' => str_replace(',', '', $this->input('price')),
            ]);
        }
        if (filled($this->discount)) {
            $this->merge([
                'discount' => str_replace(',', '', $this->input('discount')),
            ]);
        }
    }
    public function rules(): array
    {
        return [
                'title' => 'required|unique:products,title',
                'slug' => 'required|unique:products,slug',
                'description' => 'nullable',
                'summary' => 'nullable',

                'price' => 'nullable|integer',
                'image_alt' => 'nullable|string',
                'discount' => 'nullable|integer',
                'status' => ['nullable', 'in:1'],
                'robots' => ['nullable', 'in:1'],
                'brand_id' => 'nullable|exists:brands,id',


                'image' => 'required',
                'video' => 'nullable',
                'galleries.*' => 'nullable',
                'galleries' => 'nullable|array',

                'categories.*' => 'required',
                'categories' => 'required|array',
                'categories.id' => 'integer|exists:categories,id',

                'specifications.*' => 'nullable',
                'specifications' => 'nullable|array',
                'specifications.id' => 'integer|exists:specifications,id',
                'specifications.value' => 'string',
        ];
    }

    public function validated($key = null, $default = null) {
        $validated = parent::validated();
        $validated['status'] = $this->filled('status') ? 1 : 0;
        $validated['robots'] = $this->filled('robots') ? 1 : 0;
        unset(
            $validated['categories'],
            $validated['specifications'],
            $validated['image'],
            $validated['video'],
            $validated['galleries']
        );

        return $validated;
    }

    protected function passedValidation(): void
    {
        if ($this->discount > $this->price) {
            throw ValidationException::withMessages([
                'discount' => ['تخفیف نمیتواند از قیمت بیشتر باشد'],
            ])
            ->errorBag('default');
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
