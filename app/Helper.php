<?php
/**
* change plain number to formatted currency
*
* @param $number
* @param $currency
*/
function dateformat($date)
{
    return date('d M , Y',strtotime($date));
}