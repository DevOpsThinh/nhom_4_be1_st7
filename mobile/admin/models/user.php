<?php	
	require "db.php";
	class User extends Db
	{
		//ham dang ki va check  user 
		function Register($username,$password,$role)
		{			
			$sql1 = self::$connection->prepare("SELECT * FROM users");
			$sql1->execute();
			$item = array();
			$item = $sql1->get_result()->fetch_all(MYSQLI_ASSOC);		
			if($item == null)
			{
				$sql = self::$connection->prepare("INSERT INTO users(user_name,password,role) VALUES('$username','$password','$role')");
					$sql->execute();
					echo "Tạo tài khoản thành công . <a href='javascript: history.go(-1)'>Trở lại</a>";
			}	
			else {				
				$count = 0;
				foreach ($item as $key) {
					if($key['user_name'] == $username)
					{
						echo "Username đã tồn tại . <a href='javascript: history.go(-1)'>Trở lại</a>";
						exit;
						$count++;
					}					
				}
				if($count == 0)
				{
					$sql = self::$connection->prepare("INSERT INTO users(user_name,password,role) VALUES('$username','$password','$role')");
					$sql->execute();
					echo "Tạo tài khoản thành công . <a href='javascript: history.go(-1)'>Trở lại</a>";				
				}
			}			
		}
		//lay ra tat ca user
		function getAllUser()
		{			
			$sql = self::$connection->prepare("SELECT * FROM users"); 		
			$sql->execute();
			$item = array();
			$item = $sql->get_result()->fetch_all(MYSQLI_ASSOC);	
			return $item;
		}
		//lay user theo user,password;
		function getUserByName_Pass($username,$password)
		{
			$sql = "SELECT * FROM users WHERE user_name LIKE '$username' AND password LIKE '$password'"; 		
			$item = mysqli_query(self::$connection,$sql);
			$item1 = mysqli_fetch_assoc($item);
			return $item1;
		}
		//xoa user theo id 
		function deleteUser($user_id)
	    {
	        $sql = self::$connection->prepare("DELETE FROM users WHERE user_id = $user_id");
	        $sql->execute();
	    }
	    //lay tat ca user bang id
	    function getUserById($user_id)
		{
			$sql = "SELECT * FROM users WHERE user_id = $user_id"; 		
			$item = mysqli_query(self::$connection,$sql);
			$item1 = mysqli_fetch_assoc($item);
			return $item1;
		}
		//cap nhat user
		function updateUser($user_id,$user_name,$role)
        {
            $sql = self::$connection->prepare("UPDATE users SET user_name = '$user_name',role = '$role' WHERE user_id = '$user_id'");
            $sql->execute();
        }
        //ma hoa mat khau = *         
	}