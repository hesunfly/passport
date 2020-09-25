<?php

namespace App\Http\Requests;

class AuthRequest extends Request
{

    public function rules()
    {
        return [
            'name' => [
                'bail',
                'required',
                'string',
                'min:5',
                'max:20',
                'unique:users,name',
            ],
            'password' => [
                'bail',
                'required',
                'string',
                'min:6',
                'max:20',
            ],
            'email' => [
                'bail',
                'required',
                'string',
                'email',
                'unique:users,email',
            ],
        ];
    }

}
