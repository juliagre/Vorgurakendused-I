<?php


function connect_db(){
	global $connection;
	$host="localhost";
	$user="test";
	$pass="t3st3r123";
	$db="test";
	$connection = mysqli_connect($host, $user, $pass, $db) or die("ei saa ühendust mootoriga- ".mysqli_error());
	mysqli_query($connection, "SET CHARACTER SET UTF8") or die("Ei saanud baasi utf-8-sse - ".mysqli_error($connection));
}

function logi(){
	if(!empty($_SESSION["user"])){
		header("Location: ?page=nait");
	} else {
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$errors = array();
			if (!$_POST["user"]){
				$errors[] = "Sisesta oma nimi!";
			} 
			if (!$_POST["pass"]) {
				$errors[] = "Sisesta parool!";
			} 
			else { 
				if (!empty ($_POST["pass"]) && !empty ($_POST["user"])){
					global $connection;
					$user = mysqli_real_escape_string($connection, $_POST["user"]);
					$password = mysqli_real_escape_string($connection, $_POST["pass"]);
					$query = "SELECT id, nimi, roll FROM jgretsan_kylastajad WHERE username = '$user' and passw = SHA1('$password')";
					$result = mysqli_query($connection, $query);
					while($rida = mysqli_fetch_assoc($result)){
						$roll = $rida["roll"];
						$nimi = $rida["nimi"];
					}
					$count = mysqli_num_rows($result);
					if($count==1){
						$_SESSION["nimi"] = $nimi;
						$_SESSION["user"] = $user;
						$_SESSION["roll"] = $roll;
						header("location: ?page=tekst");
					}
					else {
						$errors[] = "Wrong Username or Password";
					}
				}
			}
		}
	include_once('views/login.html');
	}
}
function logout(){
	$_SESSION=array();
	unset($_SESSION['user']);
	session_destroy();
	header("Location: ?");
}

function kuva_ajalugu(){
	if(empty($_SESSION["user"])){
		include_once('views/login.html');
	} else {
		global $connection;
		$nimi = $_SESSION["nimi"];
		$sql="SELECT vesi, gaas, kuupäev, veehind, gaasihind FROM jgretsan_elanikud WHERE nimi = '$nimi'";
		$result = mysqli_query($connection, $sql);
	}
	include_once('views/ajalugu.html');
}
function kontrolli(){
	if(empty($_SESSION["user"])){
		include_once('views/login.html');
	} else {
		global $connection;
		$month = date("n");
		$year = date("Y");
		$sql= 	"SELECT jgretsan_kylastajad.nimi, jgretsan_elanikud.vesi, jgretsan_elanikud.gaas, jgretsan_elanikud.kuupäev
				FROM jgretsan_kylastajad
				LEFT JOIN jgretsan_elanikud ON jgretsan_kylastajad.nimi = jgretsan_elanikud.nimi
				WHERE jgretsan_kylastajad.nimi <> 'admin' AND ((kuupäev BETWEEN '$year-$month-01' and '$year-$month-04')  OR (kuupäev IS NULL)) ";
		$result = mysqli_query($connection, $sql);
	}
	include_once('views/kontroll.html');
}

function arved(){
	if(empty($_SESSION["user"])){
		include_once('views/login.html');
	} else {
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$errors = array();
		
		if (!$_POST["vesihind"] or !is_numeric($_POST["vesihind"])) {
			$errors[] = "Sisesta vee maksumus!";
		} 
		if (!$_POST["gaashind"] or !is_numeric($_POST["gaashind"])) {
			$errors[] = "Sisesta gaasi maksumus!";
		} 
		if (empty($errors)){
			global $connection;
			$nimi = $_SESSION["nimi"];
			$date = date ("Y/m/d");
			$veehind = floatval(mysqli_real_escape_string($connection, $_POST["vesihind"]));
			$gaasihind = floatval(mysqli_real_escape_string($connection, $_POST["gaashind"]));
			$month = date("n");
			$year = date("Y");
			$sql = mysqli_query($connection, "SELECT nimi, vesi, gaas FROM jgretsan_elanikud WHERE kuupäev BETWEEN '$year-$month-01' and '$year-$month-04'");
			if(mysqli_num_rows($sql)!=0){		
				while($rida = mysqli_fetch_assoc($sql)){
					$omanik = $rida["nimi"];
					$sql2 = mysqli_query($connection, "SELECT pindala FROM jgretsan_kylastajad WHERE nimi = '$omanik'");
					$vesin = $rida["vesi"];
					$gaasin = $rida["gaas"];
					$maksumusv = $vesin*$veehind;
					$maksumusg = $gaasin*$gaasihind;
					mysqli_query($connection, "UPDATE jgretsan_elanikud SET veehind = '$maksumusv', gaasihind = '$maksumusg' WHERE nimi = '$omanik'");
				}
				$errors[] = "Näidud on edukalt sisestatud!";
			} else {
				$errors[] = "Näidud on juba sisestatud!";
			}
		}
	}
	include_once('views/arve.html');
	}
}

function lisa(){
	if(empty($_SESSION["user"])){
		include_once('views/login.html');
	} else {
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$errors = array();
		if (!$_POST["vesi"] or !is_numeric($_POST["vesi"])){
			$errors[] = "Sisesta vee näit!";
		} 
		if (!$_POST["gaas"] or !is_numeric($_POST["gaas"])) {
			$errors[] = "Sisesta gaasi näit!";
		} 
		if (empty($errors)){
			global $connection;
			$nimi = $_SESSION["nimi"];
			$date = date ("Y/m/d");
			$vesi = mysqli_real_escape_string($connection, $_POST["vesi"]);
			$gaas = mysqli_real_escape_string($connection, $_POST["gaas"]);
			$month = date("n");
			$year = date("Y");
			$sql2 = mysqli_query($connection, "SELECT * FROM jgretsan_elanikud WHERE kuupäev BETWEEN '$year-$month-01' and '$year-$month-04' AND nimi = '$nimi'");		
			if(mysqli_num_rows($sql2)==0){	
				mysqli_query($connection, "INSERT INTO jgretsan_elanikud (nimi, vesi, gaas, kuupäev) VALUES ('$nimi', '$vesi', '$gaas', '$date')");
				$errors[] = "Näidud on edukalt sisestatud!";
			} else {
				$errors[] = "Näidud on juba sisestatud!";
			}
		}
	}
	include_once('views/naidud.html');
	}
}
?>