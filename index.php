<!DOCTYPE html>
<?php
	// menghubungkan dengan koneksi
	include "function.php";
	//memulai session yang disimpan pada browser
	session_start();
	ob_start();
  
?>
<html lang="en">
<head>
	<title>Masuk || Rumah Makan Melda</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="template\masuk\images\logo.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="template/masuk/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="template/masuk/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--=====================================================================================================================================================================-->
	<link rel="stylesheet" type="text/css" href="template/masuk/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="template/masuk/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="template/masuk/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="template/masuk/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="template/masuk/css/util.css">
	<link rel="stylesheet" type="text/css" href="template/masuk/css/main.css">
	<link rel="stylesheet" type="text/css" href="template/masuk/css/style.css">

<!--===============================================================================================-->
</head>
<body>
	<div class="limiter">
		<div class="container-login100" style="background-image: url('template/masuk/images/img-01.jpg');">
			<div class="wrap-login100 p-t-120 p-b-30">
					<?php 
						if(isset($_SESSION['eror'])){
					?>
						<div class='container'>	
							<div class = 'alert alert-danger'>
								<span>
									<center>Akun Anda Salah Atau Belum Divalidasi</center>
								</span>
							</div> 
						</div>
					<?php 
						unset($_SESSION['eror']);
						}
					?>
<!--=========================================================LOGO===============================================================-->
					<div class="login100-form-avatar">
						<img src="template/masuk/images/logo.png" alt="">
					</div>
						<span class="login100-form-title p-t-20 p-b-45">
						RUMAH MAKAN MELDA 8
					</span>
<!--=========================================================USERNAME INPUT===============================================================-->
				<form action="" method="post" class="login100-form validate-form">
					<div class="wrap-input100 validate-  m-b-10" data-validate = "Username is required">
						<input class="input100" type="text" name="username" placeholder="Username">
						<span class="focus-input100"></span>
						<span class="symbol-input100"><i class="fa fa-user"></i></span>
					</div>
<!--=========================================================PASSWORD INPUT===============================================================-->
					<div class="wrap-input100 validate-input m-b-10" data-validate = "Password is required">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100"><i class="fa fa-lock"></i></span>
					</div>
<!--=========================================================REMEMBER ME===============================================================-->
					<div >
						<label for="remember"><input class="remember" type="checkbox" name="remember" value="true">Remember Me</label>
					</div>
<!--=========================================================LOGIN BUTTON===============================================================-->
					<div class="container-login100-form-btn p-t-10">
						<button type="submit" name="login" class="login100-form-btn">
							Login
						</button>
					</div>
<!--=========================================================SYSTEM LOGIN===============================================================-->
	<?php
		if(isset ($_REQUEST['login'])){
			//Pemanggilan Function Login
			$login = login();
		}
		
		if(isset($_COOKIE['id'])&& isset($_COOKIE['key'])){
			$id = $_COOKIE['id'];
			$key = $_COOKIE['key'];
	
			//ambil username
			$akun = mysqli_query($conn,"SELECT username FROM tb_user ");
			$r = mysqli_fetch_array($akun);
	
			//cek cookie dan username
			if( $key === hash('sha256',$r['username'])){
				$_SESSION["login"]=true;
			}
		}
	
		if (isset($_SESSION['login'])){
			header("location:beranda.php");
		}
	?>


<!--==========================================================CREATE ACCOUNT===============================================================-->
					
					<br><br><br><br><br>
					<div class="text-center w-full">
						<a class="txt1" href="daftar.php">
							Create new account
							<i class="fa fa-long-arrow-right"></i>						
						</a>
					</div>
					
				</form>
			</div>
		</div>
	</div>

	
	
	

	
<!--===============================================================================================-->	
	<script src="template/masuk/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="template/masuk/vendor/bootstrap/js/popper.js"></script> 
	<script src="template/masuk/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="template/masuk/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="template/masuk/js/main.js"></script>

</body>
</html>
<?php
	
?>