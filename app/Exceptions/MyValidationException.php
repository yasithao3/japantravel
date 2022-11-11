<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Validation\Validator;

class MyValidationException extends Exception
{
    protected $validator;

    protected $code = 200;

    protected $renderType;

    public function __construct(Validator $validator, $renderType)
    {
        $this->validator = $validator;
        $this->renderType = $renderType;
    }

    public function render()
    {
        $notify = array();
        $notify["redirect"] = "no";
        $notify["status"] = "failed";
        $notify["notify"][] = $this->validator->errors()->all();
        $response["notify"] = $notify;
        return response()->json($response);
    }
}
