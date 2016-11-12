<?php

class json {

    // Get the value of a given key
    public static function get($json, $key) {
        $setup = is_array($key) ? $key : array($key);
        $results = array();
        foreach ($setup as $a) {
            $matches;
            preg_match("/\"".$a."\":(\"?(.*?[^\\\\])?\"?)[,\}]/", $json, $matches);
            $value = $matches ? $matches[1]: "";
            $first = substr($value, 0, 1);
            if ($value !== "" && $first !== "{" && $first !== "[") {
                $value = json_decode($value);
            }
            $results[$a] = $value;
        }
        return !@$setup[1] ? $results[$setup[0]] : $results;
    }

    // Set the value of a given key
    // or create it if it does not exist
    public static function set($json, $key, $value = "") {
        $setup = array();
        if (is_array($key)) {
            $setup = $key;
        }
        else {
            $setup[$key] = $value;
        }
        foreach ($setup as $a => $b) {
            if (preg_match("/\"".$a."\"/", $json)) {
                $json = preg_replace("/\"".$a."\":(\"?(.*?[^\\\\])?\"?)([,\}])/", '"'.$a.'":'.json_encode($b)."$3", $json);
            }
            else {
                $json = self::add($json, $a, $b);
            }
        }
        return $json;
    }
    
    // Remove the given key(s)
    public static function remove($json, $key) {
        $setup = is_array($key) ? $key : array($key);
        foreach ($setup as $a) {
            $json = preg_replace('/,?"'.$a.'":\"?([\s\S]*?[^\\\\])?"?(,|(\\}))/', "$2", $json);
        }
        $json = preg_replace("/^\{,/", "{", $json);
        return $json;
    }

    // Add the given key to the end of the structure
    // or if the last argument is specified
    // add it to the beginning
    public static function add($json, $key, $value = "", $first = false) {
        $setup = array();
        if (is_array($key)) {
            $setup = $key;
            $first = $value;
        }
        else {
            $setup[$key] = $value;
        }
        if ($first) {
            $setup = array_reverse($setup);
        }
        foreach ($setup as $a => $b) {
            if (!$first) {
                $json = preg_replace("/\}$/", ",\"".$a."\":".json_encode($b)."}", $json);
            }
            else {
                $json = preg_replace("/^\{/", "\"".$a."\":".json_encode($b).",", $json);
            }
        }
        $json = preg_replace("/^\{,/", "{", $json);
        $json = preg_replace("/,\}$/", "}", $json);
        return $json;
    }
}

?>
