<?php
	/**
	 * 
	 */
	class Orderdetail extends Db
	{
		function insertOrderdetail($order_id,$image,$name,$price,$quantity,$total)
		{
			$sql = self::$connection->prepare("INSERT INTO `orderdetail`(`order_id`, `image`, `name`, `price`, `quantity`, `total`) VALUES ('$order_id','$image','$name','$price','$quantity','$total')");
	        $sql->execute();
		}
	}
?>