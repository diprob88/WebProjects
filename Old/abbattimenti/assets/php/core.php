<?php
$user = "root";
$passwd = "";
$db = "abbattimenti";
  // Si connette al server MySql
mysql_connect(localhost,$user,$passwd);
  // Seleziona il database che contiene i presidi ospedalieri
@mysql_select_db($db) or die( "Errore durante la selezione del database!");

?>

