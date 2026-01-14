<?php

abstract class Processor
{
    protected function _format_date($date)
    {
        $args = explode("-", $date);
        return $args[2] . "/" . $args[1] . "/" . $args[0];
    }

    protected function _string_contains_array_value($string, $array)
    {
        foreach ($array as $value) {
            if (str_contains(strtoupper($string), strtoupper($value))) {
                return true;
            }
        }
        return false;
    }
}
