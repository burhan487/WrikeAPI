<?php
ob_start();
ini_set('safe_mode', false);
/*$secret = "25b038ad8fb14c7dac54418e557999e1";
$consumer = "0d754a2abd3396c5";*/

/*$secret = "0d754a2abd3396c5";
$consumer = "25b038ad8fb14c7dac54418e557999e1";*/


$secret = "939b11547f1e2010";
$consumer = "1781e8166fb9f51ab7e9666d193d25c3";

function urlencode_rfc3986($string) {
	 return str_replace("%7E", "~", rawurlencode($string));
}

function getRequestToken() {
	global $consumer;
	
	$url = "https://www.wrike.com/rest/auth/request_token"; 
	$params = array(
		"oauth_callback" => '',
		"oauth_consumer_key" => $consumer,
		"oauth_nonce" => md5(microtime() . mt_rand()),
		"oauth_signature_method" => "HMAC-SHA1",
		"oauth_timestamp" => time(),
		"oauth_version" => "1.0"
	);
	$result = makeAPICall($url, $params);

	list($headers, $body) = explode("\r\n\r\n", $result, 2);
	list($token, $token_secret) = explode("&", $body);
	list($label, $token) = explode("=", $token);
	list($label, $token_secret) = explode("=", $token_secret);

	// redirect to auth page
	
	//$callback_url = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["REQUEST_URI"]) ."/wriketest5/" . "/index.php?oauth_token_secret=" . $token_secret;
	$callback_url = "http://" . $_SERVER["HTTP_HOST"] ."/"."index.php?oauth_token_secret=" . $token_secret;
	
	
	
	header("Location: https://www.wrike.com/rest/auth/authorize?oauth_token=" . $token . "&oauth_callback=" . urlencode_rfc3986($callback_url));
}

function getAccessToken($token, $secret) {
	global $consumer;
	
	$url = "https://www.wrike.com/rest/auth/access_token";
	$params = array(
		"oauth_consumer_key" => $consumer,
		"oauth_nonce" => md5(microtime() . mt_rand()),
		"oauth_signature_method" => "HMAC-SHA1",
		"oauth_timestamp" => time(),
		"oauth_token" => $token,
		"oauth_version" => "1.0"
	);
	$result = makeAPICall($url, $params, $secret);

	list($headers, $body) = explode("\r\n\r\n", $result, 2);
	
	list($access_token, $access_token_secret) = explode("&", $body);
	list($label, $access_token) = explode("=", $access_token);
	list($label, $access_token_secret) = explode("=", $access_token_secret);
	//$_url = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["REQUEST_URI"]) . "/index.php?access_token=" . $access_token . "&access_token_secret=" . $access_token_secret;
	$_url = "http://" . $_SERVER["HTTP_HOST"] ."/". "index.php?access_token=" . $access_token . "&access_token_secret=" . $access_token_secret;
	header("Location: " . $_url);
}

function getProfile($token, $secret) {
	global $consumer;
	
	$url = "https://www.wrike.com/api/json/v2/wrike.profile.get";
	$params = array(
		"oauth_consumer_key" => $consumer,
		"oauth_nonce" => md5(microtime() . mt_rand()),
		"oauth_signature_method" => "HMAC-SHA1",
		"oauth_timestamp" => time(),
		"oauth_token" => $token,
		"oauth_version" => "1.0"
	);
	$result = makeAPICall($url, $params, $secret, "POST");

	list($headers, $body) = explode("\r\n\r\n", $result, 2);
	
	return $body;
}
function getFolders($token, $secret) {
	global $consumer;
	$url = "https://www.wrike.com/api/json/v2/wrike.folder.tree";
	$params = array(
		"oauth_consumer_key" => $consumer,
		"oauth_nonce" => md5(microtime() . mt_rand()),
		"oauth_signature_method" => "HMAC-SHA1",
		"oauth_timestamp" => time(),
		"oauth_token" => $token,
		"oauth_version" => "1.0"
		);
	/*ksort($params);*/
	$result = makeAPICall($url, $params, $secret, "POST");
	list($headers, $body) = explode("\r\n\r\n", $result, 2);
    //$body = json_decode($result);
	//$body = $result;
	return $body;
}

