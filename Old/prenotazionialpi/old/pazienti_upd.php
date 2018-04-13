<?php include("check.php"); print"<u><big>Utente: $_nome - $_ruolo - $_codiceunitaoperativa<br>";?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<center><big><font color="#7B68EE">
	<title>Amministrazione pazienti - Modifica</title>
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
  // Seleziona il database che contiene i pazienti
  @mysql_select_db($db) or die( "Errore durante la selezione del database!");
}

// Mostra la maschera per la modifica dei pazienti
function show_pazienti_form() {
  connect_to_db();
	$id = $_GET["id"];
	// estrae i dati completi dei pazienti
	$sql="select * from pazienti where id='".$id."'";	
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$cognome = $row["cognome"];
	$nome = $row["nome"];
	
	$datanascita = $row["datanascita"];
	list($yyyy, $mm, $dd) = split('[/.-]',$datanascita);	
	$datanascita = "$dd-$mm-$yyyy";
	
	$luogonascita = $row["luogonascita"];
	$viaresidenza = $row["viaresidenza"];
	$cittaresidenza = $row["cittaresidenza"];
	$telefono = $row["telefono"];
	print "<form method='post' action='$_SERVER[PHP_SELF]'>";
	print "<font face='Georgia'>";
	print "<b>Amministrazione - Modifica pazienti:</b><br /><br /><br />";
	print "&nbsp;&nbsp;Cognome: <input type='text' name='cognome' value='$cognome' size='61' maxlenght='250' /a>";
	print "&nbsp;&nbsp;Nome: <input type='text' name='nome' value='$nome' size='61' maxlenght='250' /a><br /><br />";
	print "&nbsp;&nbsp;Sesso: <input type='text' name='sesso' size='6' maxlenght='1'/>";
	print "&nbsp;&nbsp;Data di nascita: <input type='text' name='datanascita' value='$datanascita' size='14' maxlenght='250' /a>";
	print "&nbsp;&nbsp;Luogo di nascita: <input type='text' name='luogonascita' value='$luogonascita' size='55' maxlenght='250' /a><br /><br />";
	print "&nbsp;&nbsp;Citta di Residenza: <input type='text' name='cittaresidenza' value='$cittaresidenza' size='50' maxlenght='250' /a>";
	print "&nbsp;&nbsp;Via: <input type='text' name='viaresidenza' value='$viaresidenza' size='62' maxlenght='250' /a><br /><br />";
	print "&nbsp;&nbsp;Codice Fiscale: <input type='text' name='codicefiscale' size='56' maxlenght='16'/a>";
	print "&nbsp;&nbsp;Telefono: <input type='text' name='telefono' value='$telefono' size='55' maxlenght='250' /><br /><br />";
	print "&nbsp;&nbsp;Medico Curante/Telefono: <input type='text' name='medico' size='116' maxlenght='50'/>";
	print "<br /><br />";
	print "</font>";
	print "<input type='hidden' name='_pazienti_form' value='1'/>";
	print "<input type='hidden' name='id' value='$id'/>";
	print "<input type='submit' value='Registra'/>";
	print "<br /><br /><a href='pazienti.php'>&lt;&lt;Indietro</a>";
	print "</form>";
	mysql_close();
}

// Modifica i dati del paziente
function exec_admin() { 
  connect_to_db();
	$id = $_POST["id"];
	$cognome = $_POST["cognome"];
	$nome = $_POST["nome"];
	$sesso = $_POST["sesso"];

	$datanascita = $_POST["datanascita"];
	list($dd, $mm, $yyyy) = split('[/.-]',$datanascita);	
	$datanascita = "$yyyy-$mm-$dd";

	$luogonascita = $_POST["luogonascita"];
	$codicefiscale = $_POST["codicefiscale"];
	$viaresidenza = $_POST["viaresidenza"];
	$cittaresidenza = $_POST["cittaresidenza"];
	$telefono = $_POST["telefono"];
	$medico = $_POST["medico"];
	// Esegue la query di modifica
	$sql = "update pazienti set cognome='$cognome', nome='$nome',sesso='$sesso', datanascita='$datanascita', luogonascita='$luogonascita', codicefiscale='$codicefiscale', viaresidenza='$viaresidenza', cittaresidenza='$cittaresidenza', telefono='$telefono', medico='$medico' ";
	$sql.= "where id = $id";
	//print $sql; exit();
	mysql_query($sql) or die("Errore durante la modifica dei dati del paziente!");
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
	if(array_key_exists("_pazienti_form",$_POST)) {
      exec_admin();
		  print "<META HTTP-EQUIV='refresh' content='1; URL=pazienti.mod'>";
			exit();
	}
	show_pazienti_form();
	?>
</div>

</body>
</html>
