<?php

namespace Oforge\Engine\Core\Helper;

/**
 * StringHelper
 *
 * @package Oforge\Engine\Core\Helper
 */
class StringHelper {

    /**
     * Prevent instance.
     */
    private function __construct() {
    }

    /**
     * Check if a string ends with a given value. If needle empty then true.
     *
     * @param string $haystack
     * @param string $needle
     *
     * @return bool
     */
    public static function endsWith(string $haystack, string $needle) {
        $length = strlen($needle);
        if ($length === 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    /**
     * Check if a string starts with a given value
     *
     * @param string $haystack
     * @param string $needle
     *
     * @return bool
     */
    public static function startsWith(string $haystack, string $needle) : bool {
        $length = strlen($needle);
        if ($length === 0) {
            return true;
        }

        return (substr($haystack, 0, $length) === $needle);
    }

    /**
     * Check if a given value is inside a string.
     *
     * @param string $haystack
     * @param string $needle
     *
     * @return bool
     */
    public static function contains(string $haystack, string $needle) : bool {
        return (strpos($haystack, $needle) !== false);
    }

    /**
     * Check if a value is found before a given string / character.
     * If found return that value, otherwise return the haystack
     *
     * @param string $haystack The part where you search inside
     * @param string $needle The separator
     *
     * @return string
     */
    public static function substringBefore(string $haystack, string $needle) : string {
        if (StringHelper::contains($haystack, $needle)) {
            return explode($needle, $haystack)[0];
        }

        // TODO: Why u return haystack, if no value found?
        // TODO: Y U NO RETURN NULL °// ?
        return $haystack;
    }

    /**
     * If the string does not begin with prefix, the string is ​​prefixed.
     *
     * @param string $string
     * @param string $prefix
     *
     * @return string
     */
    public static function leading(string $string, string $prefix) : string {
        if (strpos($string, $prefix) !== 0) {
            $string = $prefix . $string;
        }

        return $string;
    }

    /**
     * Trim string suffix.
     *
     * @param string $string
     * @param string $suffix
     *
     * @return string
     */
    public static function rightTrim(string $string, string $suffix) : string {
        $length = strlen($suffix);
        if ($length !== 0 && substr($string, -$length) === $suffix) {
            return substr($string, 0, -$length);
        }

        return $string;
    }

    /**
     * Trim string prefix.
     *
     * @param string $string
     * @param string $prefix
     *
     * @return string
     */
    public static function leftTrim(string $string, string $prefix) : string {
        $length = strlen($prefix);
        if ($length !== 0 && substr($string, 0, $length) === $prefix) {
            return substr($string, $length);
        }

        return $string;
    }

    /**
     * Returns first non empty value or null.
     *
     * @param string ...$values
     *
     * @return string|null
     */
    public static function firstNonEmpty(string...$values) {
        foreach ($values as $value) {
            if (!empty($value)) {
                return $value;
            }
        }

        return null;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function toPascalCase(string $string) : string {
        $string = trim($string);
        if (empty($string)) {
            return $string;
        }

        return implode('', array_map('ucfirst', explode('_', $string)));
    }

}
