<?php include("check.php");print"<u><big>Utente: $_nome - $_ruolo - $_codiceunitaoperativa<br>"; ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<center><u><big><big><font color="#CD5C5C">
<title>Amministrazione medici - Modifica</title></big>
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
  // Seleziona il database che contiene i medici
  @mysql_select_db($db) or die( "Errore durante la selezione del database!");
}

// Mostra la maschera per la modifica dei medici
function show_medici_form() {
  connect_to_db();
	$codmedico = $_GET["codmedico"];
	// estrae i dati completi dei medici
  $sql="select * from medici where codmedico='".$codmedico."'";	
	$result = mysql_query($sql);
  $row = mysql_fetch_array($result);
	$medico = $row["medico"];
  print "<form method='post' action='$_SERVER[PHP_SELF]'>";
  print "<font face='Georgia'>";
  print "<b>Amministrazione - Modifica i dati del Medico:</b><br /><br /><br />";
	print "Codmedico: <input type='text' name='codmedico' value='$codmedico' size='10' maxlenght='10' readonly/>";
	print "&nbsp;&nbsp;Medico: <input type='text' name='medico' value='$medico' size='100' maxlenght='250' />";
  print "<br /><br />";
  print "</font>";
  print "<input type='hidden' name='_medici_form' value='1'/>";
  print "<input type='submit' value='Registra'/>";
	print "<br /><br /><a href='medici.php'>&lt;&lt;Indietro</a>";
  print "</form>";
	mysql_close();
}

// Modifica i dati del medico
function exec_admin() { 
  connect_to_db();
	$codmedico = $_POST["codmedico"];
	$medico = $_POST["medico"];
  // Esegue la query di modifica
	$sql = "update medici set medico='$medico' ";
	$sql.="where codmedico='$codmedico'";
	mysql_query($sql) or die("Errore durante la modifica dei dati del medico!");
  print "<font face='Georgia' color='#0000ff'>";
	print "<b>La modifica � stata eseguita con successo.</b>";
  print "</font>";	
	mysql_close();	
}

//include("inc/header.inc");

//include("inc/navigation.inc");
?>

<div id="content">
  <?php
	// --- MAIN ---
	if(array_key_exists("_medici_form",$_POST)) {
      exec_admin();
		  print "<META HTTP-EQUIV='refresh' content='1; URL=medici.php'>";
			exit();
	}
	show_medici_form();
	?>
</div>

</body>
</html>
