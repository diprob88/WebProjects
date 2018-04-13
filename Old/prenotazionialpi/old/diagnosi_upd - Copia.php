<?php include("check.php"); print"<u><big>Utente: $_nome - $_ruolo - $_codiceunitaoperativa<br>"; ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<center><u><big><big><font color="#CD5C5C">
<title>Amministrazione diagnosi - Modifica</title></big>
<link rel="stylesheet" type="text/css" href="css/stile.css" />
</head>
<body>
<div align="center">
	<a href="http://www.policlinicovittorioemanuele.it/" target="_blank"><img
		alt="Azienda Policlinico"
		src="http://10.5.0.254/esami/images/logo.jpg" border="0"
		height="100" width="135"></a>
<?php
// Esegue la connessione al DB
function connect_to_db() {
  $user = "root";
  $passwd = "";
  $db = "esami";
  // Si connette al server MySql
  mysql_connect(localhost,$user,$passwd);
  // Seleziona il database che contiene le diagnosi
  @mysql_select_db($db) or die( "Errore durante la selezione del database!");
}

// Mostra la maschera per la modifica delle diagnosi
function show_diagnosi_form() {
  connect_to_db();
	$coddiagnosi = $_GET["coddiagnosi"];
	// estrae i dati completi delle diagnosi
  $sql="select * from diagnosi where coddiagnosi='".$coddiagnosi."'";	
	$result = mysql_query($sql);
  $row = mysql_fetch_array($result);
	$diagnosi = $row["diagnosi"];
  print "<form method='post' action='$_SERVER[PHP_SELF]'>";
  print "<font face='Georgia'>";
  print "<b>Amministrazione - Modifica Diagnosi:</b><br /><br /><br />";
	print "Codice: <input type='text' name='coddiagnosi' value='$coddiagnosi' size='10' maxlenght='10' readonly/>";
	print "&nbsp;&nbsp;Diagnosi: <input type='text' name='diagnosi' value='$diagnosi' size='100' maxlenght='250' />";
  print "<br /><br />";
  print "</font>";
  print "<input type='hidden' name='_diagnosi_form' value='1'/>";
  print "<input type='submit' value='Registra'/>";
	print "<br /><br /><a href='diagnosi.php'>&lt;&lt;Indietro</a>";
  print "</form>";
	mysql_close();
}

// Modifica i dati della diagnosi
function exec_admin() { 
  connect_to_db();
	$coddiagnosi = $_POST["coddiagnosi"];
	$diagnosi = $_POST["diagnosi"];
  // Esegue la query di modifica
	$sql = "update diagnosi set diagnosi='$diagnosi' ";
	$sql.="where coddiagnosi='$coddiagnosi'";
	mysql_query($sql) or die("Errore durante la modifica dei dati della diagnosi!");
  print "<font face='Georgia' color='#0000ff'>";
	print "<b>La modifica è stata eseguita con successo.</b>";
  print "</font>";	
	mysql_close();	
}

//include("inc/header.inc");

//include("inc/navigation.inc");
?>

<div id="content">
  <?php
	// --- MAIN ---
	if(array_key_exists("_diagnosi_form",$_POST)) {
      exec_admin();
		  print "<META HTTP-EQUIV='refresh' content='1; URL=diagnosi.php'>";
			exit();
	}
	show_diagnosi_form();
	?>
</div>

</body>
</html>
