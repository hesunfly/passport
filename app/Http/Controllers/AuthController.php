<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\LoginLog;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private $quest_string;

    public function __construct(Request $request)
    {
        $this->middleware('check_access_token');
        $this->quest_string = $request->getQueryString();
    }

    public function showRegisterForm()
    {
        return view('auth.register', ['request_params' => $this->quest_string]);
    }

    public function register(AuthRequest $request)
    {
        $request_data = $request->only(['name', 'password', 'email']);
        $request_data['uuid'] = Str::uuid()->toString();
        $user = User::create($request_data);

        $callback_url = $request->input('callback_url');

        $parse = parse_url($callback_url);
        if (array_key_exists('query', $parse)) {
            $callback_url .= "&";
        } else {
            $callback_url .= "?";
        }

        $callback_url .= "uuid={$user->uuid}";

        return responseJson(['redirect_url' => $callback_url]);
    }

    public function showLoginForm()
    {
        return view('auth.login', ['request_params' => $this->quest_string]);
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

        $ticket = generateTicket($user->uuid);

        $this->saveTicket($ticket, $user->uuid);

        $callback_url = $request->input('callback_url');

        $parse = parse_url($callback_url);
        if (array_key_exists('query', $parse)) {
            $callback_url .= "&";
        } else {
            $callback_url .= "?";
        }

        $callback_url .= 'ticket=' . $ticket;

        return responseJson(['redirect_url' => $callback_url]);
    }

    private function saveTicket($ticket, $uuid)
    {
        Ticket::create([
            'ticket' => $ticket,
            'uuid' => $uuid,
            'expire_at' => Carbon::now()->addMinute(5),
        ]);
    }

    public function LoginCheck(Request $request)
    {
        $ticket = $request->input('ticket');

        $has = Ticket::select(['id'])->where(['ticket' => $ticket])->first();

        if (empty($has)) {
            return responseJson(['success' => 0, 'msg' => 'ticket error!']);
        }

        $is_overdue = Ticket::select(['id', 'uuid'])->whereRaw(" ticket = '{$ticket}' and expire_at >= '" . Carbon::now() . "'")->first();

        if (empty($is_overdue)) {
            return responseJson(['success' => 0, 'msg' => 'ticket is overdue!']);
        }

        $is_overdue->delete();

        return response()->json(['uuid' => $is_overdue->uuid, 'success' => 1]);
    }

    public function getUser(Request $request)
    {
        $uuid = $request->input('uuid');

        if (empty($uuid)) {
            return responseJson(['success' => 0, 'msg' => 'uuid is empty'], 400);
        }

        $user = User::where(['uuid' => $uuid])->first();

        if (empty($user)) {
            return responseJson(['success' => 0, 'msg' => 'uuid is empty'], 400);
        }

        return responseJson(['success' => 1, 'data' => $user]);
    }

    public function logout(Request $request)
    {
        $callback = $request->input('callback');

        if (Auth::check()) {
            $user = Auth::user();
            Redis::del('login_status_' . $user->uuid);
            Auth::logout();
        }

        return redirect()->away($callback);
    }
}
