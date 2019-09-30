<?php
require_once '../config.php';
include 'chklogin.php';
if(isset($_REQUEST['txtName'])){
		$eroare=0;
		$u_name = addslashes($_POST['txtName']);
		$pass = addslashes($_POST['txtPwd']);
		$pass = md5($pass); 
		$sql="select adminid from tbladmin where adminemail ='".$u_name."' and password ='".$pass."' and isactive = '1'";
		$res=$db->Query($sql);
		list($a_id)=mysql_fetch_row($res);
		$rows=mysql_num_rows($res);
	if($rows>0){
		session_start();
		$_SESSION['mt'] = "success";
		$_SESSION['me'] = "Login successfully.";
		$_SESSION['adminsessionid'] = "";
		$_SESSION['adminsessionid'] = trim($a_id).";admin;".session_id();
		//echo $_SESSION['adminsessionid'];die;
		header("location:main.php");
		exit;
	}
	else{
		$eroare=1;
		$msg="Invalid Email Address / Password";
	}
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo TITLE; ?> | Log in</title>
  
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/theme.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="css/blue.css">
  <script type="text/javascript" src="js/validation.js"></script>
  <script src="js/jQuery/jquery-2.2.3.min.js"></script>
 <script src="js/bootstrap.min.js"></script>	
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
   <a href="<?php echo ADMIN_URL;?>"><img style="width:200px;" src="img/logo.png" alt=""/></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
  
	<?php if(empty($msg)){ ?>
    <p class="login-box-msg">Sign in to start your session</p>
	<?php }else{ ?>
    <p class="login-box-msg <?php echo $class;?>"><?php echo $msg;?></p>
    <?php } ?>

    <form action="" method="post" name="logFrm" onsubmit="javascript : return Clicking();">
      <div class="form-group has-feedback">
        <input type="email" tabindex="1" class="form-control" name="txtName" autofocus placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" tabindex="2"  class="form-control" name="txtPwd"  placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>  -->
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit"   class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    

    <a href="forgot.php">I forgot my password</a><br>
    

  </div>
  <!-- /.login-box-body -->
</div>



</body>
</html>
