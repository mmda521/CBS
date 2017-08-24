<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! function_exists('encodeID'))
{
	/**
	 * guid生成辅助方法
	 *
	 * 
	 * 
	 *
	 * 
	 * 
	 * 
	 * 
	 */
	function guid_create(){
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtolower(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = //chr(123) // "{"
                substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12);
                //.chr(125); // "}"
        return $uuid;
    
    }


}
// ------------------------------------------------------------------------


