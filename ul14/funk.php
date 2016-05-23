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
	// siia on vaja funktsionaalsust (13. nädalal)
	if(empty($_SESSION["user"])){
		include_once('views/login.html');
	} else {
		header("Location: ?page=loomad");
	}
	
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$errors = array();
		if (!$_POST["user"]){
			$errors[] = "Sisesta oma kasutajanimi!";
			} 
		if (!$_POST["pass"]) {
			$errors[] = "Sisesta parool!";
			} 
		if (!empty ($_POST["pass"]) && !empty ($_POST["user"])) {
			global $connection;
			$user = mysqli_real_escape_string($connection, $_POST["user"]);
			$password = mysqli_real_escape_string($connection, $_POST["pass"]);
			$query = "SELECT id, roll FROM jgretsan_kylastajad WHERE username = '$user' and passw = SHA1('$password')";
			$result = mysqli_query($connection, $query);
			while($rida = mysqli_fetch_assoc($result)){
				$roll = $rida["roll"];
			}
			$count = mysqli_num_rows($result);
			if($count==1){
				$_SESSION["user"] = $user;
				$_SESSION["roll"] = $roll;
				header("location: ?page=loomad");
			}
			else {
				$errors[] = "Wrong Username or Password";
			}
		}
	}
	
}

function logout(){
	$_SESSION=array();
	unset($_SESSION['user']);
	session_destroy();
	header("Location: ?");
}

function kuva_puurid(){
	// siia on vaja funktsionaalsust
	if(empty($_SESSION["user"])){
		include_once('views/login.html');
	} else {
	global $connection;
	$puurid = array();
	$sql="SELECT DISTINCT puur FROM jgretsan_loomaaed ORDER BY puur ASC";
	$result = mysqli_query($connection, $sql);
	while($rida = mysqli_fetch_assoc($result)){
		$loomad=mysqli_query($connection, "SELECT * FROM jgretsan_loomaaed WHERE puur=".mysqli_real_escape_string($connection, $rida["puur"]));
		while($rida2 = mysqli_fetch_assoc($loomad)){
			$puurid[$rida["puur"]][] = $rida2;
		}
	}
	include_once('views/puurid.html');
	}
}

function lisa(){
	// siia on vaja funktsionaalsust (13. nädalal)
	if(empty($_SESSION["user"]) && $_SESSION["roll"] != "admin"){
		include_once('views/login.html');
	} 
	else if(!empty($_SESSION["user"]) && $_SESSION["roll"] != "admin"){
		header("Location: ?page=loomad");
	} else {
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$errors = array();
		if (!$_POST["nimi"]){
			$errors[] = "Sisesta oma nimi!";
			} 
		if (!$_POST["puur"]) {
			$errors[] = "Sisesta puuri number!";
			} 
		if (upload("liik") == "") {
			$errors[] = "Sisesta !";
			} 
		if (empty($errors)){
			global $connection;
			$nimi = mysqli_real_escape_string($connection, $_POST["nimi"]);
			$puur = mysqli_real_escape_string($connection, $_POST["puur"]);
			$pilt = mysqli_real_escape_string($connection, upload("liik"));
			mysqli_query($connection, "INSERT INTO jgretsan_loomaaed (nimi, puur, pilt) VALUES ('$nimi', '$puur', '$pilt')");
			if (mysqli_insert_id($connection) > 0) {
				header("Location: ?page=loomad");
			} else include_once('views/loomavorm.html');
			
			}
		
		}
	include_once('views/loomavorm.html');
	}
}
function upload($name){
	$allowedExts = array("jpg", "jpeg", "gif", "png");
	$allowedTypes = array("image/gif", "image/jpeg", "image/png","image/pjpeg");
	$tmp = explode('.', $_FILES[$name]["name"]);
	$extension = end($tmp);

	if ( in_array($_FILES[$name]["type"], $allowedTypes)
		&& ($_FILES[$name]["size"] < 100000)
		&& in_array($extension, $allowedExts)) {
    // fail õiget tüüpi ja suurusega
		if ($_FILES[$name]["error"] > 0) {
			$_SESSION['notices'][]= "Return Code: " . $_FILES[$name]["error"];
			return "";
		} else {
      // vigu ei ole
			if (file_exists("pildid/" . $_FILES[$name]["name"])) {
        // fail olemas ära uuesti lae, tagasta failinimi
				$_SESSION['notices'][]= $_FILES[$name]["name"] . " juba eksisteerib. ";
				return "pildid/" .$_FILES[$name]["name"];
			} else {
        // kõik ok, aseta pilt
				move_uploaded_file($_FILES[$name]["tmp_name"], "pildid/" . $_FILES[$name]["name"]);
				return "pildid/" .$_FILES[$name]["name"];
			}
		}
	} else {
		return "";
	}
}

?>