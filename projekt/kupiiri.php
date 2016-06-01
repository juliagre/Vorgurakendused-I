<?php
require_once('funk.php');
session_start();
connect_db();

$page="pealeht";
if (isset($_GET['page']) && $_GET['page']!=""){
	$page=htmlspecialchars($_GET['page']);
}

include_once('views/head.html');

switch($page){
	case "login":
		logi();
	break;
	case "tekst":
		include_once('views/tekst.html');
	break;
	case "nait":
		kuva_ajalugu();
	break;
	case "kontroll":
		kontrolli();
	break;
	case "arve":
		arved();
	break;
	case "logout":
		logout();
	break;
	case "lisa":
		lisa();
	break;
	default:
		include_once('views/tekst.html');
	break;
}

include_once('views/foot.html');

?>