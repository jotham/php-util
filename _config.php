<?PHP

/*
 * Takes any number of arguments and datatypes and attempts to use JSON to render them to the error log
 */

function trace(){
   error_log(__buildStr(func_get_args()));
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
 * [Mon Nov 03 17:54:51 2014] [error] [client 127.0.0.1] "Foo->SomeFunction" []
 *
 */

function tracef($metadata=null, $depth=null){
   if ( is_null($depth) ) $depth = 1;
   $backtrace = debug_backtrace(true, $depth+1);
   for ($i=1; $i < count($backtrace); ++$i){
      $obj = $backtrace[$i];
      $args = array();
      if ( $depth > 1 && $i > 1 ) $args[] = $i;
      if ( isset($obj['class']) ) {
         $args[] = $obj['class'] . $obj['type']. $obj['function'];
      }
      $args[] = $obj['args'];
      if ( $i == 1 && !is_null($metadata) ) $args[] = $metadata;
      error_log(($i>1?' ':'').__buildStr($args));
   }
}

/*
 * Pretty print function
 */
function __buildStr($args, $depth=0, $max_depth=5){
   if ( $depth >= $max_depth ) {
      return '...'; // recursion limit
   }
   $result = array();
   foreach ($args as &$arg) {
      $result[] = json_encode($arg);
      /*$t = gettype($arg);
      switch ( $t ) {
         case 'resource': $result[] = get_resource_type($arg);
            break;
         case 'object': $result[] = (string)$arg;
            break;
         case 'array': $result[] = '[' . buildStr($arg, $depth+1, $max_depth) . ']';
            break;
         case 'NULL': $result[] = 'NULL';
            break;
         default: $result[] = json_encode($arg);
            break;
      }*/
   }
   $output = str_replace('\\', '', implode(" ", $result));
   if ( in_array(substr($output, 0, 1), array("{","[")) ) {
      $output = substr($output, 1, count($output)-2);
   }
   return $output;
}
