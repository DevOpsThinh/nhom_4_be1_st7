<?php
	require "../models/user.php";
	require "../models/product.php";
	require "../models/protype.php";
	require "../models/manufacture.php";
	if(isset($_POST['action']) && $_POST['action'] == 'product')
	{
		$product = new Product();
		if(isset($_POST['name']) && isset($_POST['manu_id']) && isset($_POST['type_id'])
		&& isset($_POST['description']) && isset($_POST['price']) && isset($_POST['feature']))
		{
			if(isset($_FILES['fileUpload']))
			{
				$name = $_POST['name'];
				$manu_id = $_POST['manu_id'];
				$type_id = $_POST['type_id'];
				$fileUpload = $_FILES['fileUpload'];
				$description = $_POST['description'];
				$price = $_POST['price'];
				$feature = $_POST['feature'];
				$date = $_POST['date'];
				//name of image 
				$pro_image = $fileUpload['name'];
				$target_file = '../images/'.$pro_image;
				//
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
					$uploadOk = 0;
					echo "only JPG, JPEG, PNG & GIF files are allowed .<a href='javascript: history.go(-1)'>Go Back</a>";
					die();
				}
				//check file size
				if($fileUpload['size'] <= 500000)
				{
					$uploadOk = 1;
				}
				else {
					$uploadOk = 0;
					echo "This image is too large .<a href='javascript: history.go(-1)'>Go Back</a>";
					die();
				}
				if($uploadOk == 0)
				{
					echo "Sorry, your file was not uploaded. .<a href='javascript: history.go(-1)'>Go Back</a>";
					die();
				}
				else {
					move_uploaded_file($fileUpload['tmp_name'],$target_file);
					$product->addProduct($name,$manu_id,$type_id,$price,$pro_image,$description,$feature,$date);
					echo "Upload succesfully!!! .<a href='javascript: history.go(-1)'>Go Back</a>";
				}
			}
			else {				
				echo "No images has been selected .<a href='javascript: history.go(-1)'>Go Back</a>";
			}
		}
	}
	if(isset($_POST['action']) && $_POST['action'] == 'protype') {
		$protype = new Protype();
		if(isset($_POST['name']))
		{
			$type_name = $_POST['name'];			
			$protype->addProtype($type_name);
		}
	}
	if(isset($_POST['action']) && $_POST['action'] == 'manu') {
		$manufacture = new Manufacture();
		if(isset($_POST['name']))
		{
			$manu_name = $_POST['name'];			
			$manufacture->addManu($manu_name);
		}
	}
	if(isset($_POST['action']) && $_POST['action'] == 'register') {	
		$user = new User();	
		if(isset($_POST['name']) && isset($_POST['password']) && $_POST['role'])
		{
			$username = $_POST['name'];	
			$password = md5($_POST['password']);
			$role = $_POST['role'];
			$user->Register($username,$password,$role);
		}
	}