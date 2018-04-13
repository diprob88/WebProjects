<?php
function connect_to_db() {
  $user = "root";
  $passwd = "";
  $db = "prenotazionialpi";
  // Si connette al server MySql
  mysql_connect(localhost,$user,$passwd);
  // Seleziona il database 
  @mysql_select_db($db) or die( "Errore durante la selezione del database!");
}

$no_disp_data = $_POST['no_disp_data'];
$no_disp_ci = $_POST['no_disp_ci'];

connect_to_db();
$sql = "insert into date_no_disp(data, ci_medico) values('$no_disp_data', '$no_disp_ci');";
mysql_query($sql) or die("Errore durante la scrittura sulla tabella delle INDISPONIBILITA'!");
mysql_close();
?>