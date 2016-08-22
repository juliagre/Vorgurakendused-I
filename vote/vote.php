<?php
	include ("dbconnect.php");
	include ("functions.php");
	
	// установка cookie для избежания повторного голосования с одного браузера.
	setcookie ("codething_vote","1");
	
	// добавление выбранного варианта
	$select = $_REQUEST['select'];
	mysql_query ("UPDATE vote SET votes = votes + 1 WHERE id = '$select'");

	// отображение результатов
	drawResults();
	
	
?>