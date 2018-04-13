<?php include("check.php");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Gestione Unità Operative - Inserimento dati</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<?php
// Esegue la connessione al DB
function connect_to_db() {
  $user = "root";
  $passwd = "";
  $db = "prenotazionialpi";
  // Si connette al server MySql
  mysql_connect(localhost,$user,$passwd);
  // Seleziona il database che contiene le unita operative
  @mysql_select_db($db) or die( "Errore durante la selezione del database!");
}

// Mostra la maschera per l'inserimento delle unita operative
function show_unitaoperativa_form() {
	connect_to_db();
	?>
	<h2>Inserimento Unita' Operative:</h2>
	<h5>(I campi contrassegnati con * sono obbligatori)</h5>
	</div>
	<div>
	<form method="post" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
	<label>
	<span>Codice*</span>
	<input type="text" name="codice" size=10 maxlength=10/></td>
	</label>

	<label>
	<span>Descrizione*</span>
	<input type="text" name="descrizione" size=100 maxlength=100/></td>  
	</label>

	<input type='hidden' name='_unitaoperativa_form' value='1'/>
	<input type='submit' value='Registra'/>
	</form>
	</div>
	<?php
	mysql_close();
}

function validate_form() {
	if(empty($_POST["codice"])) {
		?>
		<p id="error">Non &egrave; stato specificato il codice dell'Unita' Operativa!</p>
		<?php
		return FALSE;
	}
	if(empty($_POST["descrizione"])) {
		?>
		<p id="error">Non &egrave; stata specificata la descrizione dell'Unita' Operativa!</p>
		<?php
		return FALSE;
	}
	return TRUE;
}

// Registra l'unita operativa
function exec_admin() { 
	connect_to_db();
	$codice = strtoupper($_POST["codice"]);
	$descrizione = strtoupper($_POST["descrizione"]);
	// registrazione delle unita operative
	$sql = "insert into unita_operative(codice, descrizione) values(";
	$sql.="'$codice', '$descrizione')";
	mysql_query($sql) or die("Errore durante la registrazione dell'unita operativa!");
	print "<font face='Georgia' color='#0000ff'>";
	print "<b>La registrazione è stata eseguita con successo.</b>";
	print "</font>";	
	mysql_close();	
}

?>
<div id="container">
	<div id="header">
		<?php include("inc/header.php"); ?>
	</div>
	
	<div id="sidebarleft">
		<?php 
		$_selected = "unitaoperativa"; // serve ad evidenziare la voce di menù corrente
		include("inc/navigation.php"); 
		?>
	</div>	
		
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
	
	<div id="footer">
		<?php include("inc/footer.php"); ?>
	</div>	

</div>
</body>
</html>
