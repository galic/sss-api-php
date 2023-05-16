<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class ConvertResponseFieldsToCamelCase
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
        $response = $next($request);
        //dd($response, $response instanceof JsonResponse);

        if ($response instanceof JsonResponse) {
            $response->setData(
                $this->convertToCamelCase(json_decode($response->content(), true))
            );
        }

        return $response;
    }
    private function convertToCamelCase($data)
    {
        if (!is_array($data)) {
            return $data;
        }

        $array = [];

        foreach ($data as $key => $value) {
            $array[Str::camel($key)] = is_array($value)
                ? $this->convertToCamelCase($value)
                : $value;
        }

        return $array;
    }
}
