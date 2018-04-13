<?php include("check.php"); ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<title>Modifica anagrafica Paziente</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="cfisc.js"></script>
<script>
$(document).ready(function(){
    $("#datanas").focusout(function(){
		var dt = $(this).val();
		var patt = /\d{2}\/\d{2}\/\d{4}/;
		if(!patt.test(dt)) {
			dt = dt.substr(0,2) + "/" + dt.substr(2,2) + "/" + dt.substr(4,4);
			$(this).val(dt);
		}
    });
	$("#codfis").focusin(function() {
		var cognome = $("#cognome").val();
		var nome = $("#nome").val();
		var sesso = $("#sesso").val();
		var datanas = $("#datanas").val();
		datanas = datanas.match(/^\s*(\d+).(\d+).(\d+)/);
		var luogonas = $("#luogonas").val();
		var codfis = CFisc.calcola_codice(
			nome,
			cognome,
			sesso,
			datanas[1], datanas[2], datanas[3],
			luogonas
		);
		$("#codfis").val(codfis);
	});
});
</script>
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

// Mostra la maschera per la modifica dei pazienti
function show_pazienti_form() {
  connect_to_db();
	$id = $_GET["id"];
	// estrae i dati completi dei pazienti
	$sql="select * from pazienti where id='".$id."'";	
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$cognome = $row["cognome"];
	$nome = $row["nome"];
	$sesso = $row["sesso"];
	
	$datanascita = $row["datanascita"];
	list($yyyy, $mm, $dd) = split('[/.-]',$datanascita);	
	$datanascita = "$dd/$mm/$yyyy";
	
	$luogonascita = $row["luogonascita"];
	$viaresidenza = $row["viaresidenza"];
	$cittaresidenza = $row["cittaresidenza"];
	$telefono = $row["telefono"];
	$codicefiscale = $row["codicefiscale"];
	$medico = $row["medico"];
	$telefonomc = $row["telefonomc"];
	$email = $row["email"];
	?>
	<h3>Modifica Pazienti:</h3>
	<h5>(I campi contrassegnati con * sono obbligatori)</h5>	
	</div>
	<div>	
	<form method='post' action='<?php $_SERVER[PHP_SELF];?>'>
	<label>
	<span>Cognome*</span>
	<input id="cognome" type='text' name='cognome' value="<?php echo $cognome;?>" size='50' maxlength='50' />
	</label>
	
	<label>
	<span>Nome*</span>
	<input id="nome" type='text' name='nome' value='<?php echo $nome;?>' size='50' maxlength='50' />
	</label>

	<label>
	<span>Sesso*</span>
	<select id="sesso" name='sesso'/>
	<option value=""></option>
	<option value="F" <?php echo ($sesso=="F"?"selected":"")?> >Femmina</option>
	<option value="M" <?php echo ($sesso=="M"?"selected":"")?>>Maschio</option>
	</select>
	</label>

	<label>
	<span>Data di nascita*</span>
	<input id="datanas" type='text' name='datanascita' value='<?php echo $datanascita;?>' size='10' maxlength='10' />
	</label>
	
	<label>
	<span>Luogo di nascita</span>
	<?php
	$sql = "select * from comuni order by descrizione;";
	//print "$sql<br>";
	?>
	<select id="luogonas" name="luogonascita"/>
	<option value=""></option>
	<?php
	$result = mysql_query($sql);
	while ($row = mysql_fetch_array($result)) {
		$codice = $row["codice"];
		$descrizione = $row["descrizione"];
		$provincia = $row["provincia"];
		?>
		<option value="<?php echo $codice;?>" <?php echo ($codice==$luogonascita?"selected":"");?>><?php echo "$descrizione - $provincia";?></option>
	<?php
	}
	?>
	</select>
	</label>
	
	<label>
	<span>Codice Fiscale*</span>
	<input id="codfis" type='text' name='codicefiscale' value='<?php echo $codicefiscale;?>' size='16' maxlength='16'/>
	</label>

	<label>
	<span>Citt&agrave; di Residenza</span>
	<?php
	$sql = "select * from comuni order by descrizione;";
	//print "$sql<br>";
	?>
	<select id="cittares" name="cittaresidenza"/>
	<option value=""></option>
	<?php
	$result = mysql_query($sql);
	while ($row = mysql_fetch_array($result)) {
		$codice = $row["codice"];
		$descrizione = $row["descrizione"];
		$provincia = $row["provincia"];
		?>
		<option value="<?php echo $codice;?>" <?php echo ($codice==$cittaresidenza?"selected":"");?>><?php echo "$descrizione - $provincia";?></option>
	<?php
	}
	?>
	</select>
	</label>
	
	<!--<label><span>Citta di Residenza</span>
	<input id="cittares" type='text' name='cittaresidenza' value='<?php echo $cittaresidenza;?>' size='50' maxlength='50'/>
	</label>-->

	<label>
	<span>Via</span>
	<input id="viares" type='text' name='viaresidenza' value='<?php echo $viaresidenza;?>' size='50' maxlength='50' />
	</label>

	<label>
	<span>Telefono*</span>
	<input id="tel" type='text' name='telefono' value='<?php echo $telefono;?>' size='50' maxlength='50' />
	</label>
	
	<!--<label>
	<span>Medico Curante</span>
	<input id="telmed" type='text' name='medico' value='<?php //echo $medico;?>' size='20' maxlength='20'/>
	</label>

	<label>
	<span>Telefono Medico Curante</span>
	<input id="telmed" type='text' name='telefonomc' value='<?php //echo $telefonomc;?>' size='20' maxlength='20'/>
	</label>-->
	
	<label>
	<span>email</span>
	<input id="email" type='text' name='email' value='<?php echo $email;?>' size='50' maxlength='50' />
	</label>

	<input type='hidden' name='_pazienti_form' value='1'/>
	<input type='hidden' name='id' value='<?php echo $id?>'/>
	<input type='submit' value='Registra'/>
	</form>	
	</div>
	<?php
	mysql_close();
}


