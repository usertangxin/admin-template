<?php

return [
    'upload_allow_divider' => [
        'name'  => 'Type Restrictions',
        'remark'     => '',
        'input_attr' => null,
    ],
    'upload_allow_file' => [
        'name'  => 'File Types',
        'remark'     => '',
        'input_attr' => null,
    ],
    'upload_allow_image' => [
        'name'  => 'Image Types',
        'remark'     => '',
        'input_attr' => null,
    ],
    'upload_allow_video' => [
        'name'  => 'Video Types',
        'remark'     => '',
        'input_attr' => null,
    ],
    'upload_allow_audio' => [
        'name'  => 'Audio Types',

        'remark'     => '',
        'input_attr' => null,
    ],
    'upload_allow_document' => [
        'name'  => 'Document Types',

        'remark'     => '',
        'input_attr' => null,
    ],
    'upload_size_divider' => [
        'name'  => 'Size Restrictions',

        'remark'     => '',
        'input_attr' => null,
    ],
    'upload_size' => [
        'name'  => 'Upload File Size',

        'remark'     => 'Unit: Byte, 1MB = 1024*1024Byte',
        'input_attr' => null,
    ],
    'upload_size_image' => [
        'name'  => 'Upload Image Size',

        'remark'     => 'Unit: Byte, 1MB = 1024*1024Byte',
        'input_attr' => null,
    ],
    'upload_size_video' => [
        'name'  => 'Upload Video Size',

        'remark'     => 'Unit: Byte, 1MB = 1024*1024Byte',
        'input_attr' => null,
    ],
    'upload_size_audio' => [
        'name'  => 'Upload Audio Size',

        'remark'     => 'Unit: Byte, 1MB = 1024*1024Byte',
        'input_attr' => null,
    ],
    'upload_size_document' => [
        'name'  => 'Upload Document Size',

        'remark'     => 'Unit: Byte, 1MB = 1024*1024Byte',
        'input_attr' => null,
    ],
    'upload_storage_divider' => [
        'name'  => 'Storage Type',

        'remark'     => '',
        'input_attr' => null,
    ],
    'storage_mode' => [
        'name'  => 'Default Storage',

        'remark'     => '',
        'input_attr' => [
            'options' => [['label' => 'Local Private', 'value' => 'private'], ['label' => 'Local Public', 'value' => 'public']],
        ],
    ],
    'private_status' => [
        'name'  => 'Local Private Status',

        'remark'     => 'Local private status',
        'input_attr' => [
            'code'  => 'data_status',
            'type'  => 'info',
            'merge' => [
                'normal' => [
                    'label'  => 'Enabled',
                    'remark' => 'Normal file upload<br>This storage cannot be accessed externally',
                ],
                'disabled' => [
                    'label'  => 'Disabled',
                    'remark' => 'Upload to this storage will not be available<br>Existing files are not affected',
                ],
            ],
        ],
    ],
    'public_status' => [
        'name'  => 'Local Storage Status',

        'remark'     => 'Local storage status',
        'input_attr' => [
            'code'  => 'data_status',
            'type'  => 'info',
            'merge' => [
                'normal' => [
                    'label'  => 'Enabled',
                    'remark' => 'Normal file upload externally accessible<br><a class="arco-link" style="padding:0;line-height:1" href="javascript:request.post(route(`web.admin.SystemUploadFile.gen-symlink`))">Click to generate symlink</a>',
                ],
                'disabled' => [
                    'label'  => 'Disabled',
                    'remark' => 'Upload to this storage will not be available<br>Existing files are not affected',
                ],
            ],
        ],
    ],
    'public_domain' => [
        'name'  => 'Local Storage Domain',

        'remark'     => 'Local storage domain',
        'input_attr' => null,
    ],
];
