<?php  
/**
 * 打印数组
 * @param  array
 */
function dump($array = []){
	echo '<pre>';
	print_r($array);
}

/**获取无限级分类（非递归）
 * @param  [array]
 * @return [array]
 */
function getCatTree($cat = []){
	$items = [];
	foreach($cat as $k => $v)
		$items[$v['id']] = $v;
    foreach($items as $item)
        $items[$item['parent_id']]['child'][$item['id']] = &$items[$item['id']];
    return isset($items[0]['child']) ? $items[0]['child'] : [];
}


function getCatTreeOptions($array = [], $adds = '')
{
	$icon = ['&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ '];
	$nbsp = '&nbsp;&nbsp;&nbsp;';
	
	static $arr = [];
	$number = 1;
	$total = count($array);
	foreach($array as $k => $v){
		$n1 = $n2 = '';
		if($number == $total){
			$n1 = $icon[2];
		}else{
			$n1 = $icon[1];
			$n2 = $adds?$icon[0]:' ';
		}
		$add = $adds?$adds.$n1:'';
		$arr[$v['id']] = $add.$v['cat_name'];
		if(isset($v['child'])){
			getCatTreeOptions($v['child'], $adds.$n2.$nbsp);
		}
		$number++;
	}
	return $arr;
}

function getCatOptions($array = []){
    foreach($array as $k => $v){
        $space = '';
        for($i = 1; $i < $v['level']; $i++)
            $space .= '|-- ';
        $arr[$v['id']]= $space.$v['cat_name']; 
    }
    return $arr;
}

/**
 * 密码加密，解密
 * @param  [type]  $string    [需要加密的字符串]
 * @param  string  $operation [ENCODE加密、DECODE解密]
 * @param  string  $key       [description]
 * @param  integer $expiry    [description]
 * @return [string]           [description]
 */
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {   
    // 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙   
    $ckey_length = 4;   
       
    // 密匙   
    $key = md5($key ? $key : $GLOBALS['auth_key']);   
       
    // 密匙a会参与加解密   
    $keya = md5(substr($key, 0, 16));   
    // 密匙b会用来做数据完整性验证   
    $keyb = md5(substr($key, 16, 16));   
    // 密匙c用于变化生成的密文   
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): 
	substr(md5(microtime()), -$ckey_length)) : '';   
    // 参与运算的密匙   
    $cryptkey = $keya.md5($keya.$keyc);   
    $key_length = strlen($cryptkey);   
    // 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)， 
	//解密时会通过这个密匙验证数据完整性   
    // 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确   
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) :  
sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;   
    $string_length = strlen($string);   
    $result = '';   
    $box = range(0, 255);   
    $rndkey = array();   
    // 产生密匙簿   
    for($i = 0; $i <= 255; $i++) {   
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);   
    }   
    // 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度   
    for($j = $i = 0; $i < 256; $i++) {   
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;   
        $tmp = $box[$i];   
        $box[$i] = $box[$j];   
        $box[$j] = $tmp;   
    }   
    // 核心加解密部分   
    for($a = $j = $i = 0; $i < $string_length; $i++) {   
        $a = ($a + 1) % 256;   
        $j = ($j + $box[$a]) % 256;   
        $tmp = $box[$a];   
        $box[$a] = $box[$j];   
        $box[$j] = $tmp;   
        // 从密匙簿得出密匙进行异或，再转成字符   
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));   
    }   
    if($operation == 'DECODE') {  
        // 验证数据有效性，请看未加密明文的格式   
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) &&  
substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {   
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

/**
 * 获取数组第一个键值名
 * @param array $array
 * @return mixed
 */
function getArrayFirstKey($array = []){
	$keys = array_keys($array);
	return $keys[0];
}

function getArrayFirstVal($array = []){
	$values = array_values($array);
	return $values[0];
}

/**
 * 多个数组的笛卡尔积
 *
 * @param unknown_type $data
 */
function combineDika() {
	$data = func_get_args();
	$data = current($data);
	$cnt = count($data);
	$result = array();
	$arr1 = array_shift($data);
	foreach($arr1 as $key=>$item)
	{
		$result[] = array($item);
	}

	foreach($data as $key=>$item)
	{
		$result = combineArray($result,$item);
	}
	return $result;
}


/**
 * 两个数组的笛卡尔积
 * @param unknown_type $arr1
 * @param unknown_type $arr2
 */
function combineArray($arr1,$arr2) {
	$result = array();
	foreach ($arr1 as $item1)
	{
		foreach ($arr2 as $item2)
		{
			$temp = $item1;
			$temp[] = $item2;
			$result[] = $temp;
		}
	}
	return $result;
}

/**
 * 把二维数组中元素的键名设为数组的键名
 */
function setArrayKeyWithColumKey($array, $colum = 'id')
{
	$result = [];
	foreach($array as $K => $v)
		$result[$v[$colum]] = $v;
	return $result;
}

/**
 * 把二维数组中元素的键值设为数组的键名
 */
function setArrayKeyWithColumVal($array)
{
	$result = [];
	foreach($array as $K => $v)
		$result[$v] = $v;
	return $result;
}

/**
 * 通过指定键值分组
 * @param unknown $array
 * @param unknown $key
 * @return unknown
 */
function groupArrayByKey($array,$key)
{
	$arr = [];
	foreach($array as $k => $v){
		$arr[$v[$key]][] = $v;
	}
	
	return $arr;
}

function createArrayForDropDownList($array, $key = 'id', $val = 'name')
{
	$arr = [];
	foreach($array as $k => $v){
		$arr[$v[$key]] = $v[$val];
	}
	return $arr;
}

function createOptionsForDropDownList($array)
{
	$str = '';
	foreach($array as $k => $v)
	{
		$str .= '<option value='.$v['id'].'>'.$v['name'].'</option>';
	}
	return $str;
}

/**
 * 用于生成多语言链接
 * @param type $lang
 * @return string
 */
function langurl($lang = 'zh-CN')
{
	if(isset($_SESSION['lang']) && $_SESSION['lang'] == $lang){
		return null;
	}
	$current_uri = $_SERVER['REQUEST_URI'];
	if (strrpos($current_uri, 'lang=')) {
		//防止生成的 url 传值出现重复
		$langstr = 'lang=' . $_SESSION['lang'];
		$current_uri = str_replace('?' . $langstr . '&', '?', $current_uri);
		$current_uri = str_replace('?' . $langstr, '', $current_uri);
		$current_uri = str_replace('&' . $langstr, '', $current_uri);
	}
	if (strrpos($current_uri, '?')) {
		return $current_uri . '&lang=' . $lang;
	} else {
		return $current_uri . '?lang=' . $lang;
	}
}