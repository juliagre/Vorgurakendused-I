<?php

	function drawForm() // отображение формы для голосования
	{
		$r=mysql_query ("SELECT * FROM vote WHERE votes is NULL");
		$row=mysql_fetch_array($r);
		echo "<p>".$row['title']."</p>";
		echo "<form name='vote_form'>";
		$r=mysql_query ("SELECT * FROM vote WHERE votes is not NULL");
		while ($row=mysql_fetch_array($r))
			echo "<input type='radio' name='vote' value='{$row['id']}'> {$row['title']}<br/>";
		echo "<br/><input type='button' onclick='showContent(\"vote.php?select=\"+getRadioGroupValue(document.vote_form.vote));' value='Проголосовать'>";
		echo "</form>";
	}
	
	function drawResults() // отображение результатов
	{
		$r=mysql_query ("SELECT * FROM vote WHERE votes is NULL");
		$row=mysql_fetch_array($r);
		echo "<p>".$row['title']."</p>";
		$r=mysql_query ("SELECT * FROM vote WHERE votes is not NULL");
		while ($row=mysql_fetch_array($r))
		echo "{$row['title']}: {$row['votes']}<br/>";
	}
	
?>