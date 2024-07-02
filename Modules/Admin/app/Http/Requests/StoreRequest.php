<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Modules\Permission\Models\Role;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'mobile' => ['required','string','numeric','unique:admins,mobile','digits:11' ],
            'password' => 'required|min:6|confirmed',
            'role' => ['required'],
        ];
    }
    protected function passedValidation(): void
    {
        $role = Role::query()->where('name', $this->input('role'))->first();
        if (empty($role)) {
            throw ValidationException::withMessages([
                'role' => ['نقش انتخاب شده معتبر نمیباشد']
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
