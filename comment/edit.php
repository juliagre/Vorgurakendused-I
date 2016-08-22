<?php
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
	$cid = $_POST['cid'];
	$message = $_POST['message'];
	
		echo "<form method='POST' action='".edit($connection)."'>
			<input type='hidden' name='cid' value='".$cid."'>
			<textarea name='message'>".$message."</textarea> <br>
			<button type='submit' name='commentSubmit'> Edit </button>
		</form>";
	?>
	

</body>


</html>