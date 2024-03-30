<?php

namespace App\Replacers;

use Illuminate\Http\Response;
use Statamic\StaticCaching\Replacer;
use App\Services\EnhanceService;

class EnhanceReplacer implements Replacer
{
    protected $enhanceService;

    public function __construct(EnhanceService $enhanceService)
    {
        $this->enhanceService = $enhanceService;
    }

    public function prepareResponseToCache(Response $response, Response $initial)
    {
        if (!$content = $response->getContent()) {
            return;
        }

        $enhancedContent = $this->enhanceService->enhanceContent($content);
        $response->setContent($enhancedContent);
    }

    public function replaceInCachedResponse(Response $response)
    {
        // This replacer does not modify the response when serving cached content.
    }
}