function validate_form() {
	if(empty($_POST["cognome"])) {
		?>
		<div id="error"><p>Non e' stato specificato il cognome del paziente!</p></div>
		<?php
		return FALSE;
	}
	if(empty($_POST["nome"])) {
		?>
		<div id="error"><p>Non e' stato specificato il nome del paziente!</p></div>
		<?php
		return FALSE;
	}
	if(empty($_POST["sesso"])) {
		?>
		<div id="error"><p>Non e' stato specificato il sesso del paziente!</p></div>
		<?php
		return FALSE;
	}	
	if(empty($_POST["datanascita"])) {
		?>
		<div id="error"><p>Non e' stata specificata la data di nascita del paziente!</p></div>
		<?php
		return FALSE;
	}
	if(empty($_POST["telefono"])) {
		?>
		<font face='Georgia' color='#ff0000'>		
		Non e' stato specificato il recapito telefonico del paziente!
		</font>
		<?php
		return FALSE;
	}	
	$arrayData = split("[/.-]", $_POST["datanascita"]);
	$Giorno = $arrayData[0];
	$Mese = $arrayData[1];
	$Anno = $arrayData[2];
	if(!checkdate($Mese, $Giorno, $Anno))
	{
		?>
		<div id="error"><p>La data di nascita inserita non è valida!</p></div>
		<?php
		return FALSE;
	}
	else
	{
		return TRUE;
	}
	
	return TRUE;
}	  


// Modifica i dati del paziente
function exec_admin() { 
  connect_to_db();
	$id = $_POST["id"];
	$cognome = strtoupper($_POST["cognome"]);
	$nome = strtoupper($_POST["nome"]);
	$sesso = strtoupper($_POST["sesso"]);

	$datanascita = $_POST["datanascita"];
	list($dd, $mm, $yyyy) = split('[/.-]',$datanascita);	
	$datanascita = "$yyyy-$mm-$dd";

	$luogonascita = strtoupper($_POST["luogonascita"]);
	$codicefiscale = strtoupper($_POST["codicefiscale"]);
	$viaresidenza = strtoupper($_POST["viaresidenza"]);
	$cittaresidenza = strtoupper($_POST["cittaresidenza"]);
	$telefono = $_POST["telefono"];
	$medico = $_POST["medico"];
	$telefonomc = $_POST["telefonomc"];
	$email = $_POST["email"];
	// Esegue la query di modifica
	$sql = "update pazienti set cognome='$cognome', nome='$nome',sesso='$sesso', datanascita='$datanascita', luogonascita='$luogonascita', codicefiscale='$codicefiscale', viaresidenza='$viaresidenza', cittaresidenza='$cittaresidenza', telefono='$telefono', medico='$medico', telefonomc='$telefonomc', email='$email' ";
	$sql.= "where id = $id";
	//print $sql; exit();
	mysql_query($sql) or die("Errore durante la modifica dei dati del paziente!");
	print "<font face='Georgia' color='#0000ff'>";
	print "<center><b>La modifica è stata eseguita con successo.</b></center>";
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
		$_selected = "pazienti"; // serve ad evidenziare la voce di menù corrente
		include("inc/navigation.php"); 
		?>
	</div>	
		
	<div id="content">
		<?php
		// --- MAIN ---
		if(array_key_exists("_pazienti_form",$_POST)) {
			if(validate_form()) {
				exec_admin();
				print "<META HTTP-EQUIV='refresh' content='1; URL=pazienti.php'>";
				exit();
			}
		}
		show_pazienti_form();
		?>
	</div>

	<div id="footer">
		<?php include("inc/footer.php"); ?>
	</div>
</div>

</body>
</html>
