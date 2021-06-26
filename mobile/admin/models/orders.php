<?php 
/**
 * 
 */
class Order extends Db
{		
	//them du lieu cho bang order
	function insertOrder($code,$created_at,$name,$email,$phonenumber,$message)
	{
		$sql = self::$connection->prepare("INSERT INTO orders(order_id,code,created_at,cus_name,cus_email,cus_phone,message) VALUES(NULL,'$code','$created_at','$name','$email','$phonenumber','$message')");
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
	//dem so luong don dạt hang
	function CountOrder()
	{
		$sql = "SELECT COUNT(order_id) as total FROM orders";
		$item = mysqli_query(self::$connection,$sql);
		$item1 = mysqli_fetch_assoc($item);
		return $item1;
	}
	//xuat thong tin don hang
	function getAllOrder()
	{
		$sql = self::$connection->prepare("SELECT * FROM orders");
        $sql->execute();
        $items = array();
        $items = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $items;
	}
	//xoa order theo id 
	function delteteOrderByOrderId($order_id)
		{
			$sql = self::$connection->prepare("DELETE FROM orders WHERE order_id = $order_id");
			$sql->execute();
		}
}