function getTasks($token, $secret,$folderid) {
	global $consumer;
	
	$url = "https://www.wrike.com/api/json/v2/wrike.task.get";
	$params = array(
		"oauth_consumer_key" => $consumer,
		"oauth_nonce" => md5(microtime() . mt_rand()),
		"oauth_signature_method" => "HMAC-SHA1",
		"oauth_timestamp" => time(),
		"oauth_token" => $token,
		"oauth_version" => "1.0",
		"id" => $folderid
	);
	ksort($params);
	$result = makeAPICall($url, $params, $secret, "POST");

	list($headers, $body) = explode("\r\n\r\n", $result, 2);
	
	return $body;
}


function getFilterTasks($token, $secret, $filter) {
	global $consumer;
	
	$url = "https://www.wrike.com/api/json/v2/wrike.task.filter";
	$params = array(
		"oauth_consumer_key" => $consumer,
		"oauth_nonce" => md5(microtime() . mt_rand()),
		"oauth_signature_method" => "HMAC-SHA1",
		"oauth_timestamp" => time(),
		"oauth_token" => $token,
		"oauth_version" => "1.0",
		);
/*	$params['fromStartDate'] = '2012-10-22';
	$params['toStartDate'] = '2012-10-26';*/
	//$params['statuses'] = '1';
	
	$params['parents'] = $filter;
	
	
    //$body = json_decode($result);
	//$body = $result;
/*	return $body;*/
	
	$params['fields'] = 'id,title,responsibleUsers,duration,startDate,dueDate,status';
	ksort($params);
	$result = makeAPICall($url, $params, $secret, "POST");
/*	$body = json_decode($result);*/
	list($headers, $body) = explode("\r\n\r\n", $result, 2);
	return $body;
}

/*getting users information regarding tasks*/
function getfullnameContacts($token, $secret,$uid) {
	global $consumer;
	
	$url = "https://www.wrike.com/api/json/v2/wrike.contacts.list";
	$params = array(
		"oauth_consumer_key" => $consumer,
		"oauth_nonce" => md5(microtime() . mt_rand()),
		"oauth_signature_method" => "HMAC-SHA1",
		"oauth_timestamp" => time(),
		"oauth_token" => $token,
		"oauth_version" => "1.0"
		);
	$params['uid'] = $uid;
	ksort($params);
	$result = makeAPICall($url, $params, $secret, "POST");
	//$body = json_decode($result);
	list($headers, $body) = explode("\r\n\r\n", $result, 2);

	return $body;
}


/*getting sub folders and its tasks*/

function getsubFolders($token, $secret,$parentid) {
	global $consumer;
	$url = "https://www.wrike.com/api/json/v2/wrike.folder.tree";
	$params = array(
		"oauth_consumer_key" => $consumer,
		"oauth_nonce" => md5(microtime() . mt_rand()),
		"oauth_signature_method" => "HMAC-SHA1",
		"oauth_timestamp" => time(),
		"oauth_token" => $token,
		"oauth_version" => "1.0",
		);
    $params['parentId'] = $parentid;
	$result = makeAPICall($url, $params, $secret, "POST");
	list($headers, $body) = explode("\r\n\r\n", $result, 2);
	return $body;
}
function makeAPICall($url, $authParams, $token_secret = "", $method = "GET") {
	global $secret;
	
	$query_string = "";
	foreach($authParams as $key => $value) {
		$query_string .= $key . "=" . urlencode_rfc3986($value) . "&";
	}
	$query_string = rtrim($query_string, "&");
	$key_parts = array(
		urlencode_rfc3986($secret), 
		$token_secret != ""? urlencode_rfc3986($token_secret): ""
	);
	$params = array(
		$method, 
		urlencode_rfc3986($url), 
		urlencode_rfc3986($query_string)
	);
	$base_string = implode("&", $params);
	$signature = base64_encode(hash_hmac("sha1", $base_string, implode("&", $key_parts), true));
	
	$authParams["oauth_signature"] = $signature;
	
	$query_string = "";
	foreach($authParams as $key => $value) {
		$query_string .= $key . "=" . urlencode_rfc3986($value) . "&";
	}
	$query_string = rtrim($query_string, "&");
	
	//echo $query_string;
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
	
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt( $ch, CURLOPT_HEADER, true);
	if ($method == "GET") {
		curl_setopt($ch, CURLOPT_URL, $url . "?" . $query_string);
	}
	else {
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
	}
	$result = curl_exec($ch);
	curl_close($ch);
	
	return $result;
}





?>