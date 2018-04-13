<?php include("check.php"); print"<u><big>Utente: $_nome - $_ruolo - $_codiceunitaoperativa<br>"; ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<center><u><big><font color="#CD5C5C">
<title>Amministrazione asa - Inserimento</title></big>
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

// Mostra la maschera per l'inserimento degli asa
function show_asa_form() {
	connect_to_db();
	print "<form method='post' action='$_SERVER[PHP_SELF]'>";
	print "<font face='Georgia'>";
	print "<b><big>Amministrazione - Nuova Classificazione ASA:</b></big><br /><br /><br>";
	print "Codice: <input type='text' name='codiceasa' size='2' maxlenght='2'/><br><br>";
	print "&nbsp;&nbsp;ASA: <input type='text' name='asa' size='170' maxlenght='250' />";
	print "<br /><br />";
	print "</font>";
	print "<input type='hidden' name='_asa_form' value='1'/>";
	print "<input type='submit' value='Registra'/>";
	print "<br /><br /><a href='asa.php'>&lt;&lt;Indietro</a>";	
	print "</form>";
	mysql_close();
}

function validate_form() {
	print "<font face='Georgia' color='#ff0000'>";
	if(empty($_POST["codiceasa"])) {
	  print "<b>Non e' stato specificato il codice dell'asa!</b><br />";
  	print "</font>";
		return FALSE;
	}
	if(empty($_POST["asa"])) {
	  print "<b>Non e' stata specificata la descrizione dell'asa!</b><br />";
  	print "</font>";
		return FALSE;
	}
	return TRUE;
}	  

// Registra l'asa
function exec_admin() { 
	$codiceasa = strtoupper($_POST["codiceasa"]);
	$asa = $_POST["asa"];
	// registrazione dati asa
	  connect_to_db();
	$sql = "insert into asa(codiceasa, asa) values(";
	$sql.="'$codiceasa', '$asa')";
	mysql_query($sql) or die("Errore durante la registrazione degli asa!");
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
	if(array_key_exists("_asa_form",$_POST)) {
      if(validate_form()) {
			  exec_admin();
			  print "<META HTTP-EQUIV='refresh' content='1; URL=asa.php'>";
	  		exit();
			}
	}
	show_asa_form();
	?>
</div>

</body>
</html>
