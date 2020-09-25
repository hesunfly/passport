<?php

/**
 * 生成uuid
 * @function: generateUuid
 * @date: 2020/9/22
 * @user: hesunfly
 */
function generateUuid()
{
    return \Illuminate\Support\Str::uuid()->toString();
}


function responseJson($data, $statusCode)
{
    return response()->json($data)->setStatusCode($statusCode);
}
