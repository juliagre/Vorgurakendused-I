<!DOCTYPE html>
<html>
<body>
 <form action="" method="get">
  Lause: <input type="text" name="message">
  <input type="submit" value="Submit">
</form> 
<?php
error_reporting(0);
$returnMessage = "";
function mirror($muutuja) {
	global $returnMessage; 
	for ($i = strlen("$muutuja")-1; $i >= 0; $i--) {	
		$returnMessage = $returnMessage."$muutuja[$i]";
		} 
}
mirror($_GET["message"]);
?>
<pr> Peegelpilt: <?php echo $returnMessage; ?></pr> 

</body>
</html> 
