<?php

	include('connection.php');
	include_once('sign_in.php');
	if(isset($_POST['U_submit'])){
		$UO_password=mysqli_real_escape_string($conection,$_POST['UO_password']);
		$UN_password=mysqli_real_escape_string($conection,$_POST['UN_password']);
		$user_id=$_SESSION['u_id'];

		if(empty($UO_password)|| empty($UN_password)){
			header("location: profile.php?singUp=empty");
			exit();
		}else{
				$password=$_SESSION['u_password'];
				$hased_pwd=password_verify($UO_password, $password);
				if($hased_pwd==true){
					$hased_password=password_hash($UN_password, PASSWORD_DEFAULT);

					$sql="UPDATE sign_up
						SET pwd=? WHERE user_id=?;";

					$stmt=mysqli_prepare($conection,$sql);

					if($stmt){

						mysqli_stmt_bind_param($stmt,'ss',$hased_password,$user_id);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_close($stmt);

						header("location: profile.php?singUp=sucess");
				}
				
					}else{
						header("location: profile.php?singUp=Error");
						exit();
					}
			}
	}
?>