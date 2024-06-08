<?php

namespace Modules\Auth\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Core\App\Rules\IranMobile;

class CustomerStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:120',
            'mobile' => ['required', 'digits:11',new IranMobile],
            'status' => 'required|in:0,1',
            'email' => 'nullable|email',
            'national_code' => 'nullable|regex:/^[0-9]{10}$/|unique:customers,national_code',
            'password' => 'required|min:6',
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
