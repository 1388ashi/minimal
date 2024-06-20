<?php

namespace Modules\Ticket\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|max:240',
            'description' => 'required',
            'email' => 'required|email',
            'mobile' => ['required','numeric','digits:11' ],
            'status' => 'nullable',
        ];
    }
    public function validated($key = null, $default = null) {
        $validated = parent::validated();
        $validated['status'] = 'new';

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
