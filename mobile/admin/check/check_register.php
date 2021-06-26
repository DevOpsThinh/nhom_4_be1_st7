<?php
require "../models/user.php";
$user = new User();
if(isset($_GET['username']) && isset($_GET['password']) && isset($_GET['role']))
{
	$username = $_GET['username'];
	$password = md5($_GET['password']);
	$role = $_GET['role'];
	//dua user vao databse
	$user->Register($username,$password,$role);
}




