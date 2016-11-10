<?php

// Grabs the value for a specific key in a json structure.
// This can be up to 25 times faster than using json_decode
// and then doing a lookup on the key.
// The closer the key is to the beginning of the string
// the faster the lookup will be.
function getValueFromJson($json, $key) {
    $matches;
    preg_match("/\"".$key."\":(\"?(.*?[^\\\\])?\"?),/", $json, $matches);
    $value = $matches ? $matches[1]: "";
    $first = substr($value, 0, 1);
    if ($first === "\"") {
        return preg_replace('/\\\"/', "\"", substr($value, 1, strlen($value) - 2));
    }
    else if ($first === "{" || $first === "[") {
        return $value;
    }
    else if ($value === "true") {
        return true;
    }
    else if ($value === "false") {
        return false;
    }
    else if ($value === "null") {
        return null;
    }
    else if ($value === "undefined") {
        return undefined;
    }
    else {
        return $value * 1;
    }
}

?>
