# PHP UTIL

PRINT DEBUGGING FOR LIFE <3

## Contents

**trace()** Takes any number of arguments and datatypes and attempts to use JSON to render them to the error log.

**tracef()** Prints context and arguments of current function.

Example:
```php
class Foo {
  public function SomeFunction($bar){
    tracef();
  }
}
(new Foo())->SomeFunction("Hello World!");
```

Output:
```text
"Foo->SomeFunction" ["Hello World!"]
```
