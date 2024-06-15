<?php

namespace Modules\JobOffer\Http\Requests\Job;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:200|unique:jobs,title',
            'times' => 'required|max:244',
            'type' => 'required|in:part-time,full-time'
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
