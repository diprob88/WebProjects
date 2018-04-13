<?php include("check.php");print"<u><big>Utente: $_nome - $_ruolo - $_codiceunitaoperativa<br>"; ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<center><u><big><font color="#CD5C5C">
<title>Amministrazione Medici Chirurghi - Inserimento</title></big>
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
  // Seleziona il database che contiene gli esami
  @mysql_select_db($db) or die( "Errore durante la selezione del database!");
}

// Mostra la maschera per l'inserimento degli esami
function show_medici_form() {
	connect_to_db();
	print "<form method='post' action='$_SERVER[PHP_SELF]'>";
	print "<font face='Georgia'>";
	print "<b>Amministrazione - Inserimento Medici Chirurghi:</b><br /><br /><br />";
	print "Codice: <input type='text' name='codmedico' size='10' maxlenght='10'/>";
	print "&nbsp;&nbsp;Medico: <input type='text' name='medico' size='100' maxlenght='250'/>";
	print "<br /><br />";
	print "</font>";
	print "<input type='hidden' name='_medici_form' value='1'/>";
	print "<input type='submit' value='Registra'/>";
	print "<br /><br /><a href='medici.php'>&lt;&lt;Indietro</a>";	
	print "</form>";
	mysql_close();
}

function validate_form() {
	print "<font face='Georgia' color='#ff0000'>";
	if(empty($_POST["codmedico"])) {
	  print "<b>Non e' stato specificato il codice del medico!</b><br />";
  	print "</font>";
		return FALSE;
	}
	if(empty($_POST["medico"])) {
	  print "<b>Non e' stato specificato il nome del medico!</b><br />";
  	print "</font>";
		return FALSE;
	}
	return TRUE;
}	  

// Registra il medico
function exec_admin() { 
  connect_to_db();
	$codmedico = strtoupper($_POST["codmedico"]);
	$medico = $_POST["medico"];
	// registrazione dati del medico
	$sql = "insert into medici(codmedico, medico) values(";
	$sql.="'$codmedico', '$medico')";
	mysql_query($sql) or die("Errore durante la registrazione del medico!");
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
	if(array_key_exists("_medici_form",$_POST)) {
      if(validate_form()) {
			  exec_admin();
			  print "<META HTTP-EQUIV='refresh' content='1; URL=medici.php'>";
	  		exit();
			}
	}
	show_medici_form();
	?>
</div>

</body>
</html>
