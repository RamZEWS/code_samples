<?php

declare(strict_types=1);

namespace Core\Helper;

class TextHelper
{
    /**
     * @param string $string
     * @param string $underscore
     *
     * @return string
     */
    public static function camelToUnderscore(string $string, $underscore = '_'): string
    {
        $patterns = [
            '/([a-z]+)([0-9]+)/i',
            '/([a-z]+)([A-Z]+)/',
            '/([0-9]+)([a-z]+)/i'
        ];

        $string = preg_replace($patterns, '$1' . $underscore . '$2', $string);

        // Lowercase
        $string = strtolower($string);

        return $string;
    }

    /**
     * @return string
     */
    public static function generateCartNumber(): string
    {
        $microtime = number_format(microtime(true), 3, '', '');

        return implode('-', [
            substr($microtime, 0, 2),
            substr($microtime, 2, 6),
            substr($microtime, 6, 8),
        ]);
    }
}