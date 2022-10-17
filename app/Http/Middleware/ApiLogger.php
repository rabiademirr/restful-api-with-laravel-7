<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ApiLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
    public function terminate(Request  $request, Response $response){
        $startTime = LARAVEL_START;
        $endTime = microtime(true);
        $createdOn = date('Y-m-d H:i:s');
        $logFileContent = $createdOn .'-'. ($endTime-$startTime)*100 . 'ms';
        $logFileContent .= $request->ip();
        $logFileContent .= $request->method();

        Log::info($logFileContent);


    }
}
