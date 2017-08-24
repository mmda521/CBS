<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * 后台常见的方法
 * author 王建
 * time 2014_01_20
 * 
 */


if( !function_exists("result_to_towf_new") ){
	
 function result_to_towf_new($vDataResult, $ret,$errmsg,$sigInfo){
	$result_arr = array();
	$result_arr["resultcode"] = (string)$ret;
	$tmp_arr["errmsg"] = $errmsg;
	$tmp_arr["obj"] = $sigInfo;
	$vResult = array();
	$tmp_arr["list"] = $vDataResult;
	$result_arr["resultinfo"] =  $tmp_arr;

	return json_encode($result_arr);
}

}


if( !function_exists("result_to_towf_new2") ){
	
 function result_to_towf_new2($vDataResult, $ret,$errmsg,$sigInfo , $response){
	$result_arr = array();
	$result_arr["resultcode"] = (string)$ret;
	$tmp_arr["errmsg"] = $errmsg;
	$tmp_arr["obj"] = $sigInfo;
	$vResult = array();
	$tmp_arr["list"] = $vDataResult;
	$result_arr["resultinfo"] =  $tmp_arr;
	$result_arr["response"] = $response;
	//PC::debug($result_arr);
	return json_encode($result_arr);
}

}

//获取客户端的IP地址
if( ! function_exists("get_client_ip")){
	function get_client_ip(){
		if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")){
			$ip = getenv("HTTP_CLIENT_IP");
		}else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")){
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		}else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
			$ip = getenv("REMOTE_ADDR");
		else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
			$ip = $_SERVER['REMOTE_ADDR'];
		else
			$ip = "unknown";
		return($ip);
	}
}
//数组转换为一维数组
if( ! function_exists("arrayChange")){
	
	function arrayChange($str){
		static $arr2;
		foreach($str as $v){
			if(is_array($v)){
				$this->arrayChange($v);
			}else{
				$arr2[]=$v;
			}
		}
		return $arr2;
	}
}

/**
 
 * 处理form 提交的参数过滤
 * $string	string  需要处理的字符串或者数组
 * $force	boolean  强制进行处理
 * @return	string 返回处理之后的字符串或者数组
 */
if(!function_exists("daddslashes")){
	function daddslashes($string, $force = 1) {
		if(is_array($string)) {
			$keys = array_keys($string);
			foreach($keys as $key) {
				$val = $string[$key];
				unset($string[$key]);
				$string[addslashes($key)] = daddslashes($val, $force);
			}
		} else {
			$string = addslashes($string);
		}
		return $string;
	}
}
/**
 
 * 处理form 提交的参数过滤
 * $string	string  需要处理的字符串
 * @return	string 返回处理之后的字符串或者数组
 */
if(!function_exists("dowith_sql")){	
	function dowith_sql($str)
	{
	   $str = str_replace("and","",$str);
	   $str = str_replace("execute","",$str);
	   $str = str_replace("update","",$str);
	   $str = str_replace("count","",$str);
	   $str = str_replace("chr","",$str);
	   $str = str_replace("mid","",$str);
	   $str = str_replace("master","",$str);
	   $str = str_replace("truncate","",$str);
	   $str = str_replace("char","",$str);
	   $str = str_replace("declare","",$str);
	   $str = str_replace("select","",$str);
	   $str = str_replace("create","",$str);
	   $str = str_replace("delete","",$str);
	   $str = str_replace("insert","",$str);
	  // $str = str_replace("'","",$str);
	  // $str = str_replace('"',"",$str);
	  // $str = str_replace(" ","",$str);
	   $str = str_replace("or","",$str);
	   $str = str_replace("=","",$str);
	   $str = str_replace("%20","",$str);
	   //echo $str;
	   return $str;
	}	
}
/*
32	函数名称：verify_id()
33	函数作用：校验提交的ID类值是否合法
34	参　　数：$id: 提交的ID值
35	返 回 值：返回处理后的ID
36	
*/
if( !function_exists("verify_id") ){
	function verify_id($id=null) {
		if (!$id) { 
			return 0;
		} // 是否为空判断
		elseif (inject_check($id)) { 
			return 0;
		} // 注射判断
		elseif (!is_numeric($id)) { 
			return 0 ;			
		} // 数字判断
		$id = intval($id); // 整型化		 
		return $id;
	}
}

/*
 *检测提交的值是不是含有SQL注射的字符，防止注射，保护服务器安全
 *参　　数：$sql_str: 提交的变量
 *返 回 值：返回检测结果，ture or false 
 */

if( !function_exists("inject_check") ){
	function inject_check($sql_str) {
		return @eregi('select|insert|and|or|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile', $sql_str); // 进行过滤
	}
}

/**
 *  处理禁用HTML但允许换行的内容
 *
 * @access    public
 * @param     string  $msg  需要过滤的内容
 * @return    string
 */
