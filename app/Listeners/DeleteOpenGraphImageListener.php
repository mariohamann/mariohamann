<?php

namespace App\Listeners;

use Statamic\Events\EntryDeleted;

class DeleteOpenGraphImageListener
{
    public function handle(EntryDeleted $event)
    {
        $entry = $event->entry;

        if ($entry->collectionHandle() !== 'articles') {
            return;
        }
        $oldImagePath = public_path("social_images/{$entry->slug()}.jpg");
        if (file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }
    }
}
