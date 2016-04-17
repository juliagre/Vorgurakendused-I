<?php 
	$taust="#fff"; // vaikimisi valge
	if (empty ($tekst = $_POST['tekst'])) {
		echo "Sisesta tekst";
		}
	else {
		$tekst = $_POST['tekst'];
		}
		
	if (isset($_POST['taust']) ) { 
		$taust=htmlspecialchars($_POST['taust']);
	}
?>
