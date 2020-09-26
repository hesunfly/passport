<?php

namespace App\Http\Controllers;

use App\Models\LoginLog;
use App\Models\User;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index')->with(['users' => \json_encode($users)]);
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(ServiceRequest $request)
    {
        $request_data = $request->only('name', 'host_url', 'enabled');
        $request_data['app_name'] = Str::random(16);
        $request_data['secret'] = Str::random(32);

        App::create($request_data);

        return response('success', 201);
    }

    public function edit($id)
    {
        $service = App::find('id');

        return view('services.edit')->with(['service' => $service, 'id' => $id]);
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

    public function loginLogs()
    {
        $logs = LoginLog::all();
    }
}
