<?php 
include("../config.php");
$uid = base64_decode('uid');
$err = '';
if(isset($_GET['uid']) && isset($_REQUEST['submit'])){
	
	$uid = explode(':',base64_decode($_GET['uid']));
	$uid = $uid[1];
	if(isset($_POST['newpassword']) && isset($_POST['confirmpw']) && $_POST['newpassword'] != '' && $_POST['newpassword'] == $_POST['confirmpw']){
		if(strlen($_POST['newpassword']) >= 6 && strlen($_POST['newpassword']) <= 20){
			$password = md5($_POST['newpassword']);
			$data = array('password'=>$password,"modified_date"=>date("Y-m-d H:i:s", time()));
			$db->Update($data,"tblcustomers"," id=".$uid);
			$err = "Your Password has been changed.";
		}else{
			$err = "Password length must be at least six characters.";
		}
		
	}else{
		$err = "Please enter valid password.";
	}
}
?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<style>
*{box-sizing: border-box;}
body{margin: 0; padding: 0; background: #efefef;}
.logo{float:left; width: 100%; text-align: center; margin: 20px 0;}
.logo img{width:200px;}
label{color:#fff;}
.txt{ background: transparent; color: #fff; border:none; margin-bottom: 10px !important; border-radius: 0; border-bottom: 1px solid #fff;}
.btn{ cursor: pointer;background: #1680c3; border: 1px solid #1680c3; text-transform: uppercase; font-weight: bold; padding: 8px 10px;}
.btn:hover{ background: transparent;}
</style>
</head>
<body>
<?php if(isset($_GET['uid'])){ ?>
<div class="logo">
	<img src="clnr-logo.png"/>
</div>
<div style="clear: both"></div>
<div style="margin:0 auto;border:1px solid #1c81c4;border-radius:4px; padding:20px; background: #fe7e13; max-width:400px;">
<p style="text-align:center;"><?php echo $err; ?></p>
<form name="checkapi" method="post" action=""  >
<label style=" width:100%; font-size:16px; margin-bottom:5px;">New Password</label>
<input class="txt" style=" width:100%; font-size:16px; margin-bottom:5px;  padding:5px 10px; color:#000;" type="password" name="newpassword" value="" maxlength="20" />
<label style=" width:100%; font-size:16px; margin-bottom:5px;">Confirm Password</label>
<input class="txt" style=" width:100%; font-size:16px; margin-bottom:5px; padding:5px 10px; color:#000;" type="password" name="confirmpw" value="" maxlength="20" />
<input class="btn" style=" width:100%;border-radius:4px; font-size:16px; margin-bottom:5px; color:#fff; text-align:center; " type="submit" name="submit" value="Reset" />

</form>
</div>
<?php } ?>
</body>
</html>