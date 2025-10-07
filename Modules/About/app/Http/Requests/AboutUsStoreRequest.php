<?php

namespace Modules\About\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Core\Helpers\Helpers;
use Modules\About\Models\AboutUs;
class AboutUsStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|alpha_dash:ascii|max:191|unique:about_us,name',
            'label' => 'required|string|max:191',
            'type' => ['required', 'string', Rule::in(array_keys(AboutUs::getAllTypes()))]
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
