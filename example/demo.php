<?php
session_start();
if(isset($_POST["submit"])) {
	print $_SESSION["captcha"]."<br>";
	print $_POST["code"]."<br>";
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
		<form id="thincaptcha-form1" method="POST">
			<fieldset>
				<legend>Sample Form with ThinCaptcha</legend>
				<ul>
					<li>
						<label for="input1">First Name</label>
						<input class="jfk-textinput" id="input1" name="input1" type="text" value="Jane" disabled aria-disabled="true">
					</li>
					<li>
						<label for="input2">Last Name</label>
						<input class="jfk-textinput" id="input2" name="input2" type="text" value="Smith" disabled aria-disabled="true">
					</li>
					<li>
						<label for="input3">Email</label>
						<input class="jfk-textinput" id="input3" name="input3" type="text" value="max base code @ g m a i l . com" disabled aria-disabled="true">
					</li>
					<li>
						<p>Pick your favorite color:</p>
						<label class="jfk-radiobutton-label" for="option1">
							<input class="jfk-radiobutton-checked" type="radio" id="option1" name="radios" value="option1" disabled aria-disabled="true" checked aria-checked="true">Red</label>
						<label class="jfk-radiobutton-label" for="option2">
							<input class="jfk-radiobutton" type="radio" id="option2" name="radios" value="option2" disabled aria-disabled="true">Green</label>
					</li>
					<li>
						<div id="thincaptcha-code1"></div>
					</li>
					<li>
						<input type="submit" value="Submit">
					</li>
				</ul>
			</fieldset>
		</form>
	</div>
	<script type="text/javascript">
	window.addEventListener("load", function() {
		thinCaptcha.setLink("http://localhost/matno3/SampleCaptchaAPI/src/")
		thinCaptcha.setKey("x1x1x1x1x1x1", "d4f5g6df4gd5f6ge4r89rf48")
		thinCaptcha.apply("#thincaptcha-form1", "#thincaptcha-code1");
	})
	</script>
</body>

</html>