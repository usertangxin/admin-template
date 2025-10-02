<?php

namespace Modules\CrudGenerate\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SystemCrudHistoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'table_name'       => 'required|string',
            'table_comment'    => 'string',
            'soft_delete'      => 'required|in:yes,no',
            'primary_key'      => 'required|string',
            'parent_menu_code' => 'string',
            'menu_name'        => 'required|string',
            'menu_icon'        => 'string',
            'gen_mode'         => 'required|in:app,module',
            'gen_class_name'   => 'required|string',
            'column_list'      => 'required|array',
            'module_name'      => 'string|nullable',
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
