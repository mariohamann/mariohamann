<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\EnhanceService;
use Illuminate\Support\Str;

class Enhance
{
    protected $enhanceService;

    public function __construct(EnhanceService $enhanceService)
    {
        $this->enhanceService = $enhanceService;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (
            Str::startsWith($request->path(), "cp") ||
            Str::startsWith($request->path(), "api")
        ) {
            return $response;
        }

        $start = microtime(true);
        $enhancedContent = $this->enhanceService->enhanceContent($response->getContent());
        $response->setContent($enhancedContent);
        $end = microtime(true);

        $execution_time = ($end - $start) * 1000;
        $response->header("X-Enhance-Execution-Time", $execution_time);

        return $response;
    }
}
