<?php

namespace Modules\Admin\Http\Controllers;

abstract class AbstractController
{
    public function success($data = null, $message = 'success', $code = 200)
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ]);
    }

    public function fail($message = 'fail', $code = 400)
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
        ]);
    }
}