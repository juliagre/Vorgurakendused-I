<?php
	date_default_timezone_set('Europe/Tallinn');
	include 'db2.php';
	include 'rate2.php';

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title> Rate </title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<div id= "poll">
    <h3> What is your Gender? </h3>
    <form method='GET' action='".vote()."'>
        Male : 
        <input type ="radio" name ="vote"  id="vote1" >
        <br>
        Female :
        <input type ="radio" name ="vote"  id="vote2" >
		<button type='submit' name='submit'> Vote! </button>
    </form>
</div>


</body>


</html>