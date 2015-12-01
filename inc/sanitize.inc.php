<?php

/**
 * Strips input string of all but a small subset of Latin characters and numerals.
 *
 * @param $value The string to sanitize
 * @return Sanitized string
 */
function sanitize_string($value)
{
    return preg_replace('/[^a-zA-Z0-9 _\-\.]+/', '', $value);
}

/**
 * Strips input string of any non-numeric related characters.
 *
 * @param $value The string to sanitize
 * @return Sanitized string
 */
function sanitize_numeric($value)
{
    return preg_replace('/[^0-9-.]+/', '', $value);
}

?>