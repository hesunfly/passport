<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(AuthRequest $request)
    {
        $request_data = $request->only(['name', 'password', 'email']);
        $request_data['uuid'] = Str::uuid()->toString();
        User::create($request_data);
        /*$callback = $request->input('callback');

        $client = new Client();
        unset($request_data['password']);
        $response = $client->post($callback, ['form_params' => $request_data]);
        if ($response->getStatusCode() != 200) {
            return response('error', 400);
        }

        $redirect = $request->input('redirect');*/
        return response('', 201);
    }

    public function showLoginForm()
    {

    }

    public function login()
    {

    }
}
