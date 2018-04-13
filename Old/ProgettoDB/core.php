<?php
session_start();
$db_host='localhost';
$db_username='root';
$db_password='';
$db_name='scienzemania';

mysql_select_db($db_name, mysql_connect($db_host,$db_username,$db_password)) or die("Impossibile connettersi.".mysql_error());

//Funzione che ripulisce le variabili
function clear($var)
{
	return addslashes(htmlspecialchars(trim($var)));
}

?>