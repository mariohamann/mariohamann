<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class FetchWebmentions extends Command
{
    protected $signature = 'webmentions:fetch {--debug : Run in debug mode with verbose output}';
    protected $description = 'Fetch webmentions and save them into JSON files based on wm-target.';

    public function handle()
    {
        $this->info('Fetching webmentions...');

        $perPage = $this->option('debug') ? 5 : 100;
        $page = 0;
        $allMentions = collect();

        do {
            $response = Http::get('https://webmention.io/api/mentions.jf2', [
                'domain' => 'mariohamann.com',
                'token' => env('WEBMENTION_IO_TOKEN', 'jk2GJWBtNbtsW82RE7ab7g'),
                'sort-dir' => 'up',
                'sort-by' => 'published',
                'per-page' => $perPage,
                'page' => $page,
            ]);

            $this->option('debug') && dump($response->json());

            if ($response->successful()) {
                $mentions = collect($response->json('children'));
                $allMentions = $allMentions->concat($mentions);

                if ($this->option('debug')) {
                    $this->info("Fetched page {$page} with {$mentions->count()} mentions.");
                }

                $page++;
            } else {
                $this->error('Failed to fetch webmentions.');
                return;
            }
        } while ($mentions->count() == $perPage);

        $allMentions->groupBy('wm-target')->each(function ($mentions, $target) {
            $filename = $this->generateFilename($target);
            Storage::disk('local')->put($filename, $mentions->toJson(JSON_PRETTY_PRINT));
            $this->info("Saved webmention to {$filename}");
        });

        $this->info("All webmentions have been fetched and saved.");
    }

    protected function generateFilename($url)
    {
        $slug = parse_url($url, PHP_URL_PATH);
        $slug = collect(explode('/', $slug))->reject(function ($value) {
            return empty($value);
        })->implode('-');

        return "webmentions/{$slug}.json";
    }
}
