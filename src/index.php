<?php
define("BASE", __DIR__ . "/");
require_once "_core.php";

if(!function_exists("getallheaders")) {
	// Probably you are in CLI and it's not usefull!
	// But sometimes it's usefull for some webserver!
	function getallheaders() {
		$headers = [];
		foreach($_SERVER as $name => $value) {
			if(substr($name, 0, 5) == "HTTP_") {
				$headers[str_replace(" ", "-", ucwords(strtolower(str_replace("_", " ", substr($name, 5)))))] = $value;
			}
		}
		return $headers;
	}
}

$headers=getallheaders();
if($headers != null && is_array($headers) and count($headers) > 0) {
	if(isset($headers["Token"], $headers["Key"])) {
		$token=$headers["Token"];
		$key=$headers["Key"];
		$app=$db->select("app", ["token"=>$token, "publicKey"=>$key]);
		// print_r($app);
		if($app == null) {
			display(["status"=>"failed", "message"=>"This token and key is not valid!"]);
		}
		else {
			$data=$_GET;
			foreach($_POST as $key=>$value) {
				$data[$key]=$value;
			}
			// print_r($data);
			// print_r($_POST);
			if(isset($data["method"])) {
				$method=$data["method"];
				if($method == "create") {
					$token=string("abcdefghijklmnopqrstuvwxyz0123456789", 50);
					$code=string("abcdefghijklmnopqrstuvwxyz0123456789", 50);
					$captchaID=$db->insert("captcha", [
						"code"=>string("0123456789", 4),
						"userAgent"=>getUserAgent(),
						"ip"=>getIpAddr(),
						"referer"=>isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null,
						"token"=>$token,
						"codes"=>$code,
						"hasUse"=>0,
					]);
					display(["status"=>"success", "message"=>"", "result"=>[
						"code"=>$code,
					]], $app);
				}
				else if($method == "done") {
					if(isset($data["token"])) {
						$token=$data["token"];
						if($db->count("captcha", ["token"=>$token]) == 0) {
							display(["status"=>"failed", "message"=>"Your session is not valid!"], $app);
						}
						$clauses=["token"=>$token];
						$captcha=$db->select("captcha", $clauses);
						if($captcha["hasUse"] == -1) {
							display(["status"=>"failed", "message"=>"This captcha is canceled!"], $app);
						}
						else if($captcha["hasUse"] == 0) {
							$db->update("captcha", $clauses, ["hasUse"=>1]);
							display(["status"=>"success", "message"=>"Enjoy from it, Done!"], $app);
						}
						else {
							display(["status"=>"failed", "message"=>"Your session is not good!"], $app);
						}
					}
				}
				else if($method == "verify") {
					if(isset($data["code"], $data["value"])) {
						$value=$data["value"];
						$code=$data["code"];
						if($db->count("captcha", ["codes"=>$code]) == 0) {
							display(["status"=>"failed", "message"=>"Your session is not valid***!"], $app);
						}
						$captcha=$db->select("captcha", ["codes"=>$code]);
						if($captcha["code"] == $value) {
							display(["status"=>"success", "message"=>"You are wellcome!", "result"=>[
								"token"=>$captcha["token"],
							]], $app);
						}
						else {
							display(["status"=>"failed", "message"=>"Your session is not good!"], $app);
							$db->update("captcha", $clauses, ["hasUse"=>-1]);
						}
						print_r($captcha);
					}
					else {
						display(["status"=>"failed", "message"=>"Cannot verify this without a valid session!"], $app);
					}
				}
				else {
					display(["status"=>"failed", "message"=>"Method is not valid!"], $app);
				}
			}
			else {
				display(["status"=>"failed", "message"=>"Every request in this webservice need a method type!"], $app);
			}
		}
	}
	else {
		print_r($headers);
		display(["status"=>"failed", "message"=>"You did not have access to this webservice without token and key!"]);
	}
}
else {
	display(["status"=>"failed", "message"=>"You did not have access to this webservice!"]);
}
