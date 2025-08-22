<?php

return [

    /*
    |--------------------------------------------------------------------------
    | 验证语言行
    |--------------------------------------------------------------------------
    |
    | 以下语言行包含验证器类的默认错误消息。有些规则有多个版本，
    | 如大小规则。您可以根据需要自由修改这些消息。
    |
    */

    'accepted'        => ':attribute 字段必须接受。',
    'accepted_if'     => '当 :other 为 :value 时，:attribute 字段必须接受。',
    'active_url'      => ':attribute 字段必须是有效的 URL。',
    'after'           => ':attribute 字段必须是 :date 之后的日期。',
    'after_or_equal'  => ':attribute 字段必须是 :date 之后或等于 :date 的日期。',
    'alpha'           => ':attribute 字段只能包含字母。',
    'alpha_dash'      => ':attribute 字段只能包含字母、数字、短横线和下划线。',
    'alpha_num'       => ':attribute 字段只能包含字母和数字。',
    'any_of'          => ':attribute 字段无效。',
    'array'           => ':attribute 字段必须是数组。',
    'ascii'           => ':attribute 字段只能包含单字节字母数字字符和符号。',
    'before'          => ':attribute 字段必须是 :date 之前的日期。',
    'before_or_equal' => ':attribute 字段必须是 :date 之前或等于 :date 的日期。',
    'between'         => [
        'array'   => ':attribute 字段必须包含 :min 到 :max 个项目。',
        'file'    => ':attribute 字段必须介于 :min 到 :max 千字节之间。',
        'numeric' => ':attribute 字段必须介于 :min 到 :max 之间。',
        'string'  => ':attribute 字段必须介于 :min 到 :max 个字符之间。',
    ],
    'boolean'           => ':attribute 字段必须为 true 或 false。',
    'can'               => ':attribute 字段包含未授权的值。',
    'confirmed'         => ':attribute 字段的确认值不匹配。',
    'contains'          => ':attribute 字段缺少必需的值。',
    'current_password'  => '密码不正确。',
    'date'              => ':attribute 字段必须是有效的日期。',
    'date_equals'       => ':attribute 字段必须是等于 :date 的日期。',
    'date_format'       => ':attribute 字段必须匹配格式 :format。',
    'decimal'           => ':attribute 字段必须有 :decimal 位小数。',
    'declined'          => ':attribute 字段必须拒绝。',
    'declined_if'       => '当 :other 为 :value 时，:attribute 字段必须拒绝。',
    'different'         => ':attribute 字段和 :other 必须不同。',
    'digits'            => ':attribute 字段必须是 :digits 位数字。',
    'digits_between'    => ':attribute 字段必须介于 :min 到 :max 位数字之间。',
    'dimensions'        => ':attribute 字段的图片尺寸无效。',
    'distinct'          => ':attribute 字段有重复值。',
    'doesnt_end_with'   => ':attribute 字段不得以下列之一结尾：:values。',
    'doesnt_start_with' => ':attribute 字段不得以下列之一开头：:values。',
    'email'             => ':attribute 字段必须是有效的电子邮件地址。',
    'ends_with'         => ':attribute 字段必须以下列之一结尾：:values。',
    'enum'              => '所选的 :attribute 无效。',
    'exists'            => '所选的 :attribute 无效。',
    'extensions'        => ':attribute 字段必须具有以下扩展名之一：:values。',
    'file'              => ':attribute 字段必须是文件。',
    'filled'            => ':attribute 字段必须有值。',
    'gt'                => [
        'array'   => ':attribute 字段必须包含多于 :value 个项目。',
        'file'    => ':attribute 字段必须大于 :value 千字节。',
        'numeric' => ':attribute 字段必须大于 :value。',
        'string'  => ':attribute 字段必须大于 :value 个字符。',
    ],
    'gte' => [
        'array'   => ':attribute 字段必须包含 :value 个或更多项目。',
        'file'    => ':attribute 字段必须大于或等于 :value 千字节。',
        'numeric' => ':attribute 字段必须大于或等于 :value。',
        'string'  => ':attribute 字段必须大于或等于 :value 个字符。',
    ],
    'hex_color'     => ':attribute 字段必须是有效的十六进制颜色。',
    'image'         => ':attribute 字段必须是图片。',
    'in'            => '所选的 :attribute 无效。',
    'in_array'      => ':attribute 字段必须存在于 :other 中。',
    'in_array_keys' => ':attribute 字段必须包含至少一个以下键：:values。',
    'integer'       => ':attribute 字段必须是整数。',
    'ip'            => ':attribute 字段必须是有效的 IP 地址。',
    'ipv4'          => ':attribute 字段必须是有效的 IPv4 地址。',
    'ipv6'          => ':attribute 字段必须是有效的 IPv6 地址。',
    'json'          => ':attribute 字段必须是有效的 JSON 字符串。',
    'list'          => ':attribute 字段必须是列表。',
    'lowercase'     => ':attribute 字段必须为小写。',
    'lt'            => [
        'array'   => ':attribute 字段必须包含少于 :value 个项目。',
        'file'    => ':attribute 字段必须小于 :value 千字节。',
        'numeric' => ':attribute 字段必须小于 :value。',
        'string'  => ':attribute 字段必须小于 :value 个字符。',
    ],
    'lte' => [
        'array'   => ':attribute 字段不得包含多于 :value 个项目。',
        'file'    => ':attribute 字段必须小于或等于 :value 千字节。',
        'numeric' => ':attribute 字段必须小于或等于 :value。',
        'string'  => ':attribute 字段必须小于或等于 :value 个字符。',
    ],
    'mac_address' => ':attribute 字段必须是有效的 MAC 地址。',
    'max'         => [
        'array'   => ':attribute 字段不得包含多于 :max 个项目。',
        'file'    => ':attribute 字段不得大于 :max 千字节。',
        'numeric' => ':attribute 字段不得大于 :max。',
        'string'  => ':attribute 字段不得大于 :max 个字符。',
    ],
    'max_digits' => ':attribute 字段不得包含多于 :max 位数字。',
    'mimes'      => ':attribute 字段必须是以下类型的文件：:values。',
    'mimetypes'  => ':attribute 字段必须是以下 MIME 类型的文件：:values。',
    'min'        => [
        'array'   => ':attribute 字段必须至少包含 :min 个项目。',
        'file'    => ':attribute 字段必须至少 :min 千字节。',
        'numeric' => ':attribute 字段必须至少 :min。',
        'string'  => ':attribute 字段必须至少 :min 个字符。',
    ],
    'min_digits'       => ':attribute 字段必须至少包含 :min 位数字。',
    'missing'          => ':attribute 字段必须不存在。',
    'missing_if'       => '当 :other 为 :value 时，:attribute 字段必须不存在。',
    'missing_unless'   => '除非 :other 为 :value，否则 :attribute 字段必须不存在。',
    'missing_with'     => '当 :values 存在时，:attribute 字段必须不存在。',
    'missing_with_all' => '当 :values 都存在时，:attribute 字段必须不存在。',
    'multiple_of'      => ':attribute 字段必须是 :value 的倍数。',
    'not_in'           => '所选的 :attribute 无效。',
    'not_regex'        => ':attribute 字段格式无效。',
    'numeric'          => ':attribute 字段必须是数字。',
    'password'         => [
        'letters'       => ':attribute 字段必须至少包含一个字母。',
        'mixed'         => ':attribute 字段必须至少包含一个大写字母和一个小写字母。',
        'numbers'       => ':attribute 字段必须至少包含一个数字。',
        'symbols'       => ':attribute 字段必须至少包含一个符号。',
        'uncompromised' => '给定的 :attribute 已出现在数据泄露中。请选择不同的 :attribute。',
    ],
    'present'                => ':attribute 字段必须存在。',
    'present_if'             => '当 :other 为 :value 时，:attribute 字段必须存在。',
    'present_unless'         => '除非 :other 为 :value，否则 :attribute 字段必须存在。',
    'present_with'           => '当 :values 存在时，:attribute 字段必须存在。',
    'present_with_all'       => '当 :values 都存在时，:attribute 字段必须存在。',
    'prohibited'             => ':attribute 字段被禁止。',
    'prohibited_if'          => '当 :other 为 :value 时，:attribute 字段被禁止。',
    'prohibited_if_accepted' => '当 :other 被接受时，:attribute 字段被禁止。',
    'prohibited_if_declined' => '当 :other 被拒绝时，:attribute 字段被禁止。',
    'prohibited_unless'      => '除非 :other 在 :values 中，否则 :attribute 字段被禁止。',
    'prohibits'              => ':attribute 字段禁止 :other 存在。',
    'regex'                  => ':attribute 字段格式无效。',
    'required'               => ':attribute 字段是必需的。',
    'required_array_keys'    => ':attribute 字段必须包含以下条目的键：:values。',
    'required_if'            => '当 :other 为 :value 时，:attribute 字段是必需的。',
    'required_if_accepted'   => '当 :other 被接受时，:attribute 字段是必需的。',
    'required_if_declined'   => '当 :other 被拒绝时，:attribute 字段是必需的。',
    'required_unless'        => '除非 :other 在 :values 中，否则 :attribute 字段是必需的。',
    'required_with'          => '当 :values 存在时，:attribute 字段是必需的。',
    'required_with_all'      => '当 :values 都存在时，:attribute 字段是必需的。',
    'required_without'       => '当 :values 不存在时，:attribute 字段是必需的。',
    'required_without_all'   => '当 :values 都不存在时，:attribute 字段是必需的。',
    'same'                   => ':attribute 字段必须与 :other 匹配。',
    'size'                   => [
        'array'   => ':attribute 字段必须包含 :size 个项目。',
        'file'    => ':attribute 字段必须是 :size 千字节。',
        'numeric' => ':attribute 字段必须是 :size。',
        'string'  => ':attribute 字段必须是 :size 个字符。',
    ],
    'starts_with' => ':attribute 字段必须以下列之一开头：:values。',
    'string'      => ':attribute 字段必须是字符串。',
    'timezone'    => ':attribute 字段必须是有效的时区。',
    'unique'      => ':attribute 已被占用。',
    'uploaded'    => ':attribute 上传失败。',
    'uppercase'   => ':attribute 字段必须为大写。',
    'url'         => ':attribute 字段必须是有效的 URL。',
    'ulid'        => ':attribute 字段必须是有效的 ULID。',
    'uuid'        => ':attribute 字段必须是有效的 UUID。',
    'in_dict'     => ':attribute 字段值 :value 不在字典 :dict 中。',

    /*
    |--------------------------------------------------------------------------
    | 自定义验证语言行
    |--------------------------------------------------------------------------
    |
    | 以下语言行用于指定自定义验证消息，
    | 用于属性使用 "attribute.rule" 命名的行。
    | 这使您可以快速指定给定属性规则的特定自定义语言行。
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => '自定义消息',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | 自定义验证属性
    |--------------------------------------------------------------------------
    |
    | 以下语言行用于交换我们的属性占位符
    | 与更具可读性的内容，如 "E-Mail Address" 而不是 "email"。
    | 这只是使我们的消息更具表现力。
    |
    */

    'attributes' => [],

];
