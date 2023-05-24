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

if (!function_exists('Centify')) {

    function Centify($value)
    {

        if (is_null($value)) {
            return null;
        }

        // strip the spaces
        $value = str_replace(' ', '', $value);

        // if there is no comma or dot in the value, add a dot and two zeros
        if (strpos($value, ',') === false and strpos($value, '.') === false) {
            $value .= ',00';
        }

        // now remove all non numeric characters, except the minus sign
        $value = preg_replace('/[^0-9\-]/', '', $value);
        //$value = preg_replace('/[^0-9]/', '', $value);

        return $value;
    }

}
