<?php include("check.php");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<title>Gestione Unità Operative - Modifica dati</title>
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

// Mostra la maschera per la modifica delle unita operative
function show_unitaoperativa_form() {
	connect_to_db();
	$codice = $_GET["codice"];
	// estrae i dati completi delle unita operative
	$sql="select * from unita_operative where codice = '$codice';";	
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$codice = $row["codice"];
	$descrizione = $row["descrizione"];
	
	?>
	<h3>Modifica Unita' Operativa:</h3>
	<h5>(I campi contrassegnati con * sono obbligatori)</h5>	
	</div>
	<div>
	<form method='post' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
	<label>
	<span>Codice</span>
	<input type='text' name='codice_vis' value="<?php echo $codice;?>" size=10 maxlength=10 disabled />
	</label>
	
	<label>
	<span>Unit&agrave; Operativa</span>
	<input type='text' name='descrizione' value='<?php echo $descrizione;?>' size=100 maxlength=100 />
	</label>
	
	<input type='hidden' name='_unitaoperativa_form' value='1'/>
	<input type='hidden' name='codice' value='<?php echo $codice?>'/>
	<input type='submit' value='Registra'/>	
	</form>	
	</div>
	<?php
	
	mysql_close();
}

function validate_form() {
	if(empty($_POST["descrizione"])) {
		?>
		<p id="error">Non è stata specificata la descrizione della unit&agrave; operativa!</p>
		<?php
		return FALSE;
	}
	return TRUE;
}	  

// Modifica i dati dell'unita operativa
function exec_admin() { 
	connect_to_db();
	$codice = $_POST["codice"];
	$descrizione= $_POST["descrizione"];
	// Esegue la query di modifica
	$sql = "update unita_operative set descrizione = '$descrizione' ";
	$sql.="where codice='$codice'";
	mysql_query($sql) or die("Errore durante la modifica dei dati dell'unità operativa!");
	print "<font face='Georgia' color='#0000ff'>";
	print "<b>La modifica è stata eseguita con successo.</b>";
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
