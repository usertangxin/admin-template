<?php

namespace Modules\Admin\Classes\Utils;

use InvalidArgumentException;

class FormToken
{
    public function __construct() {}

    public function getToken()
    {
        $form_token = md5(uniqid(rand(), true));
        session()->put('form_token', $form_token);

        return $form_token;
    }

    public function checkToken()
    {
        $form_token = request()->input('__form_token__');

        if (empty($form_token)) {
            throw new InvalidArgumentException('表单token不能为空');
        }

        if ($form_token !== session()->get('form_token')) {
            throw new InvalidArgumentException('表单token失效');
        }

        session()->forget('form_token');
        request()->request->remove('__form_token__');
    }
}
