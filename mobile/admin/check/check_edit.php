<?php
	require "../models/user.php";
	require "../models/product.php";
	require "../models/protype.php";
	require "../models/manufacture.php";
	if(isset($_POST['action']) && $_POST['action'] == 'product' && isset($_POST['id']))
	{
		$id = $_POST['id'];
		$product = new Product();
		$prodarr = $product->getProductCartById($id);
		if(isset($_POST['name']) && isset($_POST['manu_id']) && isset($_POST['type_id'])
		&& isset($_POST['description']) && isset($_POST['price']) && isset($_POST['feature']) && isset($_POST['date']))
		{
			$name = $_POST['name'];
			$manu_id = $_POST['manu_id'];
			$type_id = $_POST['type_id'];		
			$pro_image = $prodarr['pro_image'];	
			$description = $_POST['description'];
			$price = $_POST['price'];
			$feature = $_POST['feature'];
			$date = $_POST['date'];
			//name of image 			
			if($_FILES['fileUpload']['name'] == "")
			{
				$product->updateProduct($id,$name,$manu_id,$type_id,$price,$pro_image,$description,$feature,$date);
				echo "Update succesfully!!! .<a href='javascript: history.go(-1)'>Go Back</a>";
			}
			else{				
				$fileUpload = $_FILES['fileUpload'];
				$pro_image = $fileUpload['name'];
				$target_file = '../images/'.$pro_image;
				$uploadOk = 1;
				//check exist image
				if(file_exists($target_file))
				{
					echo "Image already exists .<a href='javascript: history.go(-1)'>Go Back</a>";					
					$uploadOk = 0;
					die();
				}
				else
				{
					$uploadOk = 1;
				}
				//kiem tra dung dinh dang anh 
				if($fileUpload['type'] == 'image/jpeg' || $fileUpload['type'] == 'image/jpg' || $fileUpload['type'] == 'image/png')
				{
					$uploadOk = 1;
				}
				else {					
					echo "only JPG, JPEG, PNG & GIF files are allowed .<a href='javascript: history.go(-1)'>Go Back</a>";
					$uploadOk = 0;
					die();
				}
				//check file size				
				if($uploadOk == 0)
				{
					echo "Sorry, your file was not uploaded. .<a href='javascript: history.go(-1)'>Go Back</a>";
					die();
				}
				else {
					move_uploaded_file($fileUpload['tmp_name'],$target_file);
					$product->updateProduct($id,$name,$manu_id,$type_id,$price,$pro_image,$description,$feature,$date);
					echo "Update succesfully!!! .<a href='javascript: history.go(-1)'>Go Back</a>";
				}				
			}			
		}
	}
	if(isset($_POST['action']) && $_POST['action'] == 'protype' && isset($_POST['type_id'])) {
		$type_id = $_POST['type_id'];
		$protype = new Protype();
		if(isset($_POST['type_name']))
		{
			$type_name = $_POST['type_name'];			
			$protype->updateProtype($type_id,$type_name);
			echo "Update succesfully!!! .<a href='javascript: history.go(-1)'>Go Back</a>";
		}
	}
	if(isset($_POST['action']) && $_POST['action'] == 'manu' && isset($_POST['manu_id'])) {
		$manu_id = $_POST['manu_id'];
		$manufacture = new Manufacture();
		if(isset($_POST['manu_name']))
		{
			$manu_name = $_POST['manu_name'];			
			$manufacture->updateManu($manu_id,$manu_name);
			echo "Update succesfully!!! .<a href='javascript: history.go(-1)'>Go Back</a>";
		}
	}
	if(isset($_POST['action']) && $_POST['action'] == 'user' && isset($_POST['user_id']) ) {	
		$user_id = $_POST['user_id'];
		$user = new User();	
		if(isset($_POST['user_name']) && isset($_POST['role']))
		{
			$username = $_POST['user_name'];	
			$role = $_POST['role'];
			$user->updateUser($user_id,$username,$role);
			echo "Update succesfully!!! .<a href='javascript: history.go(-1)'>Go Back</a>";
		}
	}