<?php
defined('WPSS_URL') or die('Restricted access');



/**
 *  Filter CSV output for commas, html and bad chars
 */
function _wpss_filter(&$str){
  $str = strip_tags($str);
  $str = str_replace(',','',$str);
  return $str;
} 


?>
