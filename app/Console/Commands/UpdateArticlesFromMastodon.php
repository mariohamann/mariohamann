<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Statamic\Facades\Entry;
use Illuminate\Support\Facades\Http;

class UpdateArticlesFromMastodon extends Command
{
    protected $signature = 'statamic:update-from-mastodon';
    protected $description = 'Updates Statamic posts with data from Mastodon API';

    public function handle()
    {
        // Step 1: Get all blog posts from the 'article' collection
        $articles = Entry::query()
            ->where('collection', 'articles') // Replace 'articles' with the correct collection handle
            ->get();

        // Step 2: Iterate over articles and fetch Mastodon data
        foreach ($articles as $article) {
            $mastodonStatus = $article->get('mastodon_status');
            $mastodonStatusId = $mastodonStatus['id'] ?? null;

            if (!$mastodonStatusId) {
                continue; // Skip if there's no Mastodon status ID
            }

            // Step 3: Fetch data from Mastodon API
            $url = "https://indieweb.social/api/v1/statuses/{$mastodonStatusId}";
            $response = Http::get($url);

            if (!$response->successful()) {
                $this->error("Failed to fetch data for status ID: {$mastodonStatusId}");
                continue;
            }

            $mastodonData = $response->json();

            // Step 4: Update the Statamic entry with Mastodon data
            // Update nested data within 'mastodon_status'
            $mastodonStatus['replies_count'] = $mastodonData['replies_count'];
            $mastodonStatus['reblogs_count'] = $mastodonData['reblogs_count'];
            $mastodonStatus['favourites_count'] = $mastodonData['favourites_count'];

            // Re-set the entire 'mastodon_status' array
            $article->set('mastodon_status', $mastodonStatus);

            // Save the updated entry
            $article->save();

            $this->info("Updated article: {$article->id()} with Mastodon data");
        }

        $this->info('All articles have been updated.');
    }
}
