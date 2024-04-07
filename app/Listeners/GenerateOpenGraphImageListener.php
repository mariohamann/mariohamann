<?php

namespace App\Listeners;

use Statamic\Events\EntrySaving;
use App\Jobs\GenerateOpenGraphImage;
use Statamic\Facades\Entry;

class GenerateOpenGraphImageListener
{
    public function handle(EntrySaving $event)
    {
        $entry = $event->entry;

        if ($entry->collectionHandle() !== 'articles') {
            return;
        }

        // Always regenerate the image for new entries
        if (!$entry->id()) {
            $this->dispatchImageGenerationJob($entry);
            return;
        }

        // For existing entries, check for changes
        $originalEntry = Entry::find($entry->id());

        if (
            $entry->slug() != $originalEntry->slug() ||
            $entry->get('title') != $originalEntry->get('title') ||
            $entry->get('teaser') != $originalEntry->get('teaser')
        ) {
            // Handle slug change: delete old image
            if ($entry->slug() != $originalEntry->slug()) {
                $oldImagePath = public_path("social_images/{$originalEntry->slug()}.jpg");
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $this->dispatchImageGenerationJob($entry);
        }
    }

    /**
     * Dispatches the job to generate or regenerate the open graph image.
     *
     * @param \Statamic\Entries\Entry $entry The entry instance.
     */
    protected function dispatchImageGenerationJob($entry)
    {
        $slug = $entry->slug();
        $title = $entry->get('title');
        $teaser = $entry->get('teaser');

        GenerateOpenGraphImage::dispatch($slug . '?title=' . urlencode($title) . '&teaser=' . urlencode($teaser));
    }
}
