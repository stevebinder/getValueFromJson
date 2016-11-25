<?php

class json {

    // Get the value of a given key
    public static function get($json, $key) {
        $isArray = is_array($key);
        $setup = $isArray ? $key : array($key);
        $results = array();
        foreach ($setup as $a) {
            $info = self::_getKeyInfo($json, $a);
            if (!$info) {
                $results[$a] = null;
            }
            else {
                $results[$a] = self::_convertStringToNative($info["value"]);
            }
        }
        return $isArray ? $results : $results[$key];
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
            if (strpos($json, '"'.$a.'":') === false) {
                $json = self::_addProperty($json, $a, $b, $first);
            }
            else {
                $info = self::_getKeyInfo($json, $a);
                $json = substr($json, 0, $info["valueStart"]).self::_convertNativeToString($b).substr($json, $info["valueEnd"]);
                $info = null;
            }
        }
        return $json;
    }
    
    // Remove the given key(s)
    public static function remove($json, $key) {
        $setup = is_array($key) ? $key : array($key);
        foreach ($setup as $a) {
            $info = self::_getKeyInfo($json, $a);
            $before = 0;
            $after = 0;
            $before = @$json[$info["keyStart"] - 1] === "," ? 1 : 0;
            $after = ($before === 0 && @$json[$info["valueEnd"]] === ",") ? 1 : 0;
            $json = substr($json, 0, $info["keyStart"] - $before).substr($json, $info["valueEnd"] + $after);
        }
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

    // Decode a json string into its native form
    public static function decode($json = "", $objectNotation = false) {
        return json_decode($json, !$objectNotation);
    }

    // Encode a native object into a json string
    public static function encode($value = array()) {
        return json_encode($value);
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

    private static function _convertStringToNative($value = null) {
        if ($value === null || $value === "null" || $value === "undefined") {
            return null;
        }
        if ($value === "true") {
            return true;
        }
        if ($value === "false") {
            return false;
        }
        if ($value[0] === "\"") {
            return json_decode($value);
            //return substr($value, 1, strlen($value) - 2);
        }
        if ($value[0] === "{" || $value[0] === "[") {
            return $value;
        }
        return $value * 1;
    }

    private static function _convertNativeToString($value = null) {
        if (is_string($value) && preg_match("/^[\{\[]/", substr($value, 0, 1))) {
            return $value;
        }
        return json_encode($value);
    }

    private static function _getKeyInfo($json, $key) {
        $index = strpos($json, '"'.$key.'":');
        if ($index === false) {
            return;
        }
        $begin = $index;
        $end = $index + strlen($key) + 2;
        $start = $end + 1;
        $index = $start;
        $flag = ",";
        $first = $json[$index];
        if ($first === "{") {
            $flag = "}";
        }
        else if ($first === "[") {
            $flag = "]";
        }
        else if ($first === "\"") {
            $flag = "\"";
        }
        ++$index;
        $within = false;
        $last = $first;
        $current = $json[$index];
        $bust = ($first === "{" || $first === "[") ? $first : "";
        $open = 0;
        $value = $first;
        $reachedEnd = false;
        while (true) {
            if ($current === $flag && $last !== "\\" && !$within) {
                if ($open === 0) {
                    break;
                }
                else {
                    --$open;
                }
            }
            if ($bust && $current === $bust && !$within) {
                ++$open;
            }
            if ($current === "\"" && $last !== "\\") {
                $within = !$within;
            }
            ++$index;
            $last = $current;
            $value .= $current;
            $current = @$json[$index];
            if (!$current) {
                $reachedEnd = true;
                break;
            }
        }
        if ($reachedEnd) {
            --$index;
        }
        else if ($flag !== ",") {
            ++$index;
        }
        if ($flag === "\"") {
            $value .= "\"";
        }
        else if ($flag === "}") {
            $value .= "}";
        }
        else if ($flag === "]") {
            $value .= "]";
        }
        return array(
            "value" => $value,
            "keyStart" => $begin,
            "keyEnd" => $end,
            "valueStart" => $start,
            "valueEnd" => $index,
        );
    }
}

?>
