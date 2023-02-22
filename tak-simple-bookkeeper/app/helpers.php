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


function Centify($value)
{

    // strip the currency symbol
    $value = str_replace('€', '', $value);

    // strip the spaces
    $value = str_replace(' ', '', $value);

    // check if the value is a valid dutch format

    if (preg_match('/^\d{1,3}(\.\d{3})*,\d{2}$/', $value)) {
        // make it a european format, with a dot as decimal separator and no thousands separator
        $value = str_replace('.', '', $value); // remove the thousands separators
        $value = str_replace(',', '.', $value); // replace the decimal separator comma with a dot
    }
    // remove the thousands separators if they are there
    $value = str_replace(',', '', $value); // replace the decimal separator comma with a dot


    // make it a amount in cents
    $value = (int)round($value * 100);

    // $this->attributes['amount'] = $value;

    return $value;
}
