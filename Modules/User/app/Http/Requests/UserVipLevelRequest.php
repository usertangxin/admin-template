<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Admin\Rules\InDict;

class UserVipLevelRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:20',
                Rule::unique('user_vip_levels', 'name')->ignore($this['id']),
            ],
            'level' => [
                'required',
                'integer',
                'min:0',
                Rule::unique('user_vip_levels', 'level')->ignore($this['id']),
            ],
            'icon_image' => 'nullable|string|max:255',
            'status'     => ['required', 'string', new InDict('data_status')],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'name'       => __('user::user_vip_level.name'),
            'level'      => __('user::user_vip_level.level'),
            'icon_image' => __('user::user_vip_level.iconImage'),
            'status'     => __('user::user_vip_level.status'),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages()
    {
        return [
            'name.required'   => __('user::user_vip_level.nameRequired'),
            'name.min'        => __('user::user_vip_level.nameMin'),
            'name.max'        => __('user::user_vip_level.nameMax'),
            'name.unique'     => __('user::user_vip_level.nameExists'),
            'level.required'  => __('user::user_vip_level.levelRequired'),
            'level.integer'   => __('user::user_vip_level.levelInteger'),
            'level.min'       => __('user::user_vip_level.levelMin'),
            'level.unique'    => __('user::user_vip_level.levelExists'),
            'icon_image.max'  => __('user::user_vip_level.iconImageMax'),
            'status.required' => __('user::user_vip_level.statusRequired'),
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
