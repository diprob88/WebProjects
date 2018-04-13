<?php include("check.php"); ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<title>Inserimento Prestazioni Sanitarie</title>
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
  // Seleziona il database che contiene le prestazioni
  @mysql_select_db($db) or die( "Errore durante la selezione del database!");
}

// Mostra la maschera per l'inserimento delle prestazioni
function show_prestazioni_form() {
	connect_to_db();
?>
	<h2>Inserimento Prestazioni Sanitarie:</h2>  
	<h5>(I campi contrassegnati con * sono obbligatori)</h5>
	</div>	
	<div>		
	<form method="post" action="<?php echo $_SERVER[PHP_SELF];?>">
	<label>
	<span>Codice Individuale dello Specialista*<span>
	<input type="text" name="ci_medico" size=10 maxlenght=10/></td>
	</label>
	
	<label>
	<span>Codice della Prestazione San.*</span>
	<input type="text" name="codice" size=10 maxlenght=10/></td>  
	</label>

	<label>
	<span>Descrizione*</span>
	<input type="text" name="descrizione" size=100 maxlenght=250/></td>  
	</label>
	
	<label>
	<span>Tariffa in euro (il punto è il separatore decimale)*<span>
	<input type="text" name="tariffa_euro" size=12 maxlenght=12/></td>  
	</label>
	
	<input type='hidden' name='_prestazioni_form' value='1'/>
	<input type='submit' value='Registra'/>
	</form>
	</div>
<?php
	mysql_close();
}

function validate_form() {
	if(empty($_POST["ci_medico"])) {
		?>
		<div id="error"><p>Non &egrave; stato specificato il codice individuale dello specialista che eroga la prestazione sanitaria!</p></div>
		<?php
		return FALSE;
	}
	if(empty($_POST["codice"])) {
		?>
		<div id="error"><p>Non &egrave; stato specificato il codice della prestazione sanitaria!</p></div>
		<?php
		return FALSE;
	}
	if(empty($_POST["descrizione"])) {
		?>
		<div id="error"><p>Non &egrave; stata specificata la descrizione della prestazione sanitaria!</p></div>
		<?php
		return FALSE;
	}
	if(empty($_POST["descrizione"])) {
		?>
		<div id="error"><p>Non &egrave; stata specificata la tariffa della prestazione sanitaria!</p></div>
		<?php
		return FALSE;
	}
	return TRUE;
}	  

// Registra la prestazione
function exec_admin() { 
	connect_to_db();
	$ci_medico = strtoupper($_POST["ci_medico"]);
	$codice = strtoupper($_POST["codice"]);
	$descrizione = $_POST["descrizione"];
	$tariffa_euro = $_POST["tariffa_euro"];
	// registrazione dati della prestazione
	$sql = "insert into prestazioni(ci_medico, codice, descrizione, tariffa_euro) values(";
	$sql.="'$ci_medico', '$codice', '$descrizione', '$tariffa_euro')";
	mysql_query($sql) or die("Errore durante la registrazione della prestazione!");
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
		$_selected = "prestazioni"; // serve ad evidenziare la voce di menù corrente
		include("inc/navigation.php"); 
		?>
	</div>	
		
	<div id="content">
		<?php
	// --- MAIN ---
	if(array_key_exists("_prestazioni_form",$_POST)) {
      if(validate_form()) {
			  exec_admin();
			  print "<META HTTP-EQUIV='refresh' content='1; URL=prestazioni.php'>";
	  		exit();
			}
	}
	show_prestazioni_form();
	?>
	</div>
	
	<div id="footer">
		<?php include("inc/footer.php"); ?>
	</div>	
</div>	
</body>
</html>
