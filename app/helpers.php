<?php

use Illuminate\Support\Str;
/**
 * 生成uuid
 * @function: generateUuid
 * @date: 2020/9/22
 * @user: hesunfly
 */
function generateUuid()
{
    return Str::uuid()->toString();
}

/**
 * 响应json
 * @function: responseJson
 * @date: 2020/9/27
 * @user: hesunfly
 * @param $data
 * @param int $statusCode
 * @return \Illuminate\Http\JsonResponse
 */
function responseJson($data, $statusCode = 200)
{
    return response()->json($data)->setStatusCode($statusCode);
}

/**
 * 返回access_token的 redis key
 * @function: generateAccessTokenCacheKeyByToken
 * @date: 2020/9/27
 * @user: hesunfly
 * @param $token
 * @return string
 */
function generateAccessTokenCacheKeyByToken($token)
{
    return 'access_token_' . $token;
}

/**
 * 生成ticket
 * @function: generateTicket
 * @date: 2020/9/27
 * @user: hesunfly
 * @param $uuid
 * @return string
 */
function generateTicket($uuid)
{
    return md5(Str::random(6) . $uuid);
}

function http_get($url, $data)
{
    $client = new \GuzzleHttp\Client();
    try {
        $response = $client->get($url, ['query' => $data]);

        if ($response->getStatusCode() == 200) {
            $res = $response->getBody()->getContents();
            return \json_decode($res, true);
        }

    } catch (\GuzzleHttp\Exception\ClientException $exception) {
        dd($exception->getResponse()->getBody()->getContents());
    }
}

function http_post($path, $data, $host = '')
{
    if (empty($host)) {
        $host = env('SSO_SERVER_URL');
    }
    $client = new Client(['base_uri' => $host]);
    $response = $client->post($path, ['form_params' => $data]);
    if ($response->getStatusCode() == 200) {
        $res = $response->getBody()->getContents();
        $res_fmt = \json_decode($res, true);
        return $res_fmt;
    }

    return [];
}
