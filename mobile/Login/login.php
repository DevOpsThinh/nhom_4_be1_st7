<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>BE1</title>
	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript" src="../js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/style1.css">
</head>
<body>
	<div class="hero">
		<div class="form-box">
			<div class="form-login">
				<h4>LOGIN</h4>		
			</div>
			<form id="login" class="form-input" action="check_login.php" method="get">
				<input type="text" name="username" class="input-field" placeholder="Username" required>
				<input type="password" name="password" class="input-field" placeholder="Enter password" required>				
				<button type="submit" class="submit-btn">Login</button>
			</form>			
		</div>
	</div>
	
</body>
</html>