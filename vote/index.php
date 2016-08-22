<!-- 
	http://codething.ru -  уголок веб-разработчика 

	Скрипт для голосования своими руками на PHP и MySQL с использованием AJAX.
	http://codething.ru/vote.php
-->

<?php

	include ("dbconnect.php");
	include ("functions.php");
	
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; Charset=UTF-8">


<script src="showcontent.js" type="text/javascript"></script>
<script>	
	function getRadioGroupValue(radioGroupObj)
	{
		for (var i=0; i < radioGroupObj.length; i++)
			if (radioGroupObj[i].checked) return radioGroupObj[i].value;

		return null;
	}	
	
</script>
</head>

<body>

	<div id="contentBody">
	
		<?php

		if ($_COOKIE['codething_vote']=='1') 	// если уже голосовали, то 
			drawResults();						// выводим результаты,
		else
			drawForm();							// иначе форму для голосования
		?>	
	
	</div>

	<div id="loading" style="display: none">
	Идет загрузка...
	</div>
	
</body>
</html>