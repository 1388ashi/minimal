<?php

namespace Modules\Product\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function prepareForValidation(){
        $this->merge([
            'price' => str_replace(',', '', $this->input('price')),
        ]);
        if (filled($this->discount)) {
            $this->merge([
                'discount' => str_replace(',', '', $this->input('discount')),
            ]);
        }
    }
    public function rules(): array
    {
        $productId = $this->route()->parameter('product')->id;
        return [
                'title' => ['required',Rule::unique('products')->ignore($productId)],
                'description' => 'required',
                'summary' => 'nullable',    

                'price' => 'integer|required',
                'discount' => 'nullable|integer ',
                'status' => ['nullable', 'in:1'],

                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
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
        unset(
            $validated['categories'],
            $validated['specifications'],
            $validated['image'],
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
