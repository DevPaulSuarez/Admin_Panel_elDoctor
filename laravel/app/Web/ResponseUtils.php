<?php

namespace App\Web;

use stdClass;

class ResponseUtils
{
    public static function response($data, $status = 200, $errors = [])
    {
        $response = new stdClass();
        $response->data = $data;
        $response->errors = $errors;

        return response()
                ->json($response, $status);
    }
}
