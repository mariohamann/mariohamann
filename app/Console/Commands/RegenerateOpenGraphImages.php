<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Statamic\Facades\Entry;
use App\Jobs\GenerateOpenGraphImage;

class RegenerateOpenGraphImages extends Command
{
    protected $signature = 'og:regenerate';
    protected $description = 'Regenerate all Open Graph images for articles.';

    public function handle()
    {
        GenerateOpenGraphImage::dispatch('home');

        $articles = Entry::whereCollection('articles');

        foreach ($articles as $article) {
            GenerateOpenGraphImage::dispatch($article->slug());
            $this->info("Dispatched job for {$article->slug()}.");
        }
    }
}
