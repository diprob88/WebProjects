<?php include("check.php"); print "Utente: $_nome - $_ruolo - $_codiceunitaoperativa<br>"; ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
<div align="center"><small>
	<a href="http://www.policlinicovittorioemanuele.it/" target="_blank"><img
		alt="Azienda Policlinico"
		src="http://10.5.0.254/esami/images/logo.jpg" border="0"
		height="100" width="135"></a>
		<br /><br /><a href='esamipazienti.php'>&lt;&lt;<font color="#ff6666"><big>Indietro<br><br></a>
		<div align="center"><u><font color="#00008B"
<br><title>Inserimento esami per paziente</title>
<link rel="stylesheet" type="text/css" href="css/stile.css" />
</u>
</head>
<body>
<link href="CalendarControl.css" rel="stylesheet" type="text/css">
<script src="CalendarControl.js" language="javascript"></script>

<?php

// --- DEFINIZIONE FUNZIONI ---
// Esegue la connessione al DB
function connect_to_db() {
  $user = "root";
  $passwd = "";
  $db = "esami";
  // Si connette al server MySql
  mysql_connect(localhost,$user,$passwd);
  // Seleziona il database 
  @mysql_select_db($db) or die( "Errore durante la selezione del database!");
}

// Mostra la maschera per l'inserimento degli esami del paziente
function show_insert_form() {
	$_nome = $_SESSION["_nome"];
	$_ruolo = $_SESSION["_ruolo"];
	$_codiceunitaoperativa = $_SESSION["_codiceunitaoperativa"];
	connect_to_db();
	
	// form di inserimento
	print "<form enctype='multipart/form-data' method='post' action='$_SERVER[PHP_SELF]'>";
	print "&nbsp;&nbsp;Data Prenotazione: <input type='text' onfocus='showCalendarControl(this);' name='dataprenotazione' value='$dataprenotazione'size='15' maxlenght='15'/a><br />";
	//print "&nbsp;&nbsp;Data Prenotazione: <input type=''text' name='dataprenotazione' size='10' maxlenght='10'/a>";
	list($yyyy, $mm, $dd) = split('[/.-]',$dataprenotazione);	
		$dataprenotazione = "$dd-$mm-$yyyy";
	print "&nbsp;&nbsp;Data Pre-Ricovero: <input type='text' onfocus='showCalendarControl(this);' name='datarichiesta' value='$datarichiesta'size='15' maxlenght='15'/a><br />";
	list($yyyy, $mm, $dd) = split('[/.-]',$datarichiesta);	
		$datarichiesta = "$dd-$mm-$yyyy";
	print "<br>";
	
	print "&nbsp;&nbsp;Data Anticipo Ricovero: <input type='text' onfocus='showCalendarControl(this);' name='dataanticiporic' value='$dataanticiporic'size='15' maxlenght='15'/a><br />";
	list($yyyy, $mm, $dd) = split('[/.-]',$dataanticiporic);	
		$datanticiporic = "$dd-$mm-$yyyy";
		
	print "&nbsp;&nbsp;Motivo dell'anticipo del ricovero: <input type='text' name='noteantric' size='180' maxlenght='250'/a><br />";
	print "<br>";
	
	// Se l'unità operativa è fissa allore è uguale a quella dell'utente
	// Se l'unità operativa è % allora si può scegliere tra tutte le UU.OO.
	if($_codiceunitaoperativa == '%') {
		// pull-down menù con l'elenco delle unita' operative in archivio
		print "&nbsp;&nbsp;Unita' Operativa: <select name='unitaoperativa'>";
		print "<option value=''>-Scegliere-";
		$sql="select * from unitaoperativa";	
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)) {
			$codiceunitaoperativa = $row["codiceunitaoperativa"];
			$unitaoperativa = $row["unitaoperativa"];	
			print "<option value='$codiceunitaoperativa'>$unitaoperativa";
		}
		print "</select><br><br>";
	}
	else {
		print "<input type='hidden' name='unitaoperativa' value='$_codiceunitaoperativa' /><br>";
	}

	// pull-down menù con l'elenco dei pazienti in archivio
	print "&nbsp;&nbsp;Paziente: <select name='paziente'>";
	print "<option value=''>-Scegliere-";
	$sql="select * from pazienti "; 	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$id = $row["id"];
		$cognome = 
		$row["cognome"];
		$nome = $row["nome"];
		$datanascita = $row["datanascita"];
		list($yyyy, $mm, $dd) = split('[/.-]',$datanascita);	
		$datanascita = "$dd-$mm-$yyyy";
		print "<option value='$id'>$cognome $nome - $datanascita" ;
    }
	print "</select>";
	
	// pull-down menù con l'elenco delle diagnosi in archivio
	print "&nbsp;&nbsp;Diagnosi: <select name='diagnosi'>";
	print "<option value=''>-Scegliere-";
	$sql="select * from diagnosi order by diagnosi";	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$coddiagnosi = $row["coddiagnosi"];
		$diagnosi = $row["diagnosi"];	
		print "<option value='$coddiagnosi'>$diagnosi";
    }
	print "</select><br><br>";
	
	// pull-down menù con l'elenco degli interventi chirurgici in archivio
	print "&nbsp;&nbsp;Intervento Chirurgico: <select name='intervento'>";
	print "<option value=''>-Scegliere-";
	$sql="select * from interventi order by intervento";	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$codintervento = $row["codintervento"];
		$intervento = $row["intervento"];	
		print "<option value='$codintervento'>$intervento";
    }
	print "</select>";
	
	// pull-down menù con l'elenco dei medici in archivio
	print "&nbsp;&nbsp;Medico Chirurgo: <select name='medico'>";
	print "<option value=''>-Scegliere-";
	$sql="select * from medici order by medico";	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$codmedico = $row["codmedico"];
		$medico = $row["medico"];	
		print "<option value='$codmedico'>$codmedico - $medico";
    }
	print "</select><br>";
	
	// pull-down menù con l'elenco delle classificazioni asa in archivio
	print "&nbsp;&nbsp;ASA: <select name='asa'>";
	print "<option value=''>-Scegliere-";
	$sql="select * from asa order by codiceasa";	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$codiceasa = $row["codiceasa"];
		$asa = $row["asa"];	
		print "<option value='$codiceasa'>$codiceasa - $asa";
    }
	print "</select><br><br>";
	
	// pull-down menù con l'elenco dei medici anestesisti in archivio
	print "&nbsp;&nbsp;Medico Anestesista: <select name='medicoan'>";
	print "<option value=''>-Scegliere-";
	$sql="select * from medici_an order by medicoan";	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$codmedicoan = $row["codmedicoan"];
		$medicoan = $row["medicoan"];	
		print "<option value='$codmedicoan'>$codmedicoan - $medicoan";
    }
	print "</select>";
	
	// pull-down menù con l'elenco dei medici cardiologi in archivio
	print "&nbsp;&nbsp;Medico Cardiologo: <select name='medicoca'>";
	print "<option value=''>-Scegliere-";
	$sql="select * from medici_ca order by medicoca";	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$codmedicoca = $row["codmedicoca"];
		$medicoca = $row["medicoca"];	
		print "<option value='$codmedicoca'>$codmedicoca - $medicoca";
    }
	print "</select><br><br>";

	// check box con l'elenco degli esami 
	print "&nbsp;&nbsp;Esami: <br><select name='esami[]' size='40' multiple='multiple'>";
	$sql="select * from esami order by tipo";	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$codice = $row["codice"];
		$descrizione = $row["descrizione"];	
		$tipo = $row["tipo"];
		print "<option value='$codice'>$descrizione - $tipo";
    }
	print "</select><br><br>";
	
	print "&nbsp;&nbsp;Altri esami: <input type='text' name='altri' size='180' maxlenght='250'/a><br /><br />";
	print "&nbsp;&nbsp;Note: <input type='text' name='note' size='186' maxlenght='250'/a><br /><br />";
	//print "Ricovero annullato : <input type='text' name='noricovero' size='2' maxlenght='2' /><br />";
	//print "&nbsp;&nbsp;Motivo dell'annullamento: <input type='text' name='notenoric' size='180' maxlenght='250'/a><br />";
	
	// pull-down menù con l'elenco degli annullamenti in archivio
	print "&nbsp;&nbsp;Ricovero Annullato: <select name='annullato'>";
	print "<option value=''>-Scegliere-";
	$sql="select * from annullati order by annullato";	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$codannullato = $row["codannullato"];
		$annullato = $row["annullato"];	
		print "<option value='$codannullato'>$codannullato - $annullato";
    }
	print "</select><br><br>";
	
	print "</select><br>";
	print "<input type='hidden' name='_insert_form' value='1'/>";
	print "<input type='submit' value='Registra'/>";
	print "<br /><br /><a href='esamipazienti.php'>&lt;&lt;Indietro</a>";	
	print "</form>";
	mysql_close();
}

