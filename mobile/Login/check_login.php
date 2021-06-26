<?php
	session_start();
	require "../admin/models/user.php";
	$user = new User();
	if(isset($_GET['username']) && isset($_GET['password']))
	{
		$username = $_GET['username'];
		$password = md5($_GET['password']);
		//kiem tra dung du lieu
		$userarr = $user->getUserByName_Pass($username,$password);		
			if($username == $userarr['user_name'] && $password == $userarr['password'])
			{
				$_SESSION['user'] = $userarr;													
				header('location:../admin/index.php');
			}
			else {
				header('location:login.php');
			}
	}