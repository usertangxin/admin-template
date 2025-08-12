<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Admin\Services\SystemDictService;

class RoleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:roles,name',
            'status'     => [
                'nullable',
                'required',
                'in:' . \implode(',', SystemDictService::getInstance()->getValuesByCode('data_status')->toArray()),
            ],
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
