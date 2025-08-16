<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Admin\Services\SystemDictService;

class RoleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name'   => ['required', 'string', Rule::unique('roles')->ignore($this->id)],
            'status' => [
                'nullable',
                'required',
                'in:' . \implode(',', SystemDictService::getInstance()->getValuesByCode('data_status')->toArray()),
            ],
            'remark' => 'nullable|string',
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
