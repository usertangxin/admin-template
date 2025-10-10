<?php

return [
    'upload_allow_divider' => [
        'value' => '',
        'name'  => 'Type Restrictions',

        'remark'     => '',
        'input_attr' => null,
    ],
    'upload_allow_file' => [
        'value' => 'jpg,jpeg,png,gif,svg,bmp,doc,docx,xls,xlsx,ppt,pptx,pdf,md,mp3,mp4,mov',
        'name'  => 'File Types',

        'remark'     => '',
        'input_attr' => null,
    ],
    'upload_allow_image' => [
        'value' => 'jpg,jpeg,png,gif,svg,bmp',
        'name'  => 'Image Types',

        'remark'     => '',
        'input_attr' => null,
    ],
    'upload_allow_video' => [
        'value' => 'mp4',
        'name'  => 'Video Types',

        'remark'     => '',
        'input_attr' => null,
    ],
    'upload_allow_audio' => [
        'value' => 'mp3',
        'name'  => 'Audio Types',

        'remark'     => '',
        'input_attr' => null,
    ],
    'upload_allow_document' => [
        'value' => 'txt,doc,docx,xls,xlsx,ppt,pptx,pdf,md,pem',
        'name'  => 'Document Types',

        'remark'     => '',
        'input_attr' => null,
    ],
    'upload_size_divider' => [
        'value' => '',
        'name'  => 'Size Restrictions',

        'remark'     => '',
        'input_attr' => null,
    ],
    'upload_size' => [
        'value' => '10485760',
        'name'  => 'Upload File Size',

        'remark'     => 'Unit: Byte, 1MB = 1024*1024Byte',
        'input_attr' => null,
    ],
    'upload_size_image' => [
        'value' => '1048576',
        'name'  => 'Upload Image Size',

        'remark'     => 'Unit: Byte, 1MB = 1024*1024Byte',
        'input_attr' => null,
    ],
    'upload_size_video' => [
        'value' => '10485760',
        'name'  => 'Upload Video Size',

        'remark'     => 'Unit: Byte, 1MB = 1024*1024Byte',
        'input_attr' => null,
    ],
    'upload_size_audio' => [
        'value' => '10485760',
        'name'  => 'Upload Audio Size',

        'remark'     => 'Unit: Byte, 1MB = 1024*1024Byte',
        'input_attr' => null,
    ],
    'upload_size_document' => [
        'value' => '10485760',
        'name'  => 'Upload Document Size',

        'remark'     => 'Unit: Byte, 1MB = 1024*1024Byte',
        'input_attr' => null,
    ],
    'upload_storage_divider' => [
        'value' => '',
        'name'  => 'Storage Type',

        'remark'     => '',
        'input_attr' => null,
    ],
    'storage_mode' => [
        'value' => 'public',
        'name'  => 'Default Storage',

        'remark'     => '',
        'input_attr' => [
            'options' => [['label' => 'Local Private', 'value' => 'private'], ['label' => 'Local Public', 'value' => 'public']],
        ],
    ],
    'private_status' => [
        'value' => 'normal',
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
        'value' => 'normal',
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
        'value' => 'http://127.0.0.1:8000',
        'name'  => 'Local Storage Domain',

        'remark'     => 'Local storage domain',
        'input_attr' => null,
    ],
];
