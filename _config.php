<?PHP

/*
 * Takes any number of arguments and datatypes and attempts to use JSON to render them to the error log
 */
function trace(){
   $result = [];
   $args = func_get_args();
   foreach ($args as &$arg) { $result[] = json_encode($arg); }
   $output = str_replace('\\', '', implode(" ", $result));
   if ( in_array(substr($output, 0, 1), array("{", "[")) ) {
      $output = substr($output, 1, count($output)-2);
   }
   error_log($output);
}

/*
 * Prints the object, function and arguments that is calling tracef().
 *
 * class Foo {
 *    public function SomeFunction(){
 *       tracef();
 *    ...
 *
 * Output:
 *
 * [Mon Nov 03 17:54:51 2014] [error] [client 111.69.135.22] "Foo->SomeFunction" []
 *
 */
function tracef($depth=1){
   $trace = debug_backtrace();
   for ($i=0; $i < $depth; ++$i){
      $obj = $trace[$i+1];
      trace($obj['class'] . $obj['type']. $obj['function'], $obj['args']);
   }
}
