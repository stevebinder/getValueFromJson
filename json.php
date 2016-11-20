<?php

class json {

    // Get the value of a given key
    public static function get($json, $key) {
        $setup = is_array($key) ? $key : array($key);
        $results = array();
        foreach ($setup as $a) {
            $matches;
            preg_match('/"'.$a.'":("?(.*?[^\\\\])?"?)[,\}]/', $json, $matches);
            $value = $matches ? $matches[1]: NULL;
            $first = substr($value, 0, 1);
            if ($first === "{") {
                $value .= "}";
            }
            if ($value !== "" && $first !== "{" && $first !== "[") {
                $value = json_decode($value);
            }
            $results[$a] = $value;
        }
        return !@$setup[1] ? $results[$setup[0]] : $results;
    }

    // Set the value of a given key
    // or create it if it does not exist
    public static function set($json, $key, $value = "", $first = false) {
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
            if (preg_match("/\"".$a."\"/", $json)) {
                $json = preg_replace("/\"".$a."\":(\"?(.*?[^\\\\])?\"?)([,\}])/", '"'.$a.'":'.self::_encodeValue($b)."$3", $json);
            }
            else {
                $json = self::_addProperty($json, $a, $b, $first);
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

    // Add the given values to the array
    public static function add($json, $value, $first = false) {
        $setup = !is_array($value) ? array($value) : $value;
        if ($first) {
            $setup = array_reverse($setup);
        }
        if (!$first) {
            foreach($setup as $a) {
                $json = preg_replace("/\]/", ",".self::_encodeValue($a)."]", $json);
            }
        }
        else {
            foreach($setup as $a) {
                $json = preg_replace("/\[/", "[".self::_encodeValue($a).",", $json);
            }
        }
        $json = preg_replace("/^\[,/", "[", $json);
        $json = preg_replace("/,\]$/", "]", $json);
        return $json;
    }

    private static function _addProperty($json, $key, $value = "", $first = false) {
        if (!$first) {
            $json = preg_replace("/\}$/", ",\"".$key."\":".self::_encodeValue($value)."}", $json);
        }
        else {
            $json = preg_replace("/^\{/", "{\"".$key."\":".self::_encodeValue($value).",", $json);
        }
        $json = preg_replace("/^\{,/", "{", $json);
        $json = preg_replace("/,\}$/", "}", $json);
        return $json;
    }

    private static function _encodeValue($value = NULL) {
        if (is_numeric($value) || (is_string($value) && preg_match("/^[\{\[]/", substr($value, 0, 1)))) {
            return $value;
        }
        else {
            return json_encode($value);
        }
    }
}

?>
