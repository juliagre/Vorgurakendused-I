<!DOCTYPE html>
<html>
<head>
	<title> 8.praktikum </title>
	<meta charset="utf-8" /> 

</head>
<body>
<form name = "form" action="" method = "POST">

	<table>
		<caption> Set your preferences </caption>
		<tr >
			<td>
				<textarea rows="10" cols="20" name = "tekst">
Your text
				</textarea>
			</td>
		</tr>
		<tr>
			<td>Taustavärvus</td>
			<td><input type="text" name="taust"
			    
		</tr>
		<tr>
			<td>Teksti värvus</td>
			<td><input type="text" name="tekstv"
		</tr>
		<tr>
			<td>Piirjoone stiil</td>
			<td><input type="text" name="border"
		</tr>
		<tr>
			<td>Piirjoone laius</td>
			<td><input type="text" name="borderl"
		</tr>
		
		
	</table>
	<input type="submit" value="Submit">
</form>
<?php 
	$taust="#fff"; 
	$border="none"; 
	$tekstv="none"; 
	$borderl="0px"; 
	$tekst = " ";
	if (isset($_POST['taust']) ) { 
		$taust=($_POST['taust']);
	
	}
	if (isset($_POST['border']) ) { 
		$border=($_POST['border']);
	
	}
	if (isset($_POST['tekstv']) ) { 
		$tekstv=($_POST['tekstv']);
	
	}
	if (isset($_POST["borderl"]) ) { 
		$borderl=($_POST['borderl']);
	
	}
	if (isset($_POST['tekst']) ) { 
		$tekst=($_POST['tekst']);
	
	}
?>
		<p> Result: </p>
		<p id="result" style="background-color: <?php echo $taust;?>; color: <?php echo $tekstv;?>; border-style: <?php echo $border;?>; border-width: <?php echo $borderl;?>;" >
			<?php echo $tekst;?>
		</p>

</body>
</html>
