<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('convertToTime'))
{
    function convertToTime($mins = 0)
    {
        $hh = floor($mins/60);
		$mm = $mins - ($hh*60);
		$time_arr = array('hh'=> sprintf("%02d", $hh),'mm'=> sprintf("%02d", $mm));
		return $time_arr;
    }   
}