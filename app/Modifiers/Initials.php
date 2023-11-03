<?php

namespace App\Modifiers;

use Statamic\Modifiers\Modifier;

class Initials extends Modifier
{
    /**
     * Create initials from a full name.
     *
     * @param mixed $value The value to be modified.
     * @param array $params Any parameters used in the modifier.
     * @param array $context The context with data surrounding the value.
     *
     * @return string
     */
    public function index($value, $params, $context)
    {
        // Get the number of initials to return. Default to all if not specified.
        $limit = $params[0] ?? 2;

        // Split the name into words.
        $words = explode(' ', $value);

        // Get the first letter of each word.
        $initials = array_map(function ($word) {
            return mb_substr($word, 0, 1);
        }, $words);

        // Slice the initials if a limit is specified.
        if ($limit !== null && is_numeric($limit)) {
            $initials = array_slice($initials, 0, intval($limit));
        }

        // Return the uppercase initials as a string.
        return strtoupper(implode('', $initials));
    }
}
