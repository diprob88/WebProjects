<?php include("check.php");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
<title>Inserimento dati Prenotazione</title>
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
	$("#reload_pazienti").click(function() {
		$("#_ins_flag").val('0');
		$("#id_data_flt").val($("#id_data_prenotazione").val());
		$("#id_ci_medico_flt").val($("#id_specialista").val());
		$("#id_ora_prenotazione").val($("#id_ora_prenotazione").val());
		$("#id_paziente").val($("#id_paziente").val());
		$("#id_prestazione").val($("#id_prestazione").val());
		$("#id_prenotazione_annullata").val($("#id_prenotazione_annullata").val());
		$("#id_note").val($("#id_note").val());
		$("#id_codice_priorita").val($("#id_codice_priorita").val());
		$("#pren").submit();
	});
	$("#show_tip").mouseover(function() {
		var info = $("#id_specialista option:selected").attr('title');
		if(typeof(info) !== "undefined") {
			$("#info").html("<p style='color:black;font-size:10px;font-style:normal;'>" + info + "</p>");
		};
		$("#info").show(); 
	});
	$("#show_tip").mouseout(function() {
		$("#info").hide(); 
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
// ------------------------------------------------
// INSERIMENTO DEI DATI DEL PAZIENTE - PASSO 1 DI 2
// ------------------------------------------------
// Mostra la maschera per l'inserimento delle prenotazioni
function show_insert_form() {
	$_nome = $_SESSION["_nome"];
	$_ruolo = $_SESSION["_ruolo"];
	$_codiceunitaoperativa = $_SESSION["_codiceunitaoperativa"];
	connect_to_db();
	
	// array per la conversione dei giorni in forma testuale, da inglese a italiano
	$day_to_it = array("Mon" => "lun", "Tue" => "mar", "Wed" => "mer", "Thu" => "gio", "Fri" => "ven", "Sat" => "sab", "Sun" => "dom");
	//print "data_flt = " . $_POST['data_flt'] . " ci_medico_flt = " . $_POST['ci_medico_flt'] . "<br>";
	// controlla se sono stati passati parametri di default nella stringa URL
	if(isset($_GET['data_flt'])) {
		$data_flt = $_GET['data_flt'];
		list($yyyy, $mm, $dd) = split('[/.-]', $data_flt);	
		$data_flt = "$dd-$mm-$yyyy";		
	}
	if(isset($_GET['ci_medico_flt'])) {
		$ci_medico_flt = $_GET['ci_medico_flt'];		
	}
	
	// controlla se sono stati passati parametri di default in seguito al re-POST di refresh della form
	if(isset($_POST["data_flt"])) {
		$data_flt = $_POST['data_flt'];
	}
	if(isset($_POST["ci_medico_flt"])) {
		$ci_medico_flt = $_POST['ci_medico_flt'];
	}
	if(isset($_POST["ora_prenotazione"])) {
		$ora_prenotazione = $_POST['ora_prenotazione'];
	}
	if(isset($_POST["paziente"])) {
		$paziente = $_POST['paziente'];
	}
	if(isset($_POST["prestazione"])) {
		$prestazione = $_POST['prestazione'];
	}
	if(isset($_POST["prenotazione_annullata"])) {
		$prenotazione_annullata = $_POST['prenotazione_annullata'];
	}
	if(isset($_POST["note"])) {
		$note = $_POST['note'];
	}
	if(isset($_POST["codice_priorita"])) {
		$codice_priorita = $_POST['codice_priorita'];
	}
	
	
	// form di inserimento
?>
	<!--<div align="center">-->
	<h2>Inserimento dati Prenotazione:</h2>
	<h5>(I campi contrassegnati con * sono obbligatori)</h5>
	</div>	
	<div>		
	<form id="pren" method="post" action="<?php echo $_SERVER[PHP_SELF];?>">	
	
	<label>
	<span>Data* Prenotazione</span>
	<input id="id_data_prenotazione" type='text' onfocus='showCalendarControl(this);' name='data_prenotazione' value='<?php echo $data_flt;?>' size=10 maxlength=10 />
	</label>

	<label>
	<span>Ora* Prenotazione (hh.mm)</span>
	<input id='id_ora_prenotazione' type='text' name='ora_prenotazione' value='<?php echo $ora_prenotazione;?>' size=5 maxlength=5 />
	</label>

	<div>
	<label>
	<span>Paziente*</span>
	<select id='id_paziente' name='paziente'>
	<option value=''>-Scegliere-</option>
	<?php
	$sql = "select * from pazienti order by cognome, nome"; 	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$id = $row["id"];
		$cognome = 
		$row["cognome"];
		$nome = $row["nome"];
		$datanascita = $row["datanascita"];
		list($yyyy, $mm, $dd) = split('[/.-]',$datanascita);	
		$datanascita = "$dd-$mm-$yyyy";
		?>
		<option value='<?php echo $id;?>' <?php echo ($id==$paziente?'selected':'');?>><?php echo "$cognome $nome - $datanascita";?></option>
	<?php	
    }
	?>
	</select>
	</label>
	<a href='#'><img id='reload_pazienti' style='float:right;' src='images/reload.png' /></a> <!-- pulsante per refresh contenuto select box -->
	<a href='pazienti_ins.php?pren_call=1' target='_blank'><img id='insert_pazienti' style='float:right;' src='images/users_add.png'/></a>	<!-- pulsante per richiamo finestra di inserimento nuovo paziente -->
	</div>
	
	<br>
	
	<div>
	<label>
	<span>Specialista*</span>
	<select name='specialista' id='id_specialista'>
	<option value=''>-Scegliere-</option>
	<?php	
	$sql = "select * from medici order by nominativo;";
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$ci = $row["ci"];
		$nominativo = $row["nominativo"];	
		$specialita = $row["specialita"];
		$tipo_autorizzazione = $row["tipo_autorizzazione"];
		$locali_azienda = $row["locali_azienda"];
		$telefono = $row["telefono"];
		// ricava le fasce orarie di ricevimento per lo specialista e per il giorno in esame
		$sql2 = "select * from agende where ci = '$ci';";
		$result2 = mysql_query($sql2);
		$row2 = mysql_fetch_array($result2);
		$giorno1 = $row2["giorno1"]; if($giorno1!="") {$fascia[$giorno1] = "$row2[fascia1_1] - $row2[fascia1_2] / $row2[fascia1_3] - $row2[fascia1_4]";} 
		$giorno2 = $row2["giorno2"]; if($giorno2!="") {$fascia[$giorno2] = "$row2[fascia2_1] - $row2[fascia2_2] / $row2[fascia2_3] - $row2[fascia2_4]";} 
		$giorno3 = $row2["giorno3"]; if($giorno3!="") {$fascia[$giorno3] = "$row2[fascia3_1] - $row2[fascia3_2] / $row2[fascia3_3] - $row2[fascia3_4]";} 
		$giorno4 = $row2["giorno4"]; if($giorno4!="") {$fascia[$giorno4] = "$row2[fascia4_1] - $row2[fascia4_2] / $row2[fascia4_3] - $row2[fascia4_4]";} 
		$giorno5 = $row2["giorno5"]; if($giorno5!="") {$fascia[$giorno5] = "$row2[fascia5_1] - $row2[fascia5_2] / $row2[fascia5_3] - $row2[fascia5_4]";} 
		$giorno6 = $row2["giorno6"]; if($giorno6!="") {$fascia[$giorno6] = "$row2[fascia6_1] - $row2[fascia6_2] / $row2[fascia6_3] - $row2[fascia6_4]";} 
		list($dd, $mm, $yyyy) = split('[/.-]', $data_flt);	
		$data_flt_en = "$yyyy-$mm-$dd"; $data_flt_int = strtotime($data_flt_en); 
		$ddd = date("D", $data_flt_int); $ddd = $day_to_it[$ddd];
		$orario_ric = $fascia[$ddd];
		// ricava l'elenco delle prenotazioni per lo specialista
		$sql3 = "select paz.cognome, paz.nome, pre.*
				from prenotazioni as pre, pazienti as paz
				where pre.id_paziente = paz.id
				and ci_medico = '$ci' 
				and data_prenotazione = '$data_flt_en' order by ora_prenotazione";
		$res3 = mysql_query($sql3);
		$visite = "";
		while($row3 = mysql_fetch_array($res3)) {
			$cognome = $row3["cognome"];
			$nome = $row3["nome"];
			$data_prenotazione = $row3["data_prenotazione"];
			$ora_prenotazione = $row3["ora_prenotazione"];
			$visite .= "$cognome $nome - $ora_prenotazione<br>";
		}
		?>
		<option value='<?php echo $ci;?>' style="<?php echo ($tipo_autorizzazione=='Interna Azienda'?'background-color:paleturquoise':'background-color:beige');?>" <?php echo ($ci_medico_flt==$ci?'selected':'');?> title='<?php echo "Riceve presso: $locali_azienda<br>Telefono: $telefono<br>Orario ric.: $orario_ric<br>Visite:<br>$visite";?>'><?php echo "$ci - $nominativo - $specialita";?></option>
	<?php
		//print "</select>"; print "$ddd fascia:"; print_r($fascia); break;
    }
	?>
	</select>
	</label>
	<a id="show_tip" href='#' style="float:right;"><img src='images/info.png'></a>
	</div>
	
	<div id='info' style="display:none">
		<!-- info sui locali di ricevimento e il telefono dello specialista -->
	</div>
	
	<!--<label>
	<span>Unita' Operativa</span> 
	<select name='unita_operativa'>
	<option value=''>-Scegliere-</option>
	<?php
	/*
	$sql="select * from unita_operative order by descrizione";	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$codice = $row["codice"];
		$descrizione = $row["descrizione"];	
		?>
		<option value='<?php echo $codice;?>'><?php echo $descrizione;?></option>
	<?php	
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
		$ci_medico = $row["ci_medico"];
		$codice = $row["codice"];
		$descrizione = $row["descrizione"];
		$tariffa_euro = $row["tariffa_euro"];		
		?>
		<option title='<?php echo $ci_medico;?>' value='<?php echo $id;?>'><?php echo "$descrizione - &euro;$tariffa_euro";?></option>
	<?php	
    }
	?>
	</select>

	
	<label>
	<span>Prestazione Sanitaria</span>
	<?php
	$sql = "select p.* from prestazioni as p, medici as m where p.ci_medico = m.ci " . 
		($ci_medico_flt != "" ? " AND m.ci = '$ci_medico_flt'" : "") .
		" order by p.descrizione;";
	?>
	<select name='prestazione' id='id_prestazione'>
	<option value=''>-Scegliere-</option>
	<?php	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$id = $row["id"];
		$ci_medico = $row["ci_medico"];
		$codice = $row["codice"];
		$descrizione = $row["descrizione"];
		$tariffa_euro = $row["tariffa_euro"];
		?>
		<option value='<?php echo $id;?>' <?php echo ($id==$prestazione?'selected':'');?>><?php echo "$descrizione - &euro;$tariffa_euro";?></option>
	<?php	
    }
	?>
	</select>
	</label>

	<!--
	<label>
	<span>Prenotazione Annullata</span>
	<select id='id_prenotazione_annullata' name='prenotazione_annullata'>
	<option value=''>--Scegliere--</option> 
	<option value='ANN1' <?php //echo ('ANN1'==$prenotazione_annullata?'selected':'');?>>Su richiesta del paziente</option>
	<option value='ANN2' <?php //echo ('ANN2'==$prenotazione_annullata?'selected':'');?>>Su richiesta dello specialista</option>
	<option value='ANN3' <?php //echo ('ANN3'==$prenotazione_annullata?'selected':'');?>>Altro</option>
	</select>
	</label>
	-->

	<label>
	<span>Note</span>
	<textarea id='id_note' name='note' rows='2' cols='100'><?php echo $note;?></textarea>
	</label>
	
	<!--<label>
	<h4><span>Codice Priorit&agrave;</span><br></h4>
	<select name='codice_priorita'>
	<option value=''>-Scegliere-</option>
	<option value='A'>A</option>
	<option value='B'>B</option>
	<option value='C'>C</option>
	<option value='D'>D</option>
	</select>	
	</label>-->
	
	<!-- <label>
	<span>Codice Priorità</span>
	<input id='id_codice_priorita' type='text' name='codice_priorita' value='<?php echo $codice_priorita;?>' size='2' maxlength='2'/>
	</label> -->
	
	<input id='_ins_flag' type='hidden' name='_insert_form' value='1'/>
	<input id='id_data_flt' type='hidden' name='data_flt' value='<?php echo $data_flt;?>'/>
	<input id='id_ci_medico_flt' type='hidden' name='ci_medico_flt' value='<?php echo $ci_medico_flt;?>'/>
	<input id='next' type='submit' value='Registra'/>
	</form>
	</div>
	
	<?php
	
	mysql_close();
}
// FINE INSERIMENTO DATI DELLA PRENOTAZIONE


// Esegue la validazione dei campi immessi dall'utente
function validate_form() {
	if(empty($_POST["paziente"]) or empty($_POST["specialista"]) or empty($_POST["data_prenotazione"]) or empty($_POST["ora_prenotazione"]))
	{
		?>
		<p id="error">I campi 'Data prenotazione', 'Ora prenotazione', 'Paziente' e 'Specialista' sono obbligatori!</p>
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

// Esegue la registrazione dei dati dell'esame paziente
function insert_form() { 
	connect_to_db();
	// Inizializza variabili con i valori forniti dall'utente
	$data_prenotazione = $_POST["data_prenotazione"];

	$ora_prenotazione = $_POST["ora_prenotazione"];
	list($hh, $mm, $ss) = split('[.:,]', $_POST['ora_prenotazione']);
	$ora_prenotazione = "$hh:$mm";
	
	$paziente = $_POST["paziente"];
	$specialista = $_POST["specialista"];

	$unita_operativa = $_POST["unitaoperativa"];
	$diagnosi = $_POST["diagnosi"];
	$prestazione = $_POST["prestazione"];
	$intervento = $_POST["intervento"];
	$prenotazione_annullata = $_POST["prenotazione_annullata"];

	$note = $_POST["note"];
	$codice_priorita = $_POST["codice_priorita"];
	
	// normalizza la data di prenotazione
	if ($data_prenotazione != '') { 
		list($dd, $mm, $yyyy) = split('[/.-]', $data_prenotazione);
		$data_prenotazione = $yyyy."-".$mm."-".$dd;
	}
	
	// costruisce la query per l'inserimento della prenotazione in archivio
	$sql = "insert into prenotazioni(id_paziente, codice_unita_operativa, codice_diagnosi, id_prestazione,  
				ci_medico, data_prenotazione, ora_prenotazione, note, codice_priorita, prenotazione_annullata) " .  
			"values($paziente, '$unita_operativa', '$diagnosi', '$prestazione', 
			'$specialista', '$data_prenotazione', '$ora_prenotazione', '$note', '$codice_priorita', '$prenotazione_annullata')";
	// DEBUG
	//print "$sql<br>"; exit();
	
	// registra la prenotazione in archivio
	mysql_query($sql) or die("Errore durante la registrazione della prenotazione!");

	print "<font face='Georgia' color='#0000ff'>";
	print "<b>La registrazione della prenotazione è stata eseguita con successo.</b>";
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
				show_insert_form();
			}
		}
		else {
			show_insert_form();
		}
		?>
	</div>
	
	<div id="footer">
		<?php if($_POST['_insert_form'] >= '1') {include("inc/footer.php");} ?>
	</div>	
</div>	
</body>
</html> 