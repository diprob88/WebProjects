<?php include("check.php");print"<u><big>Utente: $_nome - $_ruolo - $_codiceunitaoperativa<br>"; ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<center><u><big><big><font color="#CD5C5C">
<title>Pre-Ricovero</title></big>
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
  // Seleziona il database che contiene i medici cardiologi
  @mysql_select_db($db) or die( "Errore durante la selezione del database!");
}

// Mostra la maschera per la modifica dei medici cardiologi
function show_medicica_form() {
  connect_to_db();
	$codmedicoca = $_GET["codmedicoca"];
	// estrae i dati completi dei medici cardiologi
  $sql="select * from medici_ca where codmedicoca='".$codmedicoca."'";	
	$result = mysql_query($sql);
  $row = mysql_fetch_array($result);
	$medicoca = $row["medicoca"];
  print "<form method='post' action='$_SERVER[PHP_SELF]'>";
  print "<font face='Georgia'>";
  print "<b>Amministrazione - Modifica i dati del Medico Cardiologo:</b><br /><br /><br />";
	print "Codice: <input type='text' name='codmedicoca' value='$codmedicoca' size='10' maxlenght='10' readonly/>";
	print "&nbsp;&nbsp;Medico Cardiologo: <input type='text' name='medicoca' value='$medicoca' size='100' maxlenght='250' />";
  print "<br /><br />";
  print "</font>";
  print "<input type='hidden' name='_medicica_form' value='1'/>";
  print "<input type='submit' value='Registra'/>";
	print "<br /><br /><a href='medicica.php'>&lt;&lt;Indietro</a>";
  print "</form>";
	mysql_close();
}

// Modifica i dati del medico
function exec_admin() { 
  connect_to_db();
	$codmedicoca = $_POST["codmedicoca"];
	$medicoca = $_POST["medicoca"];
  // Esegue la query di modifica
	$sql = "update medici_ca set medicoca='$medicoca' ";
	$sql.="where codmedicoca='$codmedicoca'";
	mysql_query($sql) or die("Errore durante la modifica dei dati del medico!");
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
	if(array_key_exists("_medicica_form",$_POST)) {
      exec_admin();
		  print "<META HTTP-EQUIV='refresh' content='1; URL=medicica.php'>";
			exit();
	}
	show_medicica_form();
	?>
</div>

</body>
</html>
