<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserMoneyLogRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                Rule::exists('users', 'id'),
            ],
            'money' => 'required|numeric',
            'memo'    => 'required|string|max:255',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'user_id' => __('user::user_money_log.user_id'),
            'money' => __('user::user_money_log.money'),
            'memo'    => __('user::user_money_log.memo'),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'user_id.required' => __('user::user_money_log.user_id_required'),
            'money.required' => __('user::user_money_log.money_required'),
            'memo.required'    => __('user::user_money_log.memo_required'),
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