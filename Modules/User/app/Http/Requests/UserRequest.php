<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Admin\Rules\InDict;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'avatar'   => 'nullable|string',
            'username' => [
                'required',
                'string',
                'min:3',
                'max:20',
                Rule::unique('users')->ignore($this['id']),
            ],
            'nickname'       => 'nullable|string|max:50',
            'phone'          => 'nullable|string|regex:/^1[3-9]\d{9}$/',
            'email'          => 'nullable|email|max:100',
            'sex'            => ['required', 'string', new InDict('sex')],
            'birthday'       => 'nullable|date',
            'vip'            => 'required|integer|min:0',
            'money'          => 'required|numeric|min:0',
            'score'          => 'required|integer|min:0',
            'status'         => ['required', 'string', new InDict('data_status')],
            'alipay_name'    => 'nullable|string|max:50',
            'alipay_account' => [
                'nullable',
                'string',
                'regex:/^1[3-9]\d{9}$|^\w+@[\w.-]+\.[a-z]{2,}$|^[a-z0-9A-Z]{16,28}$/i',
            ],
        ];

        // 如果是创建用户，密码为必填
        if (request()->route()->getActionMethod() == 'create') {
            $rules['password'] = 'required|string|min:6|max:20';
        } else {
            $rules['password'] = 'nullable|string|min:6|max:20';
        }

        return $rules;
    }

    /**
     * 获取已定义验证规则的错误消息
     */
    public function attributes()
    {
        return [
            'avatar'         => __('user::user.avatar'),
            'username'       => __('user::user.username'),
            'password'       => __('user::user.password'),
            'nickname'       => __('user::user.nickname'),
            'phone'          => __('user::user.phone'),
            'email'          => __('user::user.email'),
            'sex'            => __('user::user.sex'),
            'birthday'       => __('user::user.birthday'),
            'vip'            => __('user::user.vip'),
            'money'          => __('user::user.money'),
            'score'          => __('user::user.score'),
            'status'         => __('user::user.status'),
            'alipay_name'    => __('user::user.alipay_name'),
            'alipay_account' => __('user::user.alipay_account'),
        ];
    }

    /**
     * 获取验证错误的自定义消息
     */
    public function messages()
    {
        return [
            'username.required'    => __('user::user.username_required'),
            'username.min'         => __('user::user.username_min'),
            'username.max'         => __('user::user.username_max'),
            'username.unique'      => __('user::user.username_exists'),
            'password.required'    => __('user::user.password_required'),
            'password.min'         => __('user::user.password_min'),
            'password.max'         => __('user::user.password_max'),
            'phone.regex'          => __('user::user.phone_format_error'),
            'email.email'          => __('user::user.email_format_error'),
            'alipay_account.regex' => __('user::user.alipay_account_format_error'),
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
