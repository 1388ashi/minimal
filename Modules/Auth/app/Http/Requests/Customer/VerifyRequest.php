<?php

namespace Modules\Auth\Http\Requests\Customer;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Core\App\Helpers\Helpers;
use Modules\Core\App\Rules\IranMobile;
use Modules\Customer\Models\Customer;
use Modules\SmsToken\Models\SmsToken;

class VerifyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'mobile' => ['required', 'digits:11',new IranMobile],
            'sms_token' => ['required', 'integer'],
            'type' => ['required', 'in:register,login'],
        ];
    }
    protected function passedValidation(): void
    {
        $smsToken = SmsToken::query()->where('mobile', $this->input('mobile'))->first();
        if (!$smsToken) {
            throw Helpers::makeValidationException('کاربری با این شماره موبایل پیدا نشد!', 'mobile');
        } elseif ($smsToken->token !== $this->sms_token) {
            throw Helpers::makeValidationException('کد وارد شده نادرست است!', 'sms_token');
        } elseif (Carbon::now()->gt($smsToken->expires_at)) {
            throw Helpers::makeValidationException('کد وارد شده منقضی شده است!', 'sms_token');
        }

        if ($this->input('type') !== 'register') {
            $customer = Customer::where('mobile', $this->input('mobile'))->first();
        }

        $this->merge([
            'smsToken' => $smsToken,
            'customer' => $customer ?? null
        ]);
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
