<?php include("check.php");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
<title>Modifica dati Prenotazione</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
$(document).ready(function(){
	$("#id_specialista").change(function() {
		var opts = $.map($("#id_hidden_prestazione option").filter(
			function(i, e) {
				return $(e).attr('title') == $("#id_specialista option:selected").val(); 
			}), 
			function(e) {return "<option value='" + $(e).val() + "'>" + $(e).text() + "</option>";}
		);
		var html_str = opts.join("\n");
		$("#id_prestazione").html(html_str);
	});
});
</script>
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
  $db = "prenotazionialpi";
  // Si connette al server MySql
  mysql_connect(localhost,$user,$passwd);
  // Seleziona il database 
  @mysql_select_db($db) or die( "Errore durante la selezione del database!");
}

// ---------------------------------------
// MODIFICA DEI DATI DELLA PRENOTAZIONE 
// ---------------------------------------
// Mostra la maschera per l'inserimento dei dati della prenotazione
function show_insert_form_1() {
	// variabili di sessione
	$_nome = $_SESSION["_nome"];
	$_ruolo = $_SESSION["_ruolo"];
	$_codiceunitaoperativa = $_SESSION["_codiceunitaoperativa"];
	// variabili passate come filtro per l'estrazione della prenotazione da modificare
	$id_prenotazione = $_GET["id_prenotazione"];
	
	// Estrae dal DB i dati della prenotazione da modificare
	connect_to_db();
	$sql="select * from prenotazioni 
		where id = $id_prenotazione";
	//print "$sql<br>";
	//exit();
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$id_paziente = $row["id_paziente"];
	$data_prenotazione = $row["data_prenotazione"];
	list($yyyy, $mm, $dd) = split('[/.-]',$data_prenotazione);	
	$data_prenotazione = "$dd-$mm-$yyyy";
	$ora_prenotazione = $row["ora_prenotazione"];
	$codice_unita_operativa = $row["codice_unita_operativa"];
	$codice_diagnosi = $row["codice_diagnosi"];
	$id_prestazione = $row["id_prestazione"];
	//$codice_intervento = $row["codice_intervento"];
	$ci_medico = $row["ci_medico"];
	$prenotazione_annullata = $row["prenotazione_annullata"];
	$codice_priorita = $row["codice_priorita"];
	$note = $row["note"];
	
?>
	<!--<div align="center">-->
	<h3>Aggiorna o Modifica dati Prenotazione:</h3> 
	<h5>(I campi contrassegnati con * sono obbligatori)</h5>
	</div>	
	<div>		
	<form method="post" action="<?php echo $_SERVER[PHP_SELF];?>">	
	
	<label>
	<span>Data Prenotazione*</span>
	<input type='text' onfocus='showCalendarControl(this);' name='data_prenotazione' value='<?php echo $data_prenotazione;?>' size=10 maxlength=10 />
	</label>	
	
	<label>
	<span>Ora Prenotazione (hh.mm)</span>
	<input type='text' name='ora_prenotazione' value='<?php echo $ora_prenotazione;?>' size=5 maxlength=5 />
	</label>
	
	<label>
	<span>Paziente*</span>
	<select name='paziente'>
	<option value=''>-Scegliere-</option>
	<?php
	$sql = "select * from pazienti order by cognome, nome"; 	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$id_paz = $row["id"];
		$cogn_paz = $row["cognome"];
		$nome_paz = $row["nome"];
		$datanas_paz = $row["datanascita"];
		list($yyyy, $mm, $dd) = split('[/.-]',$datanas_paz);	
		$datanas_paz = "$dd-$mm-$yyyy";
		?>
		<option value='<?php echo $id_paz;?>' <?php echo ($id_paz == $id_paziente?'selected':'');?>><?php echo "$cogn_paz $nome_paz - $datanas_paz";
    }
	?>
	</select>
	</label>

	<label>
	<span>Specialista*</span>
	<select id='id_specialista' name='specialista'>
	<option value=''>-Scegliere-</option>
	<?php	
	$sql = "select * from medici order by nominativo";	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$ci = $row["ci"];
		$nominativo = $row["nominativo"];	
		$specialita = $row["specialita"];
		$tipo_autorizzazione = $row["tipo_autorizzazione"];
		?>
		<option value='<?php echo $ci;?>' style="<?php echo ($tipo_autorizzazione=='Interna Azienda'?'background-color:paleturquoise':'background-color:beige');?>" <?php echo ($ci == $ci_medico?'selected':'');?>><?php echo "$ci - $nominativo - $specialita";
    }
	?>
	</select>
	</label>
	
	<!--<label>
	<span>Unita' Operativa</span> 
	<select name='unitaoperativa'>
	<option value=''>-Scegliere-</option>
	<?php
	/*
	$sql = "select * from unita_operative order by descrizione";	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$codice = $row["codice"];
		$descrizione = $row["descrizione"];	
		?>
		<option value='<?php echo $codice;?>' <?php echo ($codice == $codice_unita_operativa?'selected':'');?>><?php echo $descrizione;
	}
	*/
	?>
	</select>
	</label>-->

	<!-- hidden select utilizzata per la selezione delle sole prestazioni erogate dallo specialista di interesse -->
	<select id='id_hidden_prestazione' style='visibility:hidden;'>
	<?php	
	$sql = "select * from prestazioni order by descrizione;";
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$id = $row["id"];
		$ci_medico_prest = $row["ci_medico"];
		$codice = $row["codice"];
		$descrizione = $row["descrizione"];	
		?>
		<option title='<?php echo $ci_medico_prest;?>' value='<?php echo $id;?>'><?php echo $descrizione;?></option>
	<?php	
    }
	?>
	</select>
	
	<label>
	<span>Prestazione Sanitaria</span>
	<?php		
	// pull-down menù con l'elenco delle prestazioni sanitarie in archivio
	$sql = "select p.* from prestazioni as p, medici as m where p.ci_medico = m.ci " . 
		($ci_medico != "" ? " AND m.ci = '$ci_medico'" : "") .
		" order by p.descrizione;";
	//print "$sql<br>";
	?>
	<select name='prestazione' id='id_prestazione'>
	<option value=''>-Scegliere-</option>
	<?php	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$id = $row["id"];
		$ci_medico_prest = $row["ci_medico"];
		$codice = $row["codice"];
		$descrizione = $row["descrizione"];	
		?>
		<option value='<?php echo $id;?>' <?php echo ($id==$id_prestazione?'selected':'');?>><?php echo $descrizione;?></option>
	<?php	
    }
	?>
	</select>
	</label>

	<label>
	<span>Note</span>
	<textarea name='note' rows='1' cols='100'><?php echo $note;?></textarea>
	</label>
	
	<!--<label>
	<span>Codice Priorit&agrave;</span>
	<select name='codice_priorita'>
	<option value=''>-Scegliere-</option>
	<option value='A' <?php echo ($codice_priorita == 'A'?'selected':'');?>>A</option>
	<option value='B' <?php echo ($codice_priorita == 'B'?'selected':'');?>>B</option>
	<option value='C' <?php echo ($codice_priorita == 'C'?'selected':'');?>>C</option>
	<option value='D' <?php echo ($codice_priorita == 'D'?'selected':'');?>>D</option>
	</select>	
	</label>-->


	<label>
	<span>Prenotazione Annullata</span>
	<select name='prenotazione_annullata'>
	<option value=''>--Scegliere--</option> 
	<option value='ANN1' <?php echo ($prenotazione_annullata=='ANN1'?'selected':'');?>>Su richiesta del paziente</option>
	<option value='ANN2' <?php echo ($prenotazione_annullata=='ANN2'?'selected':'');?>>Su richiesta dello specialista</option>
	<option value='ANN3' <?php echo ($prenotazione_annullata=='ANN3'?'selected':'');?>>Altro</option>	
	</select>
	</label>	
			
	<input type='hidden' name='_insert_form' value='1'/>
	<input id='next' type='submit' value='Registra'/>
	<input type='hidden' name='id_prenotazione' value="<?php echo $id_prenotazione;?>"/>
	</form>
	</div>
	<?php		
	mysql_close();
}
// FINE MODIFICA DATI DELLA PRENOTAZIONE


