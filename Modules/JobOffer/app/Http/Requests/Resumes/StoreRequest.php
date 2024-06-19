<?php

namespace Modules\JobOffer\Http\Requests\Resumes;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Core\Helpers\Helpers;
use Modules\JobOffer\Models\Resumes;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:240',
            'description' => 'required',
            'mobile' => ['required','numeric','digits:11' ],
            'file' => 'required|file',
            'job_id' => 'required|integer|exists:job_offers,id'
        ];
    }
    protected function passedValidation(): void
    {
        $resumes = Resumes::query()->where('job_id', $this->job_id)->where('mobile',$this->mobile && 'name',$this->name)->exists();
        if (!empty($resumes)) {
            throw Helpers::makeValidationException('!شما یک بار رزومه برای این شغل ارسال کردید');
        }
    }
    public function validated($key = null, $default = null) {
        $validated = parent::validated();

        unset(
            $validated['file']
        );
    
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
