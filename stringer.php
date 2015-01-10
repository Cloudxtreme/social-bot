<?php

/*
 * Check if $haystack contains $needle.
 * 
 * if (str_contains('this is a test', 'is')) {
 * 		echo "Found it";
 * }

 * // when you need the position, as well whether it's present
 * $needlePos = str_contains('this is a test', 'is');
 * if ($needlePos) {
 * 		echo 'Found it at position ' . ($needlePos-1);
 * }

 * // you may also ignore case
 * $needlePos = str_contains('this is a test', 'IS', true);
 * if ($needlePos) {
 * 		echo 'Found it at position ' . ($needlePos-1);
 * }
 * 
 */
 
function str_contains($haystack, $needle, $ignoreCase = false) {
    if ($ignoreCase) {
        $haystack = strtolower($haystack);
        $needle   = strtolower($needle);
    }
    $needlePos = strpos($haystack, $needle);
    return ($needlePos === false ? false : ($needlePos+1));
}


/*
 * Check if $haystack starts with $needle.
 */
function startsWith($haystack, $needle) {
    return !strncmp($haystack, $needle, strlen($needle));
}

function endsWith($haystack, $needle) {
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}



