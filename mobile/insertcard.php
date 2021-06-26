<?php
	session_start();
	require "models/db.php";
    require "models/product.php";    
    $product = new Product();
    	$action = (isset($_GET['action'])) ? $_GET['action'] : '';   	
    	$id = $_GET['id'];
    	$prod = $product->getProductCartById($id);
    	$qty = (isset($_GET['quantity'])) ? $_GET['quantity'] : 1;
		if(empty($_SESSION['cart']) || !array_key_exists($id, $_SESSION['cart'])){	
			$prod = $product->getProductCartById($id);		
			$prod['qty'] = $qty;
			//gan session = product
			$_SESSION['cart'][$id] = $prod;
		}
		else {	
			if(isset($_GET['id']) && $action == 'tru') {						
				$prod['qty'] = $_SESSION['cart'][$id]['qty'] - $qty;	
				$_SESSION['cart'][$id] = $prod;
			}
			else {		
				$prod['qty'] = $_SESSION['cart'][$id]['qty'] + $qty;	
				$_SESSION['cart'][$id] = $prod;	
			}				
		}	
		header('location:cart.php');		
?>
