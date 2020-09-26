<?php

namespace App\Http\Requests;

class AppRequest extends Request
{

    public function rules()
    {
        return [
            'name' => [
                'bail',
                'string'
            ],
            'host_uri' => [
                'bail', 'string'
            ],
        ];
    }

}
