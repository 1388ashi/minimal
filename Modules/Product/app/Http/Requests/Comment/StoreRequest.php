<?php

namespace Modules\Product\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:230',
            'product_id' => 'required|integer|exists:products,id',
            'text' => 'required',
            'mobile' => ['required','numeric','digits:11' ],
            'star' => ['required','int','in:1,2,3,4,5' ],
        ];
    }
    public function validated($key = null, $default = null) {
        $validated = parent::validated();
        $validated['status'] = 'pending';
    
        return $validated;
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
