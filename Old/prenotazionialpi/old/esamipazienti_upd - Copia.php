<?php include("check.php"); print"<u><big>Utente: $_nome - $_ruolo - $_codiceunitaoperativa<br>"; ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>

<div align="center">
	<a href="http://www.policlinicovittorioemanuele.it/" target="_blank"><img
		alt="Azienda Policlinico"
		src="http://10.5.0.254/esami/images/logo.jpg" border="0"
		height="100" width="135"></a>
		<br /><br /><small><small><a href='esamipazienti.php'>&lt;&lt;<font color="#ff6666"><big>Indietro<br><br></a>
		<div align="center"><u><font color="#00008B"></u>
		
<div align="center"><u><font color="#483D8B"
<title>Completamento Esami</title></u><small>
<br>
<br>
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

// Mostra la maschera per il completamento degli esami
function show_insert_form() {
	$id = $_GET["id"];
	//$codiceunitaoperativa = $_GET["codiceunitaoperativa"];
	//$codmedico = $_GET["codmedico"];
	$datarichiesta = $_GET["datarichiesta"];
	list($dd, $mm, $yyyy) = split('[/.-]',$datarichiesta);	
	$datarichiesta = "$yyyy-$mm-$dd";
	
	// --
	connect_to_db();
	$sql="select p.id, p.cognome, p.nome, p.datanascita, uo.codiceunitaoperativa, uo.unitaoperativa, codiceasa, ep.datarichiesta, dataprenotazione,
			ep.coddiagnosi, ep.codintervento, codmedico, codmedicoan, codmedicoca, dataanticiporic, noteantric, noricovero, notenoric, codannullato, note, altri, completato
		from esami_pazienti as ep, pazienti as p, unitaoperativa as uo
		where ep.id_pazienti = $id 
		and ep.datarichiesta = '$datarichiesta'
		and ep.id_pazienti = p.id
		and ep.codiceunitoperativa = uo.codiceunitaoperativa";
	
	print "$sql<br>";
	//exit();
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$id = $row["id"];
	$cognome = $row["cognome"];
	$nome = $row["nome"];
	$datanascita = $row["datanascita"];
	list($yyyy, $mm, $dd) = split('[/.-]',$datanascita);	
	$datanascita = "$dd-$mm-$yyyy";
	$unitaoperativa = $row["unitaoperativa"];
	$medico = $row["medico"];
	$asa = $row["asa"];
	$medicoan = $row["medicoan"];
	$medicoca = $row["medicoca"];
	$altri = $row["altri"];
	//$noricovero = $row["noricovero"];
	$datarichiesta = $row["datarichiesta"]; $dt = $datarichiesta;
	list($yyyy, $mm, $dd) = split('[/.-]',$datarichiesta);	
	$datarichiesta = "$dd-$mm-$yyyy";
	$dataprenotazione = $row["dataprenotazione"];
	list($yyyy, $mm, $dd) = split('[/.-]',$dataprenotazione);	
	$dataprenotazione = "$dd-$mm-$yyyy";
	$dataanticiporic = $row["dataanticiporic"];
	list($yyyy, $mm, $dd) = split('[/.-]',$dataanticiporic);	
	$dataanticiporic = "$dd-$mm-$yyyy";
	$noteantric = $row["noteantric"];
	//$notenoric = $row["notenoric"];
	$annullato = $row["annullato"];
	$note = $row["note"];
	$completato = $row["completato"];
	$_codiceasa = $row["codiceasa"];
	$_coddiagnosi = $row["coddiagnosi"];
	$_codintervento = $row["codintervento"];
	$_codmedico = $row["codmedico"];
	$_codmedicoan = $row["codmedicoan"];
	$_codmedicoca = $row["codmedicoca"];
	$_codannullato = $row["codannullato"];
	
	// form di modifica
	print "<form method='post' action='$_SERVER[PHP_SELF]'>";
	print "Paziente: $cognome $nome - $datanascita<br><br>";
	print "Unita' Operativa: $unitaoperativa<br><br>";
	print "Data Pre-ricovero: $datarichiesta<br><br>";
	print "&nbsp;&nbsp;Data Prenotazione: <input type='text' onfocus='showCalendarControl(this);' name='dataprenotazione' value='$dataprenotazione'size='15' maxlenght='15'/a><br />";
	print "&nbsp;&nbsp;Data Anticipo Ricovero: <input type='text' onfocus='showCalendarControl(this);' name='dataanticiporic' value='$dataanticiporic'size='15' maxlenght='15'/a><br />";
	print "&nbsp;&nbsp;Motivo Anticipo Ricovero: <input type='text' name='noteantric' value='$noteantric'size='200' maxlenght='200'/a><br />";
	
	// pull-down menù con l'elenco delle diagnosi in archivio
	print "&nbsp;&nbsp;Diagnosi: <select name='diagnosi'>";
	print "<option value=''>-Scegliere-";
	$sql="select * from diagnosi";	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$coddiagnosi = $row["coddiagnosi"];
		$diagnosi = $row["diagnosi"];	
		print "<option value='$coddiagnosi'"; $coddiagnosi == $_coddiagnosi? print "selected>$diagnosi" : print ">$diagnosi";
    }
	print "</select><br><br>";
	
	// pull-down menù con l'elenco degli interventi chirurgici in archivio
	print "&nbsp;&nbsp;Intervento Chirurgico: <select name='intervento'>";
	print "<option value=''>-Scegliere-";
	$sql="select * from interventi";	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$codintervento = $row["codintervento"];
		$intervento = $row["intervento"];	
		print "<option value='$codintervento'"; $codintervento == $_codintervento? print "selected>$intervento" : print ">$intervento";
    }
	print "</select>";
	
	// pull-down menù con l'elenco dei medici in archivio
	print "&nbsp;&nbsp;Medico Chirurgo: <select name='medico'>";
	print "<option value=''>-Scegliere-";
	$sql="select * from medici";	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$codmedico = $row["codmedico"];
		$medico = $row["medico"];	
		print "<option value='$codmedico'"; $codmedico == $_codmedico ? print "selected>$medico" : print ">$medico";
    }
	print "</select><br><br>";
	
	// pull-down menù con l'elenco delle classificazioni asa in archivio
	print "&nbsp;&nbsp;ASA: <select name='asa'>";
	print "<option value=''>-Scegliere-";
	$sql="select * from asa";	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$codiceasa = $row["codiceasa"];
		$asa = $row["asa"];	
		print "<option value='$codiceasa'"; $codiceasa == $_codiceasa ? print "selected>$codiceasa - $asa" : print ">$codiceasa - $asa";
    }
	print "</select><br>";
	
	// pull-down menù con l'elenco dei medici anestesisti in archivio
	print "&nbsp;&nbsp;Medico Anestesista: <select name='medicoan'>";
	print "<option value=''>-Scegliere-";
	$sql="select * from medici_an";	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$codmedicoan = $row["codmedicoan"];
		$medicoan = $row["medicoan"];	
		print "<option value='$codmedicoan'"; $codmedicoan == $_codmedicoan ? print "selected>$medicoan" : print ">$medicoan";
    }
	
	print "</select>";
	
	// pull-down menù con l'elenco dei medici cardiologi in archivio
	print "&nbsp;&nbsp;Medico Cardiologo: <select name='medicoca'>";
	print "<option value=''>-Scegliere-";
	$sql="select * from medici_ca";	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$codmedicoca = $row["codmedicoca"];
		$medicoca = $row["medicoca"];	
		print "<option value='$codmedicoca'"; $codmedicoca == $_codmedicoca ? print "selected>$medicoca" : print ">$medicoca";
    }
	
	print "</select><br><br>";

	// elenco degli esami già prescritti
	print "&nbsp;&nbsp;<big><u>Esami gi&agrave; prescritti:</big></u><br><br>";
	$sql="select e.* 
	from esami_pazienti ep, esami e
	where ep.codiceesame = e.codice
	and ep.id_pazienti = $id 
	and ep.datarichiesta = '$dt'
	order by tipo";
	//print "$sql<br>"; exit();
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$codice = $row["codice"];
		$descrizione = $row["descrizione"];	
		$tipo = $row["tipo"];
		$es_pre[] = $codice;
		print "$descrizione - <i>$tipo</i><br>"; 
    }
	print "<br><br>";
	// pull-down menù con l'elenco degli esami che possono ancora essere prescritti
	print "Esami da prescrivere: <br><select name='esami[]' size='40' multiple='multiple'>";
	$sql="select * from esami order by tipo";	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$codice = $row["codice"];
		$descrizione = $row["descrizione"];
		$tipo = $row["tipo"];
		if(array_search($codice, $es_pre) === FALSE) { 
			print "<option value='$codice'>$descrizione - $tipo";
		}
	}
	print "</select><br><br>";
	
	print "&nbsp;&nbsp;Altri esami: <input type='text' name='altri' value='$altri'size='180' maxlenght='250'/a><br /><br />";
	print "&nbsp;&nbsp;Note: <input type='text' name='note' value='$note' size='186' maxlenght='250'/a><br /><br />";
	//print "Ricovero annullato : <input type='text' name='noricovero' value='$noricovero' size='2' maxlenght='2' /><br />";
	//print "&nbsp;&nbsp;Motivo dell'annullamento: <input type='text' name='notenoric' value='$notenoric' size='180' maxlenght='250'/a><br />";
	
	// pull-down menù con l'elenco degli annullamenti in archivio
	print "&nbsp;&nbsp;Ricovero Annullato: <select name='annullato'>";
	print "<option value=''>-Scegliere-";
	$sql="select * from annullati";	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$codannullato= $row["codannullato"];
		$annullato = $row["annullato"];	
		print "<option value='$codannullato'"; $codannullato == $_codannullato ? print "selected>$annullato" : print ">$annullato";
    }
	print "</select><br><br>";
	
	print "Completato : <input type='text' name='completato' value='$completato' size='2' maxlenght='2' /><br><br>";
		
	// --
	print "<input type='hidden' name=id value=$id />";
	print "<input type='hidden' name=codiceunitaoperativa value=$codiceunitaoperativa />";
	print "<input type='hidden' name=datarichiesta value='$datarichiesta' />";
	// --

	print "<input type='hidden' name='_insert_form' value='1'/>";
	print "<input type='submit' value='Registra'/>";
	print "<br /><br /><a href='esamipazienti.php'>&lt;&lt;Indietro</a>";	
	print "</form>";
	//print "<br>";
	// Tasto di stampa
	print "<big><u><a href='print.php?id=$id&datarichiesta=$datarichiesta'>&lt;&lt;Stampa</a>";
	
	mysql_close();
}

