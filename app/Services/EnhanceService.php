<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Extism\Plugin;
use Extism\Manifest;
use Extism\PathWasmSource;
use Illuminate\Support\Str;

class EnhanceService
{
    public function enhanceContent($content): string
    {
        if (!Str::contains($content, "<activity-graph")) {
            return $content;
        }

        $wasmPath = base_path("vendor/enhance/ssr-wasm/enhance-ssr.wasm");
        $jsPath = base_path("node_modules/@mariohamann/activity-graph/dist/activity-graph-wasm/en.min.js");

        $cacheKey = md5($content . filemtime($wasmPath) . filemtime($jsPath));

        if (Cache::has($cacheKey) && env("ENHANCE_CACHING", true)) {
            return Cache::get($cacheKey);
        }

        $wasm = new PathWasmSource($wasmPath);
        $manifest = new Manifest($wasm);
        $enhance = new Plugin($manifest, true);

        $input = [
            "markup" => $content,
            "elements" => [
                "activity-graph" => file_get_contents($jsPath),
            ],
        ];

        $json = json_encode($input);
        $output = $enhance->call("ssr", $json);
        $newContent = json_decode($output)->document;

        if (env("ENHANCE_CACHING", true)) {
            Cache::put($cacheKey, $newContent, now()->addDays(7));
        }

        return $newContent;
    }
}
