<?PHP

/*
 * Debugging helper functions
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

function tracef($depth=1){
   $trace = debug_backtrace();
   for ($i=0; $i < $depth; ++$i){
      $obj = $trace[$i+1];
      trace($obj['class'] . $obj['type']. $obj['function'], $obj['args']);
   }
}
