<?php

/*
======================
Author : Yudi Purwanto
======================
*/

define("SYSTEM_KEY", "c4dd1998706d3399758c53715meiebf5");	//unique key
define("CRYPT_HANDLER", "rc4");

function encrypt($data, $key="", $raw=false, $salt=false) {
	if (!$key) $key = SYSTEM_KEY;
	if ($salt) {
		$time_stamp = mt_rand(0,14809640);
		$str = call_user_func(CRYPT_HANDLER."_encrypt", $data, sprintf("%07d",$time_stamp).$key, $raw);
		$saltstr = sprintf("%06x", $time_stamp);
		if ($raw) $saltstr = pack("H*", $saltstr);
		$str = $saltstr.$str;
		return $str;
	}
	return call_user_func(CRYPT_HANDLER."_encrypt", $data, $key, $raw);
}

function decrypt($data, $key="", $raw=false, $salt=false) {
	if (!$key) $key = SYSTEM_KEY;
	if ($salt) {
		$saltstr = ($raw ? implode("", unpack("H*", substr($data, 0, 3))) : substr($data, 0, 6));
		$data = substr($data, ($raw ? 3 : 6));
		$time_stamp = hexdec($saltstr);
		$str = call_user_func(CRYPT_HANDLER."_decrypt", $data, sprintf("%07d",$time_stamp).$key, $raw);
		return $str;
	}
	return call_user_func(CRYPT_HANDLER."_decrypt", $data, $key, $raw);
}

function rc4_encrypt($data, $key="", $raw=false) {
	return rc4endecrypt($data, $key, $raw, false);
}

function rc4_decrypt($data, $key="", $raw=false) {
	return rc4endecrypt($data, $key, $raw, true);
}

function rc4endecrypt($data, $pwd, $raw=false, $decrypt=false) {
	if (!$raw && $decrypt) $data = pack("H*", $data);

	static $cache;
	if (!isset($cache[$pwd])) {
		$key = array();
		$box = array();

		$pwdlen = strlen($pwd);
		for ($i=0; $i<=255; $i++) {
			$key[$i] = ord(substr($pwd, ($i % $pwdlen), 1));
			$box[$i] = $i;
		}

		$x = 0;
		$temp = "";
		for ($i=0; $i<=255; $i++) {
			$x = ($x + $box[$i] + $key[$i]) % 256;
			$temp = $box[$i];
			$box[$i] = $box[$x];
			$box[$x] = $temp;
		}
		$cache[$pwd]["key"] = $key;
		$cache[$pwd]["box"] = $box;
	}
	else {
		$key = $cache[$pwd]["key"];
		$box = $cache[$pwd]["box"];
	}

	$cipher = "";
	$a = 0;
	$j = 0;
	for ($i=0; $i<strlen($data); $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;

		$temp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $temp;

		$k = $box[(($box[$a] + $box[$j]) % 256)];
		$cipherby = ord(substr($data, $i, 1)) ^ $k;
		$cipher .= chr($cipherby);
	}
	if (!$raw && !$decrypt) $cipher = substr(implode("", unpack("H*", $cipher)), 0, strlen($cipher)*2);
	return $cipher;
}