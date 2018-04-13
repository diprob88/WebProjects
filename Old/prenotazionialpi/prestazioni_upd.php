<?php include("check.php");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<title>Modifica Prestazioni Sanitarie</title>
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

// Mostra la maschera per la modifica delle prestazioni
function show_prestazioni_form() {
	connect_to_db();
	$ci_medico = $_GET["ci_medico"];	
	$codice = $_GET["codice"];
	$descrizione = $_GET["descrizione"];
	// estrae i dati completi delle prestazioni
	$sql="select * from prestazioni where ci_medico='$ci_medico' and codice='$codice' and descrizione='$descrizione'";	
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$ci_medico = $row["ci_medico"];
	$codice = $row["codice"];
	$descrizione = $row["descrizione"];
	$tariffa_euro = $row["tariffa_euro"]; 
?>
	<h3>Modifica Prestazioni Sanitarie:</h3>
	<h5>(I campi contrassegnati con * sono obbligatori)</h5>	
	</div>
	<div>
	<form method='post' action='<?php echo $_SERVER[PHP_SELF];?>'>
	<label>
	<span>C.I. Specialista*</span>
	<input type='text' name='ci_medico' value="<?php echo $ci_medico;?>" size=10 maxlength=10 disabled />
	</label>

	<label>
	<span>Codice*</span>
	<input type='text' name='codice' value="<?php echo $codice;?>" size=10 maxlength=10 disabled />
	</label>
	
	<label>
	<span>Descrizione*</span>
	<input type='text' name='descrizione' value="<?php echo $descrizione;?>" size=100 maxlength=250 disabled />
	</label>
<?php echo "$tariffa_euro";?>
	<label>
	<span>Tariffa euro* (il punto è il separatore decimale)<span>
	<input type='text' name='tariffa_euro' value="<?php echo $tariffa_euro;?>" size=12 maxlength=12 />
	</label>

	<label>
	<span>Erogata?<span>
	<select name='erogata'>
	<option value='S' selected>Si</option>
	<option value='N'>No</option>
	</select>
	</label>
	
	<input type='hidden' name='_prestazioni_form' value='1'/>
	<input type='hidden' name='id' value='<?php echo $id?>'/>
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

// Modifica i dati della prestazione
function exec_admin() { 
	connect_to_db();
	$ci_medico = $_POST["ci_medico"];
	$codice = $_POST["codice"];
	$descrizione = $_POST["descrizione"];
	$tariffa_euro = $_POST["tariffa_euro"];
	$erogata = $_POST["erogata"];
	// Esegue la query di modifica
	// E' possibile modificare solo il codice e la tariffa in quanto tutti gli altri campi sono campi CHIAVE PRIMARIA
	// Le prestazioni NON possono essere cancellate ma è possibile settare il campo "non_erogata" per renderle non più disponibili all'operatore
	$sql = "update prestazioni set tariffa_euro='$tariffa_euro', erogata='$erogata';";
	$sql.="where ci_medico='$ci_medico and descrizione='$descrizione' and codice='$codice';";
	mysql_query($sql) or die("Errore durante la modifica dei dati della prestazione sanitaria!");
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
		$_selected = "prestazioni"; // serve ad evidenziare la voce di menù corrente
		include("inc/navigation.php");
		?>
	</div>	
		
	<div id="content">
		<?php
		// --- MAIN ---
		if(array_key_exists("_prestazioni_form",$_POST)) {
			exec_admin();
			print "<META HTTP-EQUIV='refresh' content='1; URL=prestazioni.php'>";
			exit();
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
