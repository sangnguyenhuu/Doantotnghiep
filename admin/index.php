<?php 
	require('inc/db_config.php');
	require('inc/essentials.php');
	session_start();
        if((isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true))
        {
            redirect('dashboard.php');
        }
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="with=device-with, initial-scale=1.0">
	<title>Admin Login Panel</title>
	<?php require('inc/links.php') ?>
	<style>
		div.login-form{
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%,-50%);
			width: 400px;
		}
	</style>
</head>
<body class="bg-light">

	<div class="login-form text-center rounded bg-white shadow overflow-none">
		
		<form method="POST">
		<h4 class="bg-dark text-white py-3">Đăng nhập quản trị viên</h4>	
		<div class="p-4">
			<div class="mb-3">
    			<input name="admin_name" required type="text" class="form-control shadow-none text-center" placeholder="Tài khoản ">
  			  </div>
  			<div class="mb-4">
    			<input name="admin_pass" required type="password" class="form-control shadow-none text-center" placeholder="Mật khẩu">
  			</div>
  			<button name="login" type="submit" class="btn text-white bg-dark custom-bg shadow-none">Đăng nhập</button>
 
		</div>
	</form>
</div>

<?php 
	if (isset($_POST['login'])) 
	{
		//print_r($_POST);
	 $frm_data = filteration($_POST);
	 
	 $query = "SELECT * FROM `admin_cred` WHERE `admin_name`=? AND `admin_pass` = ?";
	 $values = [$frm_data['admin_name'],$frm_data['admin_pass']];
	 //$datatypes = "ss";

	$res =  select($query,$values,"ss");
	//print_r($res);
	if($res->num_rows == 1){
		$row = mysqli_fetch_assoc($res);
		
		$_SESSION['adminLogin'] = true;
		$_SESSION['adminId'] = $row['sr_no'];
		redirect('dashboard.php');
		//echo "<script> window.location.href = 'dashboard.php'</script>";
		
	}else{
		alert('error','Đăng nhập không thành công - Thông tin đăng nhập không chính xác!');
	}
}

 ?>

<?php require('inc/scripts.php') ?>
</body>
</html> 