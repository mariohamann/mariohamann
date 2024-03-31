<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class RefreshCacheJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $paths;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $paths)
    {
        $this->paths = $paths;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->paths as $path) {
            $this->clearCache($path);
            $this->warmCache($path);
        }
    }

    protected function clearCache(string $path): void
    {
        $staticCachingPath = config('statamic.static_caching.strategies.full.path', public_path('static'));
        $globPath = $staticCachingPath . '/' . $path . '*';
        foreach (File::glob($globPath) as $file) {
            File::delete($file);
        }
    }

    protected function warmCache(string $path): void
    {
        $fullUrl = rtrim(config('app.url'), '/') . '/' . ltrim($path, '/');
        $response = Http::get($fullUrl);

        if ($response->failed()) {
            throw new \Exception("Failed to warm cache for: {$fullUrl}");
        }
    }
}
