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
		header("Location: loomaaed.php?page=loomad");
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
			$query = "SELECT id FROM jgretsan_kylastajad WHERE username = '$user' and passw = SHA1('$password')";
			$result = mysqli_query($connection, $query);
			$count = mysqli_num_rows($result);
			if($count==1){
				$_SESSION["user"] = $user;
				header("location: loomaaed.php");
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

function lisa(){
	// siia on vaja funktsionaalsust (13. nädalal)
	if(empty($_SESSION["user"])){
		include_once('views/login.html');
	} 
	include_once('views/loomavorm.html');
}

function upload($name){
	$allowedExts = array("jpg", "jpeg", "gif", "png");
	$allowedTypes = array("image/gif", "image/jpeg", "image/png","image/pjpeg");
	$extension = end(explode(".", $_FILES[$name]["name"]));

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