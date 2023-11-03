<?php

namespace App\Tags;

use Statamic\Tags\Tags;
use Illuminate\Support\Facades\Storage;

class Webmentions extends Tags
{
    protected static $aliases = ['webmentions'];

    /**
     * The {{ webmentions }} tag.
     *
     * @return string|array
     */
    public function index()
    {
        // Get the current slug and optional property filter from the context.
        $slug = $this->params->get('slug');
        $propertyFilter = $this->params->get('wm-property');

        // Generate the filename where the webmentions are stored.
        $filename = 'webmentions/' . $slug . '.json';

        if (Storage::disk('local')->exists($filename)) {
            $mentions = collect(json_decode(Storage::disk('local')->get($filename), true));

            // Apply the property filter if provided.
            if ($propertyFilter) {
                $mentions = $mentions->where('wm-property', $propertyFilter);
            }

            return ['mentions' => $mentions->all()];
        }

        return [];
    }
}
