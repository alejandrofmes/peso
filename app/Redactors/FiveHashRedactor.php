<?php

namespace App\Redactors;

use OwenIt\Auditing\Contracts\AttributeRedactor;

class FiveHashRedactor implements AttributeRedactor
{
    /**
     * Redact the attribute value.
     *
     * @param mixed $value
     * @return string
     */
    public static function redact($value): string
    {
        // Return exactly five hashtags
        return '#####';
    }
}
