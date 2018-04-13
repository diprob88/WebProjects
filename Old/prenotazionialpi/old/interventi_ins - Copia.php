<?php include("check.php"); print"<u><big>Utente: $_nome - $_ruolo - $_codiceunitaoperativa<br>"; ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<center><u><big><big><font color="#CD5C5C">
<title>Amministrazione Interventi Chirurgici - Inserimento</title></big>
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

// Mostra la maschera per l'inserimento degli interventi
function show_interventi_form() {
	connect_to_db();
	print "<form method='post' action='$_SERVER[PHP_SELF]'>";
	print "<font face='Georgia'>";
	print "<b>Amministrazione - Inserimento Interventi Chirurgici:</b><br /><br /><br />";
	print "Codice: <input type='text' name='codintervento' size='10' maxlenght='10'/>";
	print "&nbsp;&nbsp;Descrizione: <input type='text' name='intervento' size='100' maxlenght='250'/>";
	print "<br /><br />";
	print "</font>";
	print "<input type='hidden' name='_interventi_form' value='1'/>";
	print "<input type='submit' value='Registra'/>";
	print "<br /><br /><a href='interventi.php'>&lt;&lt;Indietro</a>";	
	print "</form>";
	mysql_close();
}

function validate_form() {
	print "<font face='Georgia' color='#ff0000'>";
	if(empty($_POST["codintervento"])) {
	  print "<b>Non e' stato specificato il codice dell'intervento!</b><br />";
  	print "</font>";
		return FALSE;
	}
	if(empty($_POST["intervento"])) {
	  print "<b>Non e' stata specificata la descrizione dell'intervento!</b><br />";
  	print "</font>";
		return FALSE;
	}
	return TRUE;
}	  

// Registra l'esame
function exec_admin() { 
  connect_to_db();
	$codintervento = strtoupper($_POST["codintervento"]);
	$intervento = $_POST["intervento"];
	// registrazione dati interventi
	$sql = "insert into interventi(codintervento, intervento) values(";
	$sql.="'$codintervento', '$intervento')";
	mysql_query($sql) or die("Errore durante la registrazione degli interventi!");
  print "<font face='Georgia' color='#0000ff'>";
	print "<b>La registrazione è stata eseguita con successo.</b>";
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
      if(validate_form()) {
			  exec_admin();
			  print "<META HTTP-EQUIV='refresh' content='1; URL=interventi.php'>";
	  		exit();
			}
	}
	show_interventi_form();
	?>
</div>

</body>
</html>
