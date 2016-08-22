<?php
	session_start();
	date_default_timezone_set('Europe/Tallinn');
	include 'db.php';
	include 'comments.php';

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title> EKSAM </title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	
	<?php
		if(isset($_SESSION['id'])){
			echo "<form method='POST' action='".logout()."'>
				<button type='submit' name='logout'> Log out </button>
			</form>";
			echo "<form method='POST' action='".setComments($connection)."'>
				<input type='hidden' name='uid' value='".$_SESSION['id']."'>
				<input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
				<textarea name='message'></textarea> <br>
				<button type='submit' name='commentSubmit'> Comment </button>
			</form>";
			} else {
				echo "<form method='POST' action='".login($connection)."'>
					<input type='text' name='uid'>
					<input type='password' name='pwd'> <br>
					<button type='submit' name='login'> Login </button>
				</form>";
			}
	?>


	<?php

		getComments($connection);
	?>
	

</body>


</html>