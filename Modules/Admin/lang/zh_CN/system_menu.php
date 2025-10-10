<?php

return [
    'default_menus' => [
        'index'      => '系统主页',
        'permission' => '权限管理',
        'basic'      => '常规管理',
        'login'      => '登录',
    ],
    'abstract_crud_controller' => [
        'read'          => '详情',
        'create'        => '创建',
        'update'        => '编辑',
        'change_status' => '切换状态',
        'destroy'       => '删除',
        'recycle'       => '回收站',
        'recovery'      => '恢复',
        'real_destroy'  => '永久删除',
    ],
    'system_menu_controller' => [
        'index'                         => '菜单规则',
        'put_refresh_system_menu_cache' => '刷新菜单缓存',
    ],
    'system_admin_controller' => [
        'index'           => '管理员管理',
        'get_data_scopes' => '所有数据权限',
    ],
    'system_role_controller' => [
        'index' => '角色管理',
    ],
    'module_manager_controller' => [
        'index'         => '模块管理',
        'destroy'       => '模块删除',
        'change_status' => '模块启用/禁用',
    ],
    'system_config_controller' => [
        'index'     => '系统配置',
        'post_save' => '修改系统配置',
    ],
    'system_dict_controller' => [
        'index' => '字典查看',
    ],
    'system_upload_file_controller' => [
        'index'                => '附件管理',
        'post_upload'          => '上传文件',
        'post_image_upload'    => '图片上传',
        'post_video_upload'    => '视频上传',
        'post_audio_upload'    => '音频上传',
        'post_document_upload' => '文稿上传',
        'get_temporary_url'    => '获取临时链接',
        'post_gen_symlink'     => '生成公开存储软链',
    ],
];
