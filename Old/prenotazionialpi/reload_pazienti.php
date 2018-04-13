<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
<title>Estrae elenco Pazienti aggiornato</title>
</head>
<body>
<?php
$user = "root";
$passwd = "";
$db = "prenotazionialpi";
// Si connette al server MySql
mysql_connect(localhost,$user,$passwd);
// Seleziona il database 
@mysql_select_db($db) or die( "Errore durante la selezione del database!");
$sql = "select * from pazienti order by cognome, nome"; 	
$result = mysql_query($sql);
?>
<select id='paz' name='paziente'>
<option value='' selected>-Scegliere-</option>
<?php
while($row = mysql_fetch_array($result)) {
	$id = $row["id"];
	$cognome = 
	$row["cognome"];
	$nome = $row["nome"];
	$datanascita = $row["datanascita"];
	list($yyyy, $mm, $dd) = split('[/.-]',$datanascita);	
	$datanascita = "$dd-$mm-$yyyy";
	?>
	<option value='<?php echo $id;?>'><?php echo "$cognome $nome - $datanascita";?></option>
<?php	
}
?>
</select>
</body>
</html>
