<?php

namespace App\Redactors;

use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\AttributeRedactor;

// Import Str class

class LimiterRedactor implements AttributeRedactor
{
    /**
     * Redact the attribute value.
     *
     * @param mixed $value
     * @return string
     */
    public static function redact($value): string
    {
        // Check if the value is null and return an empty string if it is
        if ($value === null) {
            return '';
        }

        // Remove HTML tags from the value
        $cleanValue = strip_tags($value);

        // Truncate the cleaned value to 250 characters
        return Str::limit($cleanValue, 500);
    }
}
