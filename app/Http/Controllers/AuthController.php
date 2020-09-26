<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\LoginLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
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
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'bail|required|string',
            'password' => 'bail|required|string|min:6|max:20',
        ]);



        $name = $request->input('username');
        if (filter_var($name, FILTER_VALIDATE_EMAIL)) {
            $authData['email'] = $name;
        } else {
            $authData['name'] = $name;
        }

        $has = User::where($authData)->first();
        if (empty($has)) {
            return response('该账户未注册！', 403);
        }

        if ($has->status == 0) {
            return response('用户已被禁用！', 403);
        }

        $authData['password'] = $request->input('password');

        if (!Auth::attempt($authData)) {
            return response('用户名或密码错误', 401);
        }

        $user = Auth::user();

        LoginLog::create([
            'user_id' => $user->id,
            'uuid' => $user->uuid,
            'ip' => $request->getClientIp(),
            'address' => 'xxx',
        ]);

        Redis::set('login_status_' . $user->uuid, '1');

       /* $ticket = $this->generateTicket();
        $this->saveTicket($ticket, $user->uuid);

        $url = $this->loginCallBackUrl($ticket);*/

        return response($user, 200);
    }
}
