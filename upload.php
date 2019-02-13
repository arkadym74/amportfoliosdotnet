<?php
if($_FILES["zip_file"]["name"]) {
	$filename = $_FILES["zip_file"]["name"];
	$source = $_FILES["zip_file"]["tmp_name"];
	$type = $_FILES["zip_file"]["type"];
	
	$name = explode(".", $filename);
	$accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
	foreach($accepted_types as $mime_type) {
		if($mime_type == $type) {
			$okay = true;
			break;
		} 
	}
	
	$continue = strtolower($name[1]) == 'zip' ? true : false;
	if(!$continue) {
		$message = "The file you are trying to upload is not a .zip file. Please try again.";
	}

	$target_path = "/home3/amportfo/public_html/amport_home/upload".$filename;  // change this to the correct site path
	if(move_uploaded_file($source, $target_path)) {
		$zip = new ZipArchive();
		$x = $zip->open($target_path);
		if ($x === true) {
			$zip->extractTo("/home3/amportfo/public_html/amport_home/upload"); // change this to the correct site path
			$zip->close();
	
			unlink($target_path);
		}
		$message = "Your .zip file was uploaded and unpacked.";
	} else {	
		$message = "There was a problem with the upload. Please try again.";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="css/responsive_large_display_userp.css" media="screen and (max-width: 2560px)">
	<link rel="stylesheet" type="text/css" href="css/responsive_userp.css" media="screen and (max-width: 768px)"> 
<title>Project Upload</title>
<style>
.button {
font-family: Verdana; 
color: green; 
font-weight: bold; 
background-color: white;"
height: 200px;
width: 200px;
margin: 20px;
padding: 15px;
border: 1px solid green;
display: inline-block;
font-size: 18px;
cursor: pointer;
-webkit-transition-duration: 0.4s; /*Safari*/
transition-duration: 0.4s;
}

.button:hover {
background-color: Cyan;
box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24),0 17px 50px 0 rgba(0,0,0,0.19);
}

.buttonback {
font-family: Courier; 
color: purple; 
font-weight: bold; 
background-color: white;"
height: 200px;
width: 200px;
margin: 20px;
padding: 15px;
border: 1px solid purple;
display: inline-block;
font-size: 18px;
cursor: pointer;
-webkit-transition-duration: 0.4s; /*Safari*/
transition-duration: 0.4s;
}

.buttonback:hover {
background-color: green;
box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24),0 17px 50px 0 rgba(0,0,0,0.19);
}
</style>
</head>
<body style="background-size: cover; width: 100%" background="images/upload.jpg">
<?php if($message) echo "<p>$message</p>"; ?>
<form enctype="multipart/form-data" method="post" action="">
<label style="font-family: Courier; font-size: 18px; font-weight: bold; font; color: green;"">Choose a zip file to upload: <input type="file" name="zip_file" /></label>
<br />
<input class="button" type="submit" name="submit" value="Upload" />
<br>
<input class="buttonback" type="button" value="User Portfolios" onclick="window.location.href='userportfolio.html'" />
</form>
</body>
</html>