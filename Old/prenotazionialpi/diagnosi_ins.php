<?php include("check.php");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>prenotazioni</title>
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
  // Seleziona il database che contiene gli esami
  @mysql_select_db($db) or die( "Errore durante la selezione del database!");
}

// Mostra la maschera per l'inserimento delle diagnosi
function show_diagnosi_form() {
	connect_to_db();	
	?>
	<h2>Inserimento Diagnosi:</h2>
	<h5>(I campi contrassegnati con * sono obbligatori)</h5>
	</div>
	<div>	
	<form method="post" action="<?php $_SERVER[PHP_SELF];?>">
	<label>
	<span>Codice*</span>
	<input type="text" name="codice" size=10 maxlenght=10/></td>
	</label>

	<label>
	<span>Diagnosi*</span>
	<input type="text" name="descrizione" size=100 maxlength=100></td>  
	</label>
	
	<label>
	<span>Reparto<span>
	<select name="codice_unita_operativa">
	<option value="">--Scegliere--</option>	
	<?php
	$sql = "select * from unita_operative order by descrizione";
	$res = mysql_query($sql);
	while($row = mysql_fetch_array($res)) {
		$codice = $row["codice"];
		$descrizione = $row["descrizione"];
		?>
		<option value="<?php echo $codice;?>"><?php echo $descrizione;?></option>
	<?php
	}
	?>
	</select>
	</label>
	
	<input type='hidden' name='_diagnosi_form' value='1'/>
	<input type='submit' value='Registra'/>
	</form>
	</div>
	<?php
	mysql_close();
}

function validate_form() {
	if(empty($_POST["codice"])) {
		?>
		<div id="error"><p>Non e' stato specificato il codice della diagnosi!</p></div>
		<?php
		return FALSE;
	}
	if(empty($_POST["descrizione"])) {
		?>
		<div id="error"><p>Non e' stata specificata la descrizione della diagnosi!</p></div>
		<?php
		return FALSE;
	}
	return TRUE;
}	  

// Registra la diagnosi
function exec_admin() { 
	connect_to_db();
	$codice = strtoupper($_POST["codice"]);
	$descrizione = $_POST["descrizione"];
	$codice_unita_operativa = $_POST["codice_unita_operativa"];
	// registrazione dati diagnosi
	$sql = "insert into diagnosi(codice, descrizione, codice_unita_operativa) values(";
	$sql.="'$codice', '$descrizione', '$codice_unita_operativa')";
	mysql_query($sql) or die("Errore durante la registrazione della diagnosi!");
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
		$_selected = "diagnosi"; // serve ad evidenziare la voce di menù corrente
		include("inc/navigation.php"); 
		?>
	</div>	
		
	<div id="content">
		<?php
		// --- MAIN ---
		if(array_key_exists("_diagnosi_form",$_POST)) {
			if(validate_form()) {
				exec_admin();
				print "<META HTTP-EQUIV='refresh' content='1; URL=diagnosi.php'>";
				exit();
			}
		}
		show_diagnosi_form();
	?>
	</div>
	
	<div id="footer">
		<?php include("inc/footer.php"); ?>
	</div>	

</div>
</body>
</html>
