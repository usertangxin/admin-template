<?php

use Modules\Admin\Classes\Utils\SystemConfigInputType;

return [
    ['group' => 'agreement', 'key' => 'user_agreement', 'value' => '', 'name' => '用户协议', 'input_type' => SystemConfigInputType::WANG_EDITOR,  'sort' => 100, 'remark' => '', 'bind_p_config' => null, 'input_attr' => null],
    ['group' => 'agreement', 'key' => 'privacy_agreement', 'value' => '', 'name' => '隐私协议', 'input_type' => SystemConfigInputType::WANG_EDITOR,  'sort' => 100, 'remark' => '', 'bind_p_config' => '', 'input_attr' => null],
];
