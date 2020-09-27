<?php

namespace App\Http\Middleware;

use App\Models\App;
use Closure;
use Illuminate\Support\Facades\Redis;

class CheckAccessToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->input('access_token');

        if (empty($token)) {
            return responseJson(['success' => 0, 'msg' => 'access_token is empty'], 400);
        }

        $app_name = Redis::get($token);

        if (empty($app_name)) {
            return response()->json([
                'success' => 0,
                'msg' => 'token invalidation',
            ])->setStatusCode(401);
        }

        $service = App::where(['app_name' => $app_name, 'enabled' => 1])->first();

        if (empty($service)) {
            return responseJson(['success' => 0, 'msg' => 'app is disabled'], 403);
        }

        return $next($request);
    }

}
