<?php
	setcookie('kylastaja',"1",time()+3600*12);
	
	include ("db.php");
	include ("funktsioon.php");
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; Charset=UTF-8">
<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

	<div id="contentBody">
	
		<?php
		if (isset($_COOKIE['kylastaja']) ){
			showVisitors($connection);			
		}			
		else {
			visit($connection);	
		}
		?>	
	
	</div>

	
</body>
</html>