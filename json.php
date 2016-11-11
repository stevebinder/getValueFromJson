<?php

class json {

    // Get the value of a given key
    public static function get($json, $key) {
        $matches;
        preg_match("/\"".$key."\":(\"?(.*?[^\\\\])?\"?)[,\}]/", $json, $matches);
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

    // Set the value of a given key
    // or create it if it does not exist
    public static function set($json, $key, $value = "") {
        if (preg_match("/\"".$key."\"/", $json)) {
            return preg_replace("/\"".$key."\":(\"?(.*?[^\\\\])?\"?)([,\}])/", '"'.$key.'":'.json_encode($value)."$3", $json);
        }
        else {
            self::add($json, $key, $value);
        }
    }
    
    // Remove the given key
    public static function remove($json, $key) {
        return preg_replace('/"'.$key.'":("?(.*?[^\\\\])?"?)((, )|\})/', "", $json);
    }

    // Add the given key to the end of the structure
    // or if the last argument is specified
    // add it to the beginning
    public static function add($json, $key, $value = "", $first = false) {
        if (!$first) {
            return substr($json, 0, strlen($json) - 1) . ", \"".$key."\":".json_encode($value)."}";
        }
        else {
            return "{\"".$key."\":".json_encode($value).", ".substr($json, 1, strlen($json));
        }
    }
}

?>
