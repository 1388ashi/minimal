<?php

namespace Modules\Product\Http\Requests\Advistor;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Core\Helpers\Helpers;
use Modules\PurchaseAdvisor\Models\PurchaseAdvisor;

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
            'mobile' => ['required','numeric','digits:11' ],
        ];
    }
    protected function passedValidation(): void
    {
        $advisor = PurchaseAdvisor::query()->where('product_id', $this->product_id)->where('mobile', $this->mobile)->exists();
        if (!empty($advisor)) {
            throw Helpers::makeValidationException('این شماره موبایل قبلا درخواست مشاوره داده!', 'mobile');
        }
    }
    public function validated($key = null, $default = null) {
        $validated = parent::validated();
        $validated['status'] = 'notcalled';
    
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
