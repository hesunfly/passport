<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppRequest;
use App\Models\App;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class AppController extends Controller
{
    public function index()
    {
        $services = App::all();
        return view('app.index')->with(['apps' => $services]);
    }

    public function create()
    {
        return view('app.create');
    }

    public function store(AppRequest $request)
    {
        $request_data = $request->only('name', 'app_host', 'enabled');
        $request_data['app_name'] = Str::random(16);
        $request_data['secret'] = Str::random(32);

        App::create($request_data);

        return response('success', 201);
    }

    public function edit($id)
    {
        $service = App::find('id');

        return view('app.edit')->with(['service' => $service, 'id' => $id]);
    }

    public function save($id, ServiceRequest $request)
    {
        $service = App::find($id);
        $service->update($request->only('name', 'host_url', 'enabled'));

        return response('success');
    }

    public function destroy($id)
    {
        App::destroy($id);

        return response('success', 204);
    }

    public function getAccessToken(Request $request)
    {
        $app_name = $request->input('app_name');
        $secret = $request->input('secret');

        if (empty($app_name)) {
            return responseJson(['success' => 0, 'msg' => 'app name is empty'], 400);
        }

        if (empty($secret)) {
            return responseJson(['success' => 0, 'msg' => 'app secret is empty'], 400);
        }

        $app = App::where(['app_name' => $app_name])->first();

        if (empty($app)) {
            return  responseJson(['success' => 0, 'msg' => 'app name is error'], 400);
        }

        if ($app->enable) {
            return responseJson(['success' => 0, 'msg' => 'current app disabled'], 400);
        }

        if ($app->secret != $secret) {
            return responseJson(['success' => 0, 'msg' => 'app secret is error'], 400);
        }

        $str = Str::random(6) . $app_name . $secret . time();
        $token = Hash::make($str);
        $redis_key = 'access_token_' . $app_name;
        $is_has = Redis::get($redis_key);
        if (!empty($is_has)) {
            Redis::del($is_has);
        }
        Redis::set($redis_key, $token);
        Redis::set($token, $app_name);
        $expires_at = Carbon::now()->addHours(2)->timestamp;
        Redis::expireAt($redis_key, $expires_at);
        Redis::expireAt($token, $expires_at);

        return responseJson(['success' => 1, 'msg' => 'success', 'access_token' => $token, 'expires_at' => $expires_at], 201);
    }


}