// Esegue la validazione dei campi immessi dall'utente
function validate_form() {
	if(empty($_POST["paziente"]) or empty($_POST["specialista"]) or empty($_POST["data_prenotazione"]))
	{
		?>
		<p id="error">I campi 'Data prenotazione', 'Paziente' e 'Specialista' sono obbligatori!</p>
		<?php
		return FALSE;
	}

	// controllo di validità dell'ora
	$hh = '00'; $mm = '00'; $ss = '00';
	list($hh, $mm, $ss) = split('[.:,]', $_POST['ora_prenotazione']);
	if(intval($hh) <0 || intval($hh) > 23) {
		?>
		<p id="error">Il campo 'Ora prenotazione' riporta valori non congrui!</p>
		<?php
		return FALSE;		
	}
	if(intval($mm) <0 || intval($mm) > 59) {
		?>
		<p id="error">Il campo 'Ora prenotazione' riporta valori non congrui!</p>
		<?php
		return FALSE;		
	}
	if(intval($ss) <0 || intval($ss) > 59) {
		?>
		<p id="error">Il campo 'Ora prenotazione' riporta valori non congrui!</p>
		<?php
		return FALSE;		
	}
	return TRUE;	   
} 

// Esegue la registrazione dei dati della prenotazione
function insert_form() { 
	connect_to_db();
	// Inizializza variabili con i valori forniti dall'utente
	//		dati della prenotazione
	$id_prenotazione = $_POST["id_prenotazione"];
	$paziente = $_POST["paziente"];
	$specialista = $_POST["specialista"];
	$codice_unita_operativa = $_POST["codice_unita_operativa"];
	$prestazione = $_POST["prestazione"];
	$note = $_POST["note"];
	$diagnosi = $_POST["diagnosi"];
	$prenotazione_annullata = $_POST["prenotazione_annullata"];
	$codice_priorita = $_POST["codice_priorita"];

	$ora_prenotazione = $_POST["ora_prenotazione"];
	list($hh, $mm, $ss) = split('[.:,]', $_POST['ora_prenotazione']);
	$ora_prenotazione = "$hh:$mm";
	
	$data_prenotazione = $_POST["data_prenotazione"];
	list($dd, $mm, $yyyy) = split('[/.-]', $data_prenotazione);
	$data_prenotazione = $yyyy."-".$mm."-".$dd;
	
	// costruisce la query di modifica
	$sql = "update prenotazioni
		set data_prenotazione = '$data_prenotazione',
		ora_prenotazione = '$ora_prenotazione',
		id_paziente = '$paziente', 
		ci_medico = '$specialista',  
		codice_diagnosi = '$diagnosi',
		id_prestazione = '$prestazione',		
		prenotazione_annullata = '$prenotazione_annullata',
		codice_priorita = '$codice_priorita',
		note = '$note'
	where id = $id_prenotazione";

	//print "$sql<br>"; // DEBUG
	//exit(); // DEBUG

	mysql_query($sql) or die("Errore durante la registrazione della prenotazione!");
	
	print "<font face='Georgia' color='#0000ff'>";
	print "<b>La modifica e' stata eseguita con successo.</b>";
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
		$_selected = "prenotazioni"; // serve ad evidenziare la voce di menù corrente
		include("inc/navigation.php"); ?>
	</div>	
		
	<div id="content">
		<?php
		if($_POST['_insert_form']=='1') {
			if(validate_form()) {
				insert_form();
				print "<META HTTP-EQUIV='refresh' content='1; URL=prenotazioni.php'>";				
				exit();
			}
			else {
				show_insert_form_1();
			}
		}
		else {
			show_insert_form_1();
		}
		?>
	</div>
	
	<div id="footer">
		<?php if($_POST['_insert_form'] >= '1') {include("inc/footer.php");} ?>
	</div>	
</div>	
</body>
</html> 