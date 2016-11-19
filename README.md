# json.php

A simple PHP Class for modifying json without having to use **json_decode**. The methods in this class are much faster and use less memory than **json_decode** and **json_encode** because they work using regular expressions with **preg_replace**. The methods are even more efficient when the keys you are operating on are closer to the beginning of the json.

# Notes

The json string you work with should not have spaces around the properties or their separators or it will cause **json** to fail. **json_encode** will output this format when encoding json.

**Good**: ```{"key":"value","key":"value};```

**Bad**: ```{ "key":"value", "key":"value };```

# Usage

```php
require("json.php");

$object = '{"first":"hello","second":true,"third":"cat\"s long yarn","fourth":22}';
$array = '[1,2]';

// use these when working with objects
json::get($object, "first"); // "hello"
json::get($object, "missing"); // null
json::get($object, array("first", "second")); // array("first" => "hello", "second" => true );
json::set($object, "first", "goodbye"); // set the key or add it at the end
json::set($object, "first", "goodbye", true); // set the key or add it at the beginning 
json::set($object, array("first" => "goodbye", "second" => false)); // set multiple keys to the end
json::set($object, array("first" => "goodbye", "second" => false), true); // set multiple keys to the beginning
json::remove($object, "first"); // remove one key
json::remove($object, array("first", "second")); // remove multiple keys

// use these when working with arrays
json::add($array, 3); // [1,2,3]
json::add($array, 0); // [0,1,2]
```
