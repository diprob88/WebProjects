<?php include("check.php"); print"<u><big>Utente: $_nome - $_ruolo - $_codiceunitaoperativa<br>"; ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<font color="#FF6347"><big><center>
<title>Amministrazione unita operative - Inserimento</title>
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
  // Seleziona il database che contiene le unita operative
  @mysql_select_db($db) or die( "Errore durante la selezione del database!");
}

// Mostra la maschera per l'inserimento delle unita operative
function show_unitaoperativa_form() {
  connect_to_db();
  print "<form method='post' action='$_SERVER[PHP_SELF]'>";
  print "<font face='Georgia'>";
  print "<b>Amministrazione - Inserimento Unita' Operative:</b><br /><br /><br />";
  print "Codice: <input type='text' name='codiceunitaoperativa' size='10' maxlenght='10'/>";
  print "&nbsp;&nbsp;Unita' Operativa: <input type='text' name='unitaoperativa' size='100' maxlenght='250'/>";
  print "<br /><br />";
  print "</font>";
  print "<input type='hidden' name='_unitaoperativa_form' value='1'/>";
  print "<input type='submit' value='Registra'/>";
	print "<br /><br /><a href='unitaoperativa.php'>&lt;&lt;Indietro</a>";	
  print "</form>";
	mysql_close();
}

function validate_form() {
  print "<font face='Georgia' color='#ff0000'>";
	if(empty($_POST["codiceunitaoperativa"])) {
	  print "<b>Non e' stato specificato il codice dell'unita operativa!</b><br />";
  	print "</font>";
		return FALSE;
	}
	if(empty($_POST["unitaoperativa"])) {
	  print "<b>Non e' stata specificata la descrizione dell'unita operativa!</b><br />";
  	print "</font>";
		return FALSE;
	}
  return TRUE;
}	  

// Registra l'unita operativa
function exec_admin() { 
  connect_to_db();
	$codiceunitaoperativa = strtoupper($_POST["codiceunitaoperativa"]);
	$unitaoperativa = $_POST["unitaoperativa"];
	// registrazione delle unita operative
	$sql = "insert into unitaoperativa(codiceunitaoperativa, unitaoperativa) values(";
	$sql.="'$codiceunitaoperativa', '$unitaoperativa')";
	mysql_query($sql) or die("Errore durante la registrazione dell'unita operativa!");
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
	if(array_key_exists("_unitaoperativa_form",$_POST)) {
      if(validate_form()) {
			  exec_admin();
			  print "<META HTTP-EQUIV='refresh' content='1; URL=unitaoperativa.php'>";
	  		exit();
			}
	}
	show_unitaoperativa_form();
	?>
</div>

</body>
</html>
