<?php 
	session_start();
	require "models/orders.php";
	require "models/orderdetail.php";
	$order = new Order();
	$orderdetail = new Orderdetail();
	if(!empty($_SESSION['cart']))
	{	
		//xu li du lieu form
		$code = rand(100,100000);
		//xu li ngay thang
		$format = "%Y-%m-%d %H:%M:%S";
		$timestamp = time();
		$created_at = strftime($format, $timestamp );
		//
		$name = $_POST['name'];
		$email = $_POST['email'];
		$phonenumber = $_POST['phonenumber'];
		$address = $_POST['address'];
		$message = $_POST['message'];
		$order->insertOrder($code,$created_at,$name,$email,$phonenumber,$address,$message);
		//xu li gio hang 
		$orderarr = $order->getNewestOrder();
		//lay ra order_id cua tale order
		$order_id = $orderarr['order_id'];
		//$orderdetail->insertOrderdetail()
		foreach ($_SESSION['cart'] as $value) {
			$total = 0;
			$total = $value['price'] * $value['qty'];
			$orderdetail->insertOrderdetail($order_id,$value['pro_image'],$value['name'],$value['price'],$value['qty'],$total);
		}
		echo "Your cart is being processed .<a href='javascript: history.go(-1)'>Go Back</a>";
	}
	else {
		echo "Your Cart Is Empty .<a href='javascript: history.go(-1)'>Go Back</a>";
		die();
	}
?>