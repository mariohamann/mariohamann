<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;
use Extism\Plugin;
use Extism\Manifest;
use Extism\PathWasmSource;
use Illuminate\Support\Str;

class Enhance
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Exclude specific paths
        if (
            Str::startsWith($request->path(), "cp") ||
            Str::startsWith($request->path(), "api") ||
            !Str::contains($response->getContent(), "</activity-graph>")
        ) {
            return $response;
        }

        // Generate cache key based on content and file hashes
        $wasmPath = base_path("vendor/enhance/ssr-wasm/enhance-ssr.wasm");
        $jsPath = base_path("node_modules/@mariohamann/activity-graph/dist/activity-graph-wasm/en.min.js");
        $cacheKey = md5($response->getContent() . filemtime($wasmPath) . filemtime($jsPath));

        // Processing
        $start = microtime(true);
        if (Cache::has($cacheKey) && env("ENHANCE_CACHING", true)) {
            $newResponse = Cache::get($cacheKey);
            $response->setContent($newResponse);
        } else {
            $wasm = new PathWasmSource($wasmPath);
            $manifest = new Manifest($wasm);
            $enhance = new Plugin($manifest, true);

            $input = [
                "markup" => $response->getContent(),
                "elements" => [
                    "activity-graph" => file_get_contents($jsPath),
                ],
            ];

            $json = json_encode($input);
            $output = $enhance->call("ssr", $json);
            $newResponse = json_decode($output)->document;

            if (env("ENHANCE_CACHING", true)) {
                Cache::put($cacheKey, $newResponse, now()->addDays(7));
            }

            $response->setContent($newResponse);
        }

        $end = microtime(true);
        $execution_time = ($end - $start) * 1000;
        $response->header("X-Enhance-Execution-Time", $execution_time);

        return $response;
    }
}
