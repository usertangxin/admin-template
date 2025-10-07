<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Admin\Rules\InDict;

class SystemAdminRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'avatar'            => 'nullable|string',
            'admin_name'        => ['required', 'string', Rule::unique('system_admins')->ignore($this['id'])],
            'nickname'          => 'nullable|string',
            'phone'             => 'nullable|string',
            'email'             => 'nullable|email',
            'remark'            => 'nullable|string',
            'status'            => ['nullable', 'required', new InDict('data_status')],
            'data_scope_name'   => 'required|string',
            'extend_data_scope' => 'nullable',
        ];

        if (request()->route()->getActionMethod() == 'create') {
            $rules['password'] = 'required|string|min:6|max:20';
        } else {
            $rules['password'] = 'nullable|string|min:6|max:20';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'avatar'          => '头像',
            'admin_name'      => '管理员账号',
            'nickname'        => '昵称',
            'phone'           => '手机号',
            'email'           => '邮箱',
            'remark'          => '备注',
            'status'          => '状态',
            'data_scope_name' => '数据权限',
            'password'        => '密码',
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
