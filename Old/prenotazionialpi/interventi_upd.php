<?php include("check.php");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<title>Prenotazioni</title>
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
  // Seleziona il database che contiene gli interventi
  @mysql_select_db($db) or die( "Errore durante la selezione del database!");
}

// Mostra la maschera per la modifica degli interventi
function show_interventi_form() {
	connect_to_db();
	$codintervento = $_GET["codintervento"];
	// estrae i dati completi degli interventi
	$sql="select * from interventi where codintervento='".$codintervento."'";	
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$intervento = $row["intervento"];
	$coduo = $row["coduo"];	
?>
	<h3>Modifica Intervento:</h3>
	<h5>(I campi contrassegnati con * sono obbligatori)</h5>	
	</div>
	<div>
	<form method='post' action='<?php echo $_SERVER[PHP_SELF];?>'>
	<label>
	<span>Codice*</span>
	<input type='text' name='codintervento' value="<?php echo $codintervento;?>" size=10 maxlength=10 />
	</label>
	
	<label>
	<span>Descrizione*</span>
	<input type='text' name='intervento' value='<?php echo $intervento;?>' size=100 maxlength=100 />
	</label>
	
	<label>
	<span>Reparto*<span>
	<select name="coduo">
	<option value="">--Scegliere--</option>
	<?php
	$sql = "select * from unitaoperativa order by unitaoperativa";
	$res = mysql_query($sql);
	while($row = mysql_fetch_array($res)) {
		$codice = $row["codiceunitaoperativa"];
		$unitaoperativa = $row["unitaoperativa"];
		?>
		<option value="<?php echo $codice;?>" <?php echo ($codice==$coduo?'selected':'');?>><?php echo $unitaoperativa;?></option>
	<?php
	}
	?>
	</select>
	</label>
	
	<input type='hidden' name='_interventi_form' value='1'/>
	<input type='hidden' name='id' value='<?php echo $id?>'/>
	<input type='submit' value='Registra'/>
	</form>	
	</div>
<?php
	mysql_close();
}

function validate_form() {
	if(empty($_POST["codintervento"])) {
		?>
		<div id="error"><p>Non &egrave; stato specificato il codice dell'intervento!</p></div>
		<?php
		return FALSE;
	}
	if(empty($_POST["intervento"])) {
		?>
		<div id="error"><p>Non &egrave; stata specificata la descrizione dell'intervento!</p></div>
		<?php
		return FALSE;
	}
	return TRUE;
}	  

// Modifica i dati dell'intervento
function exec_admin() { 
	connect_to_db();
	$codintervento = $_POST["codintervento"];
	$intervento = $_POST["intervento"];
	$coduo = $_POST["coduo"];
	// Esegue la query di modifica
	$sql = "update interventi set intervento='$intervento', coduo='$coduo' ";
	$sql.="where codintervento='$codintervento'";
	mysql_query($sql) or die("Errore durante la modifica dei dati dell'intervento!");
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
		$_selected = "interventi"; // serve ad evidenziare la voce di menù corrente
		include("inc/navigation.php"); 
		?>
	</div>	
		
	<div id="content">
		<?php
		// --- MAIN ---
		if(array_key_exists("_interventi_form",$_POST)) {
			exec_admin();
			print "<META HTTP-EQUIV='refresh' content='1; URL=interventi.php'>";
			exit();
		}
		show_interventi_form();
	?>
	</div>

	<div id="footer">
		<?php include("inc/footer.php"); ?>
	</div>
</div>	
	
</body>
</html>