// Esegue la validazione dei campi immessi dall'utente
function validate_form() {
	print "<font face='Georgia' color='#ff0000'>";
	if(empty($_POST["paziente"]) or empty($_POST["unitaoperativa"]) or empty($_POST["datarichiesta"]))
	{
		print "<b>I campi 'Paziente', 'Unita'' Operativa' e 'Data richiesta'".
		  "sono obbligatori!</b><br />";
		print "</font>";
		return FALSE;
	}
	print "</font>";
	return TRUE;	   
} 

// Esegue la registrazione dei dati dell'esame paziente
function insert_form() { 
	connect_to_db();
	// Inizializza variabili con i valori forniti dall'utente
	$paziente = $_POST["paziente"];
	$esami = $_POST["esami"];
	$unitaoperativa = $_POST["unitaoperativa"];
	$diagnosi = $_POST["diagnosi"];
	$intervento = $_POST["intervento"];
	$medico = $_POST["medico"];
	$medicoan = $_POST["medicoan"];
	$medicoca = $_POST["medicoca"];
	$asa = $_POST["asa"];
	$altri = $_POST["altri"];
	$note = $_POST["note"];
	$noteantric = $_POST["noteantric"];
	//$noricovero = $_POST["noricovero"];
	//$notenoric = $_POST["notenoric"];
	$annullato = $_POST["annullato"];
	$datarichiesta = $_POST["datarichiesta"];
	list($dd, $mm, $yyyy) = split('[/.-]', $datarichiesta);
	$datarichiesta = $yyyy."-".$mm."-".$dd;
	
	$dataprenotazione = $_POST["dataprenotazione"];
	if ($dataprenotazione != '') { 
		list($dd, $mm, $yyyy) = split('[/.-]', $dataprenotazione);
		$dataprenotazione = $yyyy."-".$mm."-".$dd;
	}
	
	if ($dataanticiporic != '') {
		$dataanticiporic = $_POST["dataanticiporic"];
		list($dd, $mm, $yyyy) = split('[/.-]', $dataanticiporic);
		$dataanticiporic = $yyyy."-".$mm."-".$dd;
	}
	
	
	
	foreach($esami as $esame) {
		// costruisce la query di inserimento
		$sql = "insert into esami_pazienti(id_pazienti, codiceesame, codiceunitoperativa, codiceasa, coddiagnosi, codintervento, codmedico, codmedicoan, codmedicoca, dataprenotazione, datarichiesta, dataanticiporic, altri, note, noricovero, notenoric, codannullato, noteantric) " .  
			"values($paziente, '$esame', '$unitaoperativa', '$asa', '$diagnosi', '$intervento', '$medico', '$medicoan', '$medicoca', '$dataprenotazione', '$datarichiesta', '$dataanticiporic', '$altri', '$note', '$noricovero', '$notenoric', '$annullato', '$noteantric')";
		// DEBUG
		//print "$sql<br>"; 
		//print "paziente=$paziente - unita operativa=$unitaoperativa - asa=$asa - esame=$esame<br>";
		// registra gli esami del paziente
		mysql_query($sql) or die("Errore durante la registrazione degli esami!");
		//exit;
	}
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
  if(array_key_exists("_insert_form",$_POST)) {
    if(validate_form()) {
	    insert_form();
		print "<META HTTP-EQUIV='refresh' content='1; URL=esamipazienti.php'>";
		exit();
	  }
	}
	show_insert_form();
  ?>
</div>

</body>
</html> 