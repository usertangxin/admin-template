<?php

return [
    'default_menus' => [
        'index'      => 'System Home',
        'permission' => 'Permission Management',
        'basic'      => 'General Management',
        'login'      => 'Login',
    ],
    'abstract_crud_controller' => [
        'read'          => 'Details',
        'create'        => 'Create',
        'update'        => 'Edit',
        'change_status' => 'Change Status',
        'destroy'       => 'Delete',
        'recycle'       => 'Recycle Bin',
        'recovery'      => 'Recover',
        'real_destroy'  => 'Permanently Delete',
    ],
    'system_menu_controller' => [
        'index'                         => 'Menu Rules',
        'put_refresh_system_menu_cache' => 'Refresh Menu Cache',
    ],
    'system_admin_controller' => [
        'index'           => 'Administrator Management',
        'get_data_scopes' => 'All Data Permissions',
    ],
    'system_role_controller' => [
        'index' => 'Role Management',
    ],
    'module_manager_controller' => [
        'index'         => 'Module Management',
        'destroy'       => 'Module Deletion',
        'change_status' => 'Module Enable/Disable',
    ],
    'system_config_controller' => [
        'index'     => 'System Configuration',
        'post_save' => 'Modify System Configuration',
    ],
    'system_dict_controller' => [
        'index' => 'Dictionary View',
    ],
    'system_upload_file_controller' => [
        'index'                => 'Attachment Management',
        'post_upload'          => 'Upload File',
        'post_image_upload'    => 'Image Upload',
        'post_video_upload'    => 'Video Upload',
        'post_audio_upload'    => 'Audio Upload',
        'post_document_upload' => 'Document Upload',
        'get_temporary_url'    => 'Get Temporary URL',
        'post_gen_symlink'     => 'Generate Public Storage Symlink',
    ],
];
