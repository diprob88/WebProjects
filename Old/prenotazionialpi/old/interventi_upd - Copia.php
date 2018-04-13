<?php include("check.php"); print"<u><big>Utente: $_nome - $_ruolo - $_codiceunitaoperativa<br>"; ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<center><u><big><big><font color="#CD5C5C">
<title>Amministrazione interventi - Modifica</title></big>
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
  // Seleziona il database che contiene gli interventi
  @mysql_select_db($db) or die( "Errore durante la selezione del database!");
}

// Mostra la maschera per la modifica degli interventi
function show_interventi_form() {
  connect_to_db();
	$codintervento = $_GET["codintervento"];
	// estrae i dati completi degli interventi
  $sql="select * from interventi where codintervento='".$codintervento."'";	
	$result = mysql_query($sql);
  $row = mysql_fetch_array($result);
	$intervento = $row["intervento"];
  print "<form method='post' action='$_SERVER[PHP_SELF]'>";
  print "<font face='Georgia'>";
  print "<b>Amministrazione - Modifica Intervento Chirurgico:</b><br /><br /><br />";
	print "Codice: <input type='text' name='codintervento' value='$codintervento' size='10' maxlenght='10' readonly/>";
	print "&nbsp;&nbsp;Intervento: <input type='text' name='intervento' value='$intervento' size='100' maxlenght='250' />";
  print "<br /><br />";
  print "</font>";
  print "<input type='hidden' name='_interventi_form' value='1'/>";
  print "<input type='submit' value='Registra'/>";
	print "<br /><br /><a href='interventi.php'>&lt;&lt;Indietro</a>";
  print "</form>";
	mysql_close();
}

// Modifica i dati dell'intervento
function exec_admin() { 
  connect_to_db();
	$codintervento = $_POST["codintervento"];
	$intervento = $_POST["intervento"];
  // Esegue la query di modifica
	$sql = "update interventi set intervento='$intervento' ";
	$sql.="where codintervento='$codintervento'";
	mysql_query($sql) or die("Errore durante la modifica dei dati dell'intervento!");
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
	if(array_key_exists("_interventi_form",$_POST)) {
      exec_admin();
		  print "<META HTTP-EQUIV='refresh' content='1; URL=interventi.php'>";
			exit();
	}
	show_interventi_form();
	?>
</div>

</body>
</html>
