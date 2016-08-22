<?php

function setComments($connection){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(!empty($_POST['message'])){
			$uid = $_POST['uid'];
			$date = $_POST['date'];
			$message = $_POST['message'];
	
			$sql = "INSERT INTO comments(uid, date, message) VALUES('$uid', '$date', '$message')";
			$result = mysqli_query($connection, $sql);
			} else {
				echo "Sisesta sonum!";
			}
		}
}

function getComments($connection){
	$sql = "SELECT * FROM comments";
	$result = mysqli_query($connection, $sql);
	while ($row = mysqli_fetch_assoc($result)){
		$id = $row['uid'];
		$sql2 = "SELECT * FROM user WHERE id='$id'";
		$result2 = mysqli_query($connection, $sql2);
		if ($row2 = mysqli_fetch_assoc($result2)){
			echo "<div class='commentstyle'>";
				echo "<p class='kasutajanimi'>".$row2['uid']."<br>"."</p>";
				echo "<p class='kuupaev'>".$row['date']."<br>"."</p>";
				echo "<p class='sonum'>".$row['message']."<br>"."</p>";
			if(isset($_SESSION['id'])){
				if($_SESSION['id'] == $row2['id']){
					echo "<form class='delete' method='POST' action='".deleteComments($connection)."'>
					<input type='hidden' name='cid' value='".$row['cid']."'>
					<button type='submit' name='commentDelete'>Delete</button>
					</form>
				
					<form class='edit' method='POST' action='edit.php'>
						<input type='hidden' name='cid' value='".$row['cid']."'>
						<input type='hidden' name='message' value='".$row['message']."'>
						<button>Edit</button>
					</form></div>";
			}
				}
			}
	}
}

function edit($connection){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(isset($_POST['commentSubmit'])){
			$cid = $_POST['cid'];
			$message = $_POST['message'];
	
			$sql = "UPDATE comments SET message='$message' WHERE cid='$cid'";
			$result = mysqli_query($connection, $sql);
			header("Location: index.php");
	}}
}

function deleteComments($connection){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(isset($_POST['commentDelete'])){
			$cid = $_POST['cid'];
			$message = $_POST['message'];
	
			$sql = "DELETE FROM comments WHERE cid='$cid'";
			$result = mysqli_query($connection, $sql);
			header("Location: index.php");
			exit();
			
	}}
}


function login($connection){
	if (isset($_POST['login'])){
		$uid = $_POST['uid'];
		$pwd = $_POST['pwd'];
		
		$sql = "SELECT * FROM user WHERE uid = '$uid' and pwd = '$pwd'";
		$result = mysqli_query($connection, $sql);
		if (mysqli_num_rows($result) == 1){
			if ($row = mysqli_fetch_assoc($result)){
				$_SESSION['id'] = $row['id'];
				header("Location: index.php?loginsuccess");
				exit();
			}
		} else {
			header("Location: index.php?loginfail");
			exit();	
		}
	}
}

function logout(){
	if(isset($_POST['logout'])){
		session_start();
		session_destroy();
		header("Location: index.php");
		exit();
	}
}
