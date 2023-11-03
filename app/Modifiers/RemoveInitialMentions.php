<?php

namespace App\Modifiers;

use Statamic\Modifiers\Modifier;

class RemoveInitialMentions extends Modifier
{
    /**
     * Removes words that start with '@' from the beginning of the content.
     *
     * @param mixed $value The value to be modified.
     * @param array $params Any parameters used in the modifier.
     * @param array $context The context with data surrounding the value.
     *
     * @return string
     */
    public function index($value, $params, $context)
    {
        // This pattern matches words starting with @ at the beginning of the string,
        // and stops when it encounters a word not starting with @.
        $pattern = '/^(?:@\w+\s+)+/';

        // Remove the matches from the beginning of the string.
        $cleanedValue = preg_replace($pattern, '', $value);

        return $cleanedValue;
    }
}
