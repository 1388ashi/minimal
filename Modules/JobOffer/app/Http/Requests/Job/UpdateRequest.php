<?php

namespace Modules\JobOffer\Http\Requests\Job;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $jobId = $this->route()->parameter('job')->id;
        return [
            'name' => ['required',Rule::unique('job_offers')->ignore($jobId)],
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
