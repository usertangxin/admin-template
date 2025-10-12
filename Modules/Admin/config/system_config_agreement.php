<?php

use Modules\Admin\Classes\Utils\SystemConfigInputType;

return [
    [
        'group' => 'agreement',
        'key'   => 'user_agreement',
        'value' => '',
        'name'  => [
            'zh_CN' => '用户协议',
            'en'    => 'User Agreement',
        ],
        'input_type'    => SystemConfigInputType::WANG_EDITOR,
        'sort'          => 100,
        'remark'        => '',
        'bind_p_config' => null,
        'input_attr'    => null,
    ],
    [
        'group' => 'agreement',
        'key'   => 'privacy_agreement',
        'value' => '',
        'name'  => [
            'zh_CN' => '隐私协议',
            'en'    => 'Privacy Agreement',
        ],
        'input_type'    => SystemConfigInputType::WANG_EDITOR,
        'sort'          => 100,
        'remark'        => '',
        'bind_p_config' => '',
        'input_attr'    => null,
    ],
];
