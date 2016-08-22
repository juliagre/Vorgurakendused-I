<?php
	function showVisitors($connection) {
		$sql = "SELECT * FROM jgretsan_kylastaja";
		$result = mysqli_query($connection, $sql);
		while ($row = mysqli_fetch_assoc($result)){
			echo "<div class='style'>";
				echo "Oled juba kulastunud<br>";
				echo "<p class='kylastaja'>"."Unikaalsete kulastajate arv: ".$row['uid']."<br>"."</p>";
			echo "</div>";
	}
	}
	
	function visit($connection) {
		$sql = "UPDATE jgretsan_kylastaja SET uid = uid+1";
		$result = mysqli_query($connection, $sql);
		while ($row = mysqli_fetch_assoc($result)){
			echo "Kulastad esimest korda <br>";
			echo "<p class='kasutajanimi'>"."Unikaalsete kulastajate arv: ".$row['uid']."<br>"."</p>";
		}
	}
	
?>