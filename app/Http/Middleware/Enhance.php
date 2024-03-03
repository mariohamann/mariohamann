<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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

        // check if the request is for the control panel
        if (
            Str::startsWith($request->path(), "cp") ||
            Str::startsWith($request->path(), "api") ||
            !Str::contains($response->getContent(), "</activity-graph>")
        ) {
            return $response;
        }

        // start time
        $start = microtime(true);

        $wasm = new PathWasmSource(base_path("vendor/enhance/ssr-wasm/enhance-ssr.wasm"));
        $manifest = new Manifest($wasm);
        $enhance = new Plugin($manifest, true);

        $input = [
            "markup" => $response->getContent(),
            "elements" => [
                // get laravel root
                "activity-graph" => Str::replaceFirst(
                    'export default ',
                    '',
                    file_get_contents(base_path("node_modules/activity-graph/dist/activity-graph-wasm.js"))
                ),
            ],

        ];

        $json = json_encode($input);

        $output = $enhance->call("ssr", $json);

        $newResponse = json_decode($output)->document;
        $response->setContent($newResponse);

        // end time
        $end = microtime(true);

        // execution time in microseconds
        $execution_time = ($end - $start) * 1000;

        // add header
        $response->header("X-Enhance-Execution-Time", $execution_time);

        return $response;
    }
}
