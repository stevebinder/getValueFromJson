# json.php

A simple PHP Class for modifying json without having to use **json_decode**. The methods in this class are much faster and use less memory than **json_decode** and **json_encode** because they work using regular expressions with **preg_replace**. The methods are even more efficient when the keys you are operating on are closer to the beginning of the json.

# Notes

The json string you work with should not have spaces around the properties or their separators or it will cause **json** to fail. **json_encode** will output this format when encoding json.

**Good**: ```{"key":"value","key":"value};```

**Bad**: ```{ "key":"value", "key":"value };```

# Usage

```php
require("json.php");

$sample = '{"first":"hello","second":true,"third":"cat\"s long yarn","fourth":22}';

json::get($sample, "first"); // "hello"
json::get($sample, array("first", "second")); // array("first" => "hello", "second" => true );
json::set($sample, "first", "goodbye");
json::set($sample, array("first" => "goodbye", "second" => false));
json::remove($sample, "first");
json::remove($sample, array("first", "second"));
json::add($sample, "key", "value"); // adds key/value to the end
json::add($sample, "key", "value", true); // adds key/value to the beginning
json::add($sample, array("a" => 1, "b" => 2)); // adds the keys/values to the end
json::add($sample, array("a" => 1, "b" => 2), true); // adds the keys/values to the beginning
```
