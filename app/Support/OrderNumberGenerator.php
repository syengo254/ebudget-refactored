<?php

namespace App\Support;

use Exception;

class OrderNumberGenerator
{
    public static function getNextCode(string $currentString): string
    {
        // Validate input format
        if (!preg_match('/^[A-Z]+\d{9}$/', $currentString)) {
            throw new Exception("Invalid input string format: $currentString");
        }

        // Split the string into its parts
        $matches = [];
        preg_match('/^([A-Z]+)(\d{9})$/', $currentString, $matches);
        $prefix = $matches[1];
        $numericPart = (int)$matches[2];

        // Increment the numeric part
        $numericPart++;

        // Check for numeric rollover (from 999999999 to 1000000000)
        if ($numericPart > 999999999) {
            $numericPart = 1; // Reset number to 1
            $prefix = static::incrementPrefix($prefix); // Increment the alphabetical prefix
        }

        // Format the new string
        return $prefix . sprintf('%09d', $numericPart);
    }

    private static function incrementPrefix(string $prefix): string
    {
        $length = strlen($prefix);
        $lastChar = $prefix[$length - 1];

        // If the last character is not 'Z', just increment it
        if ($lastChar !== 'Z') {
            $prefix[$length - 1] = chr(ord($lastChar) + 1);
            return $prefix;
        } else {
            // If the last character is 'Z', we have a rollover
            // If it's a single 'Z', it becomes 'AA'
            if ($length === 1) {
                return 'AA';
            }

            // Recursively handle the rollover for longer prefixes
            // e.g., 'AZ' becomes 'BA', 'ZZ' becomes 'AAA'
            $truncatedPrefix = substr($prefix, 0, $length - 1);
            return static::incrementPrefix($truncatedPrefix) . 'A';
        }
    }
}
