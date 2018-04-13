<?php include("check.php"); print"<u><big>Utente: $_nome - $_ruolo - $_codiceunitaoperativa<br>"; ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<center><u><big><font color="#CD5C5C">
<title>Amministrazione asa - Modifica</title></big>
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
  // Seleziona il database che contiene gli asa
  @mysql_select_db($db) or die( "Errore durante la selezione del database!");
}

// Mostra la maschera per la modifica degli asa
function show_asa_form() {
  connect_to_db();
	$codiceasa = $_GET["codiceasa"];
	// estrae i dati completi degli asa
  $sql="select * from asa where codiceasa='".$codiceasa."'";	
	$result = mysql_query($sql);
  $row = mysql_fetch_array($result);
	$asa = $row["asa"];
  print "<form method='post' action='$_SERVER[PHP_SELF]'>";
  print "<font face='Georgia'>";
  print "<b><big>Amministrazione - Modifica Classificazione ASA:</b></big><br /><br /><br><br>";
	print "Classe: <input type='text' name='codiceasa' value='$codiceasa' size='2' maxlenght='2' readonly/><br><br>";
	print "&nbsp;&nbsp;ASA: <input type='text' name='asa' value='$asa' size='250' maxlenght='250' /><br>";
  print "<br /><br />";
  print "</font>";
  print "<input type='hidden' name='_asa_form' value='1'/>";
  print "<input type='submit' value='Registra'/>";
	print "<br /><br /><a href='asa.php'>&lt;&lt;Indietro</a>";
  print "</form>";
	mysql_close();
}

// Modifica i dati dell'asa
function exec_admin() { 
  connect_to_db();
	$codiceasa = $_POST["codiceasa"];
	$asa = $_POST["asa"];
  // Esegue la query di modifica
	$sql = "update asa set asa='$asa'";
	$sql.="where codiceasa='$codiceasa'";
	mysql_query($sql) or die("Errore durante la modifica dei dati ASA!");
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
	if(array_key_exists("_asa_form",$_POST)) {
      exec_admin();
		  print "<META HTTP-EQUIV='refresh' content='1; URL=asa.php'>";
			exit();
	}
	show_asa_form();
	?>
</div>

</body>
</html>
