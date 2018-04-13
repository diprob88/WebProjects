<?php
session_start();
if(!isset($_SESSION["_nome"]) || !isset($_SESSION["_ruolo"])) {
  print "<h3 align='center'>Devi effettuare il login prima di accedere a questa funzione!</h3>";
	exit();
}   
$_nome = $_SESSION["_nome"];
$_ruolo = $_SESSION["_ruolo"];
$_codiceunitaoperativa = $_SESSION["_codiceunitaoperativa"];
list($filename, $ext) = explode(basename($_SERVER['PHP_SELF']),'.');
// Esegue la connessione al DB
$user = "root";
$passwd = "";
$db = "prenotazionialpi";
// Si connette al server MySql
mysql_connect(localhost,$user,$passwd);
// Seleziona il database che contiene le delibere
@mysql_select_db($db) or die( "Errore durante la selezione del database!");
mysql_close();
?>
