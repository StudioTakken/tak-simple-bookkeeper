<?php


/**
 *
 * ddl staat voor devdiv log, handig voor ontwikkelaar.
 * 
 * gebruik require_once 'ddl.php';
 * in hoofdscript.
 * 
 */
if (!function_exists('ddl')) {

    function ddl($data)
    {

        $bt     = debug_backtrace();
        $caller = array_shift($bt);

        if (is_array($data) or is_object($data)) {
            $retval = print_r($data, true);
        } else {
            $retval = $data;
        }
        $retval = $caller['file'] . ':' . $caller['line'] . "\n" . $retval . "\n";
        error_log($retval);
    }
}
