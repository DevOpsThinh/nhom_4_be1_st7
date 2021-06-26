<?php 
require "db.php";
/**
 * 
 */
class Order extends Db
{		
	//them du lieu cho bang order
	function insertOrder($code,$created_at,$name,$email,$phonenumber,$address,$message)
	{
		$sql = self::$connection->prepare("INSERT INTO orders(order_id,code,created_at,cus_name,cus_email,cus_phone,cus_address,message) VALUES(NULL,'$code','$created_at','$name','$email','$phonenumber','$address','$message')");
        $sql->execute();
	}
	//lay 1 san pham moi nhat 
	function getNewestOrder()
	{
		$sql = "SELECT * FROM orders ORDER BY order_id DESC LIMIT 1";
		$item = mysqli_query(self::$connection,$sql);
		$item1 = mysqli_fetch_assoc($item);
		return $item1;
	}
}