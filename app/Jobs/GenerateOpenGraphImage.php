<?php

namespace App\Jobs;

use Spatie\Browsershot\Browsershot;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateOpenGraphImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $articleSlug;

    public function __construct($articleSlug)
    {
        $this->articleSlug = $articleSlug;
    }

    public function handle()
    {
        $url = url("/open-graph/{$this->articleSlug}");
        $slugWithoutUrlParams = explode('?', $this->articleSlug)[0];
        $path = public_path("social_images/{$slugWithoutUrlParams}.jpg");

        Browsershot::url($url)
            ->setOption('args', ['--no-sandbox'])
            ->windowSize(1200, 630) // Standard OG image size
            ->save($path);
    }
}
