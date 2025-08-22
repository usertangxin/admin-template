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
            'avatar'     => 'nullable|string',
            'admin_name' => ['required', 'string', Rule::unique('system_admins')->ignore($this->id)],
            'nickname'   => 'nullable|string',
            'phone'      => 'nullable|string',
            'email'      => 'nullable|email',
            'remark'     => 'nullable|string',
            'status'     => [
                'nullable',
                'required',
                new InDict('data_status'),
            ],
        ];

        if (\request()->route()->getActionMethod() == 'create') {
            $rules['password'] = 'required|string|min:6|max:20';
        } else {
            $rules['password'] = 'nullable|string|min:6|max:20';
        }

        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