// Esegue la validazione dei campi immessi dall'utente
function validate_form() {
	print "<font face='Georgia' color='#ff0000'>";
	/*
	if(empty($_POST["paziente"]))
	{
		print "<b>I campi 'Paziente', 'Esame', 'Unita'' Operativa' e 'asa'".
		  "sono obbligatori!</b><br />";
		print "</font>";
		return FALSE;
	}
	*/
	print "</font>";
	return TRUE;	   
} 

// Esegue la registrazione dei dati dell'esame paziente
function insert_form() { 
	connect_to_db();
	// Inizializza variabili con i valori forniti dall'utente
	$id = $_POST["id"];
	$codiceunitaoperativa = $_POST["codiceunitaoperativa"];
	$medico = $_POST["medico"];
	$medicoan = $_POST["medicoan"];
	$medicoca = $_POST["medicoca"];
	
	$datarichiesta = $_POST["datarichiesta"];
	list($dd, $mm, $yyyy) = split('[/.-]',$datarichiesta);	
	$datarichiesta = "$yyyy-$mm-$dd";
	
	$dataprenotazione = $_POST["dataprenotazione"];
	list($dd, $mm, $yyyy) = split('[/.-]',$dataprenotazione);	
	$dataprenotazione = "$yyyy-$mm-$dd";

	$dataanticiporic = $_POST["dataanticiporic"];
	list($dd, $mm, $yyyy) = split('[/.-]',$dataanticiporic);	
	$dataanticiporic = "$yyyy-$mm-$dd";
	
	$noteantric = $_POST["noteantric"];
	$altri = $_POST["altri"];
	//$noricovero = $_POST["noricovero"];
	//$notenoric = $_POST["notenoric"];
	$annullato = $_POST["annullato"];
	$note = $_POST["note"];
	$completato = $_POST["completato"];
	$asa = $_POST["asa"];
	$diagnosi = $_POST["diagnosi"];
	$intervento = $_POST["intervento"];
	$esami = $_POST["esami"];
	
	// costruisce la query di modifica 
	$sql = "update esami_pazienti 
		set dataprenotazione='$dataprenotazione', 
		dataanticiporic='$dataanticiporic', 
		noteantric='$noteantric', 
		altri='$altri', 
		note='$note', 
		completato='$completato',
		coddiagnosi = '$diagnosi',
		codiceasa = '$asa',
		codmedico = '$medico',
		codmedicoan = '$medicoan',
		codmedicoca = '$medicoca',
		codintervento = '$intervento',
		codannullato = '$annullato'
		";
		
	$sql .= " where id_pazienti = $id and datarichiesta = '$datarichiesta'";
	//print "$sql<br>";
	mysql_query($sql) or die("Errore durante la modifica dei dati del paziente!");

	// Inserisce gli ulteriori esami prescritti
	if(! empty($esami)) { 
		foreach($esami as $esame) {
			// costruisce la query di inserimento
			$sql = "insert into esami_pazienti(id_pazienti, 
				codiceesame, 
				codiceunitoperativa, 
				codiceasa, 
				coddiagnosi, 
				codintervento, 
				codmedico,
				codmedicoan,
				codmedicoca,
				codannullato,
				dataprenotazione, 
				datarichiesta, 
				dataanticiporic, 
				altri, 
				note, 
				annullato,
				noteantric) 
			values($id, 
			'$esame', 
			'$codiceunitaoperativa', 
			'$asa', 
			'$diagnosi', 
			'$intervento', 
			'$medico',
			'$medicoan',
			'$medicoca',
			'$dataprenotazione', 
			'$datarichiesta', 
			'$dataanticiporic', 
			'$altri', 
			'$note', 
			//'$noricovero', 
			//'$notenoric', 
			'$annullato',
			'$noteantric')";
			// registra gli esami del paziente
			mysql_query($sql) or die("Errore durante la registrazione degli asa!");
		}
	}
	
	print "<font face='Georgia' color='#0000ff'>";
	print "<b>La modifica e' stata eseguita con successo.</b>";
	print "</font>";	
	mysql_close();	
}
	
	//mysql_query($sql) or die("Errore durante la modifica degli esami!");
	//mysql_close();	
//}

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