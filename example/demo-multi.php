<?php
session_start();
include "_netphp.php";
// print_r($_POST);
// Array ( [input1] => Jane [input2] => Smith [input3] => max base code @ g m a i l . com [yournameCode1] => 7v0c5ku1lgx6pp17bh67fdausml1lxyoih24uo46fnd4dzodqi )
if(isset($_POST["submit2"], $_POST["yournameCode1"], $_POST["anotherfield"])) {
	$token=$_POST["yournameCode1"];
	$res=post("http://localhost/matno3/SampleCaptchaAPI/src/index.php?method=done&token=".$token, [], [
		"Token: d4f5g6df4gd5f6ge4r89rf48",
		"Key: x1x1x1x1x1x1",
	]);
	$json=json_decode($res[0], true);
	if(is_array($json) and $json != null and count($json) > 0) {
		if($json["status"] == "success") {
			// write your code here
			exit("Done 2!\n");
		}
		else {
			exit("Error: captcha is not valid!");
		}
	}
	else {
		exit("Error: API have error!\n");
	}
}
if(isset($_POST["submit"], $_POST["yournameCode0"], $_POST["input1"], $_POST["input2"], $_POST["input3"])) {
	$token=$_POST["yournameCode0"];
	$res=post("http://localhost/matno3/SampleCaptchaAPI/src/index.php?method=done&token=".$token, [], [
		"Token: d4f5g6df4gd5f6ge4r89rf48",
		"Key: x1x1x1x1x1x1",
	]);
	// print_r($res);
	// print_r($res[0]);
	$json=json_decode($res[0], true);
	if(is_array($json) and $json != null and count($json) > 0) {
		if($json["status"] == "success") {
			// write your code here
			exit("Done!\n");
		}
		else {
			exit("Error: captcha is not valid!");
		}
	}
	else {
		exit("Error: API have error!\n");
	}
}
?>
<!-- <img id="image" src="captcha.php">
<button id="refresh" onclick="document.querySelector('#image').src='captcha.php';">Refresh</button>
<form action="" method="POST">
<input type="text" name="code">
<button name="submit">send</button>
</form>
 -->
<!DOCTYPE HTML>
<html dir="ltr">

<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, user-scalable=yes">
	<title>thincaptcha demo</title>
	<link rel="stylesheet" href="style.css" type="text/css">
	<script src="api.js" async defer></script>
</head>

<body>
	<div class="sample-form">
		<h2>Form 0</h2>
		<form id="thincaptcha-form0" method="POST">
			<fieldset>
				<legend>Sample Form with ThinCaptcha</legend>
				<ul>
					<li>
						<label for="input1">First Name</label>
						<input class="jfk-textinput" id="input1" name="input1" type="text" value="Jane">
					</li>
					<li>
						<label for="input2">Last Name</label>
						<input class="jfk-textinput" id="input2" name="input2" type="text" value="Smith">
					</li>
					<li>
						<label for="input3">Email</label>
						<input class="jfk-textinput" id="input3" name="input3" type="text" value="max base code @ g m a i l . com">
					</li>
					<li>
						<p>Pick your favorite color:</p>
						<label class="jfk-radiobutton-label" for="option1">
							<input class="jfk-radiobutton-checked" type="radio" id="option1" name="radios" value="option1" disabled aria-disabled="true" checked aria-checked="true">Red</label>
						<label class="jfk-radiobutton-label" for="option2">
							<input class="jfk-radiobutton" type="radio" id="option2" name="radios" value="option2" disabled aria-disabled="true">Green</label>
					</li>
					<li>
						<div id="thincaptcha-code0"></div>
					</li>
					<li>
						<input name="submit" type="submit" value="Submit">
					</li>
				</ul>
			</fieldset>
		</form>
		<h2>Form 1</h2>
		<form id="thincaptcha-form1" method="POST">
			<input type="text" name="anotherfield">
			<br>
			<div id="thincaptcha-code1"></div>
			<br>
			<button name="submit2">Send</button>
		</form>
	</div>
	<script type="text/javascript">
	window.addEventListener("load", function() {
		thinCaptcha.setLink("http://localhost/matno3/SampleCaptchaAPI/src/")
		thinCaptcha.setKey("x1x1x1x1x1x1", "d4f5g6df4gd5f6ge4r89rf48")
		thinCaptcha.apply("#thincaptcha-form0", "#thincaptcha-code0", "yournameCode0", undefined)
		thinCaptcha.apply("#thincaptcha-form1", "#thincaptcha-code1", "yournameCode1", undefined)
	})
	</script>
</body>

</html>