if ( ! function_exists('TrimMsg'))
{
    function TrimMsg($msg)
    {
        $msg = trim(stripslashes($msg));
        $msg = nl2br(htmlspecialchars($msg));
        $msg = str_replace("  ","&nbsp;&nbsp;",$msg);
        return addslashes($msg);
    }
}




/**
 * PHP判断字符串纯汉字 OR 纯英文 OR 汉英混合
 * return 1: 英文
 * return 2：纯汉字
 * return 3：汉字和英文
 */

function utf8_str($str){
    $mb = mb_strlen($str,'utf-8');
    $st = strlen($str);
    if($st==$mb)
        return 1;
    if($st%$mb==0 && $st%3==0)
        return 2;
    return 3;
}	

/**
 +----------------------------------------------------------
 * 字符串截取，支持中文和其他编码
 +----------------------------------------------------------
 * @static
 * @access public
 +----------------------------------------------------------
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @param string $strength 字符串的长度
 +----------------------------------------------------------
 * @return string
 +----------------------------------------------------------
 */
function msubstr($str, $start=0, $length, $strength,$charset="utf-8", $suffix=true)
{
    if(function_exists("mb_substr")){
    	if($suffix){
    		if($length <$strength ){
    			return mb_substr($str, $start, $length, $charset)."....";
    		}else{
    			return mb_substr($str, $start, $length, $charset);
    		}   		
    	}else{
    		return mb_substr($str, $start, $length, $charset);
    	}

    	
    }elseif(function_exists('iconv_substr')) {
    	if($suffix){//是否加上......符号
    		if($length < $strength){
    			return iconv_substr($str,$start,$length,$charset)."....";
    		}else{
    			return iconv_substr($str,$start,$length,$charset) ;
    		}  		
    	}else{
    		return iconv_substr($str,$start,$length,$charset) ;
    	}

       
    }
    $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
    $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
    $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
    $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
    preg_match_all($re[$charset], $str, $match);
    $slice = join("",array_slice($match[0], $start, $length));
    if($suffix){
    	return $slice."…";
    } else{
    	return $slice;
    }
   
}


/**
 +----------------------------------------------------------
 * 字符串截取，支持中文和其他编码
 +----------------------------------------------------------
 * @static
 * @access public
 +----------------------------------------------------------
 * @param string $str 需要计算的字符串
 * @param string $charset 字符编码
 +----------------------------------------------------------
 * @return length int
 +----------------------------------------------------------
 */

function abslength($str,$charset= 'utf-8'){
    if(empty($str)){
        return 0;
    }
    if(function_exists('mb_strlen')){
        return mb_strlen($str,'utf-8');
    }
    else {
        @preg_match_all("/./u", $str, $ar);
        return count($ar[0]);
    }
}





/*
 *return table 前缀 
 * 
 */
/*if(!function_exists("table_pre")){
	function table_pre($group){
		$table_pre = '' ;
		if($group){
			$ci = &get_instance(); //初始化 为了用方法
			$d = $ci->load->database($group,true);
			
			$table_pre =  $d->table_pre;
		}
		return $table_pre ;
		
	}
}*/

if(!function_exists("table_pre")){
	function table_pre($group = '' ){
		$table_pre = '' ;
		if($group){
			if(file_exists(__ROOT__."/config/config.inc.php")){
				include __ROOT__."/config/config.inc.php" ;
				if(isset($db[$group]) && $db[$group]){
					if(isset($db[$group]['table_pre']) && $db[$group]['table_pre']){
						$table_pre = $db[$group]['table_pre'] ; 
					}elseif(isset($db[$group]['dbprefix']) && $db[$group]['dbprefix']){
						$table_pre = $db[$group]['dbprefix'] ; 
					}
					
				}
			}
		}
		return $table_pre ;		
	}
}
/**  摘自 discuz
	 * $string 明文或密文
	 * $operation 加密ENCODE或解密DECODE
	 * $key 密钥
	 * $expiry 密钥有效期 ， 默认是一直有效
*/ 
if(!function_exists("auth_code")){
	function auth_code($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	/*
		动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙
		加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
		取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
		当此值为 0 时，则不产生随机密钥
	*/
	$ckey_length = 4;
	$key = md5($key != '' ? $key : "fdsfdf43535svxfsdfdsfs"); // 此处的key可以自己进行定义，写到配置文件也可以
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);
	// 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，解密时会通过这个密匙验证数据完整性
    // 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确
	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		// 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因
		// 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}	
}
if(!function_exists("genTree9")){
    function genTree9($items,$id = 'id' ,$pid = 'pid' ,$child = 'children' ) {
        $tree = array(); //格式化好的树
        foreach ($items as $item)
		{
            if (isset($items[$item[$pid]]))

			{$items[$item[$pid]][$child][] = &$items[$item[$id]];} 
            else
			{ $tree[] = &$items[$item[$id]];}  
		//file_put_contents("D:\abc.txt",var_export($item,true)."\r\n",FILE_APPEND);
		}	
		
        return $tree;

    }
}


?>