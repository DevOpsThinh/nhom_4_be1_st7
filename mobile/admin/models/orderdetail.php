<?php
	/**
	 * 
	 */
	class Orderdetail extends Db
	{
		//them hang 
		function insertOrderdetail($order_id,$image,$name,$price,$quantity,$total)
		{
			$sql = self::$connection->prepare("INSERT INTO `orderdetail`(`order_id`, `image`, `name`, `price`, `quantity`, `total`) VALUES ('$order_id','$image','$name','$price','$quantity','$total')");
	        $sql->execute();
		}
		//lay thong tin hang theo order_id
		function getOrderdetailByOrderId($order_id)
		{
			$sql = self::$connection->prepare("SELECT * FROM orderdetail WHERE order_id = $order_id");
			$sql->execute();
			$items = array();
			$items = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
			return $items;
		}
		function delteteOrderdetailByOrderId($order_id)
		{
			$sql = self::$connection->prepare("DELETE FROM orderdetail WHERE order_id = $order_id");
			$sql->execute();
		}
	}
?>