<?php include("check.php");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
<title>Calendario Prenotazioni</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
$(document).ready(function(){
	$("#show_tip").mouseover(function() {
		$("#info").show(); 
	});
	$("#show_tip").mouseout(function() {
		$("#info").hide(); 
	});
	$("a.no_disp").click(function() {
		var r = confirm("Vuoi segnalare la NON DISPONIBILITA' per il giorno in oggetto?");
		if(r == true) {
			var data = $(this).siblings().eq(0).val();
			var ci = $(this).siblings().eq(1).val();
			var that = $(this);
			$.post("no_disp.php", {no_disp_data:data, no_disp_ci:ci}, function(value){
				alert("La data " + data + " e' stata marcata come NON DISPONIBILE per lo specialista con C.I. pari a " + ci);
				that.closest("td").css("background-color", "red");
			});
		}
	});
});
</script>
</head>
<body>
<script>
function mostra_dettaglio(dettaglio, datacal, cimedico) {
	var i;
	var num_pre = 0;
	var ans;
	var msg = "";
	var items = dettaglio.split(";");
	for(i=0; i<items.length; i++) {
		if(items[i] != "") {
			msg += items[i] + "\n";
			num_pre++;
		}
	}
	if(num_pre>0) {
		var ans = confirm("Sono presenti le seguenti prenotazioni:\n" + msg + "Vuoi inserirne una nuova?");	
	}
	else {
		var ans = confirm("Non sono presenti prenotazioni:\n" + msg + "Vuoi inserirne una?");	
	}
	if(ans) {
		window.location = "prenotazioni_ins.php?data_flt=" + datacal + "&ci_medico_flt=" + cimedico;
	}
	return;
}
</script>

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

// Permette la selezione dello specialista di cui sviluppare il calendario delle prenotazioni
function sel_specialista() {
	connect_to_db();
	// ricava il mese e l'anno correnti ovvero quelli proposti di default all'operatore per lo sviluppo del calendario
	$mese_corr = date('m');
	$anno_corr = date('Y');
	
	// variabili di filtro passate in POST per restringere il campo di ricerca dello specialista
	$specialita_flt = $_POST['specialita'];
	$prestazione_flt = $_POST['prestazione'];
?>	
	<br><br><br>
	<form name='filtro' method='POST' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
	<table name='filtro_specialista' style='background-color:aliceblue; border:1px solid blue;'>
	<thead><b>Immettere i filtri per restringere il campo di ricerca dello specialista</b></thead>
	<!-- FILTRO SULLA SPECIALITA' -->
	<tr>
	<td>Specialit&agrave;</td> 
	<td>
	<select name='specialita' onchange="form.submit();">
	<option value=''>-Scegliere-</option>
	<?php	
	$sql = "select distinct specialita from medici;";
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$specialita = $row["specialita"];			
		?>
		<option value='<?php echo $specialita;?>' <?php echo ($specialita==$specialita_flt?'selected':'');?>><?php echo "$specialita";?></option>
	<?php	
    }
	?>
	</select>
	</td>
	</tr>
	<!-- FILTRO SULLE PRESTAZIONI -->	
	<tr>
	<td>Prestazioni erogate</td> 
	<td>
	<select name='prestazione'>
	<option value=''>-Scegliere-</option>
	<?php	
	$sql = "select p.*, m.nominativo from prestazioni as p, medici as m where p.ci_medico = m.ci " .
		($specialita_flt != "" ? " AND m.specialita = '$specialita_flt'" : "") .
		" order by p.descrizione;";
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$id = $row["id"];
		$codice = $row["codice"];
		$descrizione = $row["descrizione"];
		$tariffa_euro = $row["tariffa_euro"];
		$nominativo = substr($row["nominativo"], 0, 10);
		?>
		<option value='<?php echo $id;?>' <?php echo ($id==$prestazione_flt?'selected':'');?>><?php echo substr("$codice - $descrizione - ($nominativo) - &euro;$tariffa_euro", 0, 150);?></option>
	<?php	
    }
	?>
	</select>
	</td>
	</tr>

	<tr>
	<td><input type='submit' value='Filtra'/></td>
	<td>&nbsp;</td>
	</tr>	
	</table>
	</form>
	
	<form name='sel_specialista' method='POST' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
	<table name='sel_specialista' style='background-color:lavender; border:1px solid blue'>
	<thead><b>Selezionare lo specialista di cui sviluppare il calendario delle prenotazioni</b></thead>
	<tr>
	<td>Specialista</td> 
	<td>
	<?php	
	$sql = "select distinct m.* from medici as m, prestazioni as p where m.ci = p.ci_medico  " . 
		($specialita_flt != "" ? " AND m.specialita = '$specialita_flt'" : "") .
		($prestazione_flt != "" ? " AND p.id = '$prestazione_flt'" : "") .
		" order by m.nominativo;";
	//print "$sql";
	?>
	<select name='specialista'>
	<option value=''>-Scegliere-</option>
	<?php	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$ci = $row["ci"];
		$nominativo = $row["nominativo"];	
		$specialita = $row["specialita"];	
		$tipo_autorizzazione = $row["tipo_autorizzazione"];		
		?>
		<option value='<?php echo $ci;?>' style="<?php echo ($tipo_autorizzazione=='Interna Azienda'?'background-color:paleturquoise':'background-color:beige');?>"><?php echo "$ci - $nominativo - $specialita";?></option>
	<?php	
    }
	?>
	</select>
	</td>
	</tr>

	<tr>
	<td>Mese da sviluppare</td>
	<td>
	<select name='mese'>
	<option value='01' <?php echo ($mese_corr=='01'?'selected':'');?> >Gennaio</option>
	<option value='02' <?php echo ($mese_corr=='02'?'selected':'');?> >Febbraio</option>
	<option value='03' <?php echo ($mese_corr=='03'?'selected':'');?> >Marzo</option>
	<option value='04' <?php echo ($mese_corr=='04'?'selected':'');?> >Aprile</option>
	<option value='05' <?php echo ($mese_corr=='05'?'selected':'');?> >Maggio</option>
	<option value='06' <?php echo ($mese_corr=='06'?'selected':'');?> >Giugno</option>
	<option value='07' <?php echo ($mese_corr=='07'?'selected':'');?> >Luglio</option>
	<option value='08' <?php echo ($mese_corr=='08'?'selected':'');?> >Agosto</option>
	<option value='09' <?php echo ($mese_corr=='09'?'selected':'');?> >Settembre</option>
	<option value='10' <?php echo ($mese_corr=='10'?'selected':'');?> >Ottobre</option>
	<option value='11' <?php echo ($mese_corr=='11'?'selected':'');?> >Novembre</option>
	<option value='12' <?php echo ($mese_corr=='12'?'selected':'');?> >Dicembre</option>
	</select>
	</td>
	</tr>
	
	<tr>
	<td><input type='submit' value='Calendario'/></td>
	<td>&nbsp;</td>
	</tr>	
	</table>
	<br><br><a href='home.php'>&lt;&lt; Torna alla Home Page</a>
	<input type='hidden' name='anno' value='<?php echo $anno_corr;?>' />	
	<input type='hidden' name='_calendario_form' value='1'/>	
	</form>
<?php	
}


// Mostra il calendario dello specialista precedentemente selezionato, con il numero delle prenotazioni per ogni giorno del mese
function aggiorna_calendario() {
	connect_to_db();
	// variabili di sessione
	$_nome = $_SESSION["_nome"];
	$_ruolo = $_SESSION["_ruolo"];
	$_codiceunitaoperativa = $_SESSION["_codiceunitaoperativa"];
	
	// codice individuale del medico di cui sviluppare il calendario
	if($_ruolo == "U") {
		$ci_medico = intval($_nome);
	}
	else {
		$ci_medico = $_POST['specialista'];
	}
	// ricava il nominativo dello specialista di cui si sviluppa il calendario
	$sql = "select * from medici where ci = '$ci_medico'";
	$result = mysql_query($sql);	
	$row = mysql_fetch_array($result);
	$nominativo = $row['nominativo'];
	$locali_azienda = $row['locali_azienda'];
	$telefono = $row['telefono'];
	
	// ricava i giorni di ricevimento dello specialista di cui sviluppare il calendario
	$sql = "select * from agende where ci = '$ci_medico'";
	$result = mysql_query($sql);	
	$row = mysql_fetch_array($result);
	$wd = array('dom', 'lun', 'mar', 'mer', 'gio', 'ven', 'sab');
	$gg_ricevimento[0] = $row['giorno1']; $fascia[0][1] = substr($row["fascia1_1"], 0, -3); $fascia[0][2] = substr($row["fascia1_2"], 0, -3); $fascia[0][3] = substr($row["fascia1_3"], 0, -3); $fascia[0][4] = substr($row["fascia1_4"], 0, -3); 	
	$gg_ricevimento[1] = $row['giorno2']; $fascia[1][1] = substr($row["fascia2_1"], 0, -3); $fascia[1][2] = substr($row["fascia2_2"], 0, -3); $fascia[1][3] = substr($row["fascia2_3"], 0, -3); $fascia[1][4] = substr($row["fascia2_4"], 0, -3);	
	$gg_ricevimento[2] = $row['giorno3']; $fascia[2][1] = substr($row["fascia3_1"], 0, -3); $fascia[2][2] = substr($row["fascia3_2"], 0, -3); $fascia[2][3] = substr($row["fascia3_3"], 0, -3); $fascia[2][4] = substr($row["fascia3_4"], 0, -3);	
	$gg_ricevimento[3] = $row['giorno4']; $fascia[3][1] = substr($row["fascia4_1"], 0, -3); $fascia[3][2] = substr($row["fascia4_2"], 0, -3); $fascia[3][3] = substr($row["fascia4_3"], 0, -3); $fascia[3][4] = substr($row["fascia4_4"], 0, -3);	
	$gg_ricevimento[4] = $row['giorno5']; $fascia[4][1] = substr($row["fascia5_1"], 0, -3); $fascia[4][2] = substr($row["fascia5_2"], 0, -3); $fascia[4][3] = substr($row["fascia5_3"], 0, -3); $fascia[4][4] = substr($row["fascia5_4"], 0, -3);	
	$gg_ricevimento[5] = $row['giorno6']; $fascia[5][1] = substr($row["fascia6_1"], 0, -3); $fascia[5][2] = substr($row["fascia6_2"], 0, -3); $fascia[5][3] = substr($row["fascia6_3"], 0, -3); $fascia[5][4] = substr($row["fascia6_4"], 0, -3);		
	
	?>
	<div align="center">
	<h1><font color=BROWN>Calendario Prenotazioni</font></h1>
	<h2><?php echo $nominativo;?></h2> <a id="show_tip" href='#'><img src='images/info.png'></a>
	<div id='info' style="display:none">
		<?php echo "Riceve presso: $locali_azienda<br>Telefono: $telefono<br>";?>
	</div>
	</div align="center">
	<?php

	// ricava la data a partire dalla quale costruire il calendario
	$mese_desc = array('Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre');
	if(isset($_POST['mese'])) {
		$mese_numero = $_POST['mese'];
		$anno = $_POST['anno'];
		if($mese_numero==0) {
			$mese_numero = 12;
			$anno = $anno - 1;	
		}
		if($mese_numero==13) {
			$mese_numero = 1;
			$anno = $anno + 1;		
		}	
	}
	else {
		$mese_numero = date('m');
		$anno = date('Y');
	}
	$inizio_mese_tstamp = mktime(0, 0, 0, $mese_numero, 1, $anno); 	

	// ricava la data di inizio mese in formato array
	$inizio_mese_array = getdate($inizio_mese_tstamp);
	//print "Data di inizio mese: {$inizio_mese_array['year']}-{$inizio_mese_array['mon']}-{$inizio_mese_array['mday']}<br>"; // DEBUG

	// ricava la data del primo Lunedì antecedente la data di inizio mese
	$giorno_settimana_ini = $inizio_mese_array['wday'];
	$sub = $giorno_settimana_ini - 1;
	//print "Valore da sottrarre per ottenere la data del Luned&igrave; precedente: $sub<br>"; // DEBUG

	$primo_lunedi_tstamp = mktime(0, 0, 0, $mese_numero, 1 - $sub, $anno);
	$primo_lunedi_array = getdate($primo_lunedi_tstamp);
	//print "Data Luned&igrave; precedente: {$primo_lunedi_array['year']}-{$primo_lunedi_array['mon']}-{$primo_lunedi_array['mday']}<br>"; // DEBUG
	$data_print = $primo_lunedi_tstamp;
	?>

	<div align="center">
	<table border=0 name='bottoni'>
	<tr>
	<td>
	<form name='mese-1' method='POST' action='calendariopren.php'>
	<input type='hidden' name='mese' value='<?php echo ($mese_numero-1);?>'>
	<input type='hidden' name='anno' value='<?php echo ($anno);?>'>
	<input type='hidden' name='specialista' value='<?php echo $ci_medico;?>'>
	<input type='hidden' name='_calendario_form' value='1'>
	<input type='submit' name='mese-1' value='<<Indietro'>
	</form>
	</td>
	<td>
	<form name='mese1' method='POST' action='calendariopren.php'>
	<input type='hidden' name='mese' value='<?php echo ($mese_numero+1);?>'>
	<input type='hidden' name='anno' value='<?php echo ($anno);?>'>
	<input type='hidden' name='specialista' value='<?php echo $ci_medico;?>'>
	<input type='hidden' name='_calendario_form' value='1'>
	<input type='submit' name='mese1' value='Avanti>>'><br>
	</form>
	</td>	
	</tr>
	</table>

	<table width="800" height="400" border=1 name='calendario'>
	<caption><h3><font color=BROWN><?php echo $mese_desc[$mese_numero-1] . "/" . $anno;?></caption>
	<tr>
	<th><font color=BROWN>Luned&igrave;</th> <th><font color=BROWN>Marted&igrave;</th> <th><font color=BROWN>Mercoled&igrave;</th> <th><font color=BROWN>Gioved&igrave;</th> <th><font color=BROWN>Venerd&igrave;</th> <th><font color=BROWN>Sabato</th> <th><font color=BROWN>Domenica</th>
	</tr>

	<?php 
	for($i=1; $i<=5; $i++) {
	?>
	<tr>
		<?php 
		for($j=1; $j<=7; $j++) {
			$dettaglio = "";
			$mm = date('m', $data_print); // ricava il mese della data da stampare sul calendario
			$gg = date('d', $data_print); // ricava il giorno della data da stampare sul calendario
			$aaaa = date('Y', $data_print); // ricava l'anno della data da stampare sul calendario
			$week_day = $wd[date('w', $data_print)]; // ricava il giorno della settimana
			// costruisce la data e la query per determinare il numero e il dettaglio delle prenotazioni per lo specialista in esame
			$data_cur = "$aaaa-$mm-$gg";
			$sql = "select paz.cognome, paz.nome, paz.datanascita, pre.ora_prenotazione 
					from prenotazioni as pre, pazienti as paz
					where pre.data_prenotazione = '$data_cur'
					and pre.ci_medico = '$ci_medico'
					and paz.id = pre.id_paziente
					and pre.prenotazione_annullata not in ('ANN1','ANN2','ANN3')
					order by pre.ora_prenotazione, paz.cognome, paz.nome;";
			//print "$sql";
			$result = mysql_query($sql);
			// ricava il numero delle prenotazioni per la data in esame
			$num_prenotazioni = mysql_num_rows($result);
			// ricava il dettaglio (cognome, nome, ora prenotazione) delle prenotazioni
			if($num_prenotazioni > 0) {
				while($row = mysql_fetch_array($result)) {
					$cognome = $row['cognome'];
					$nome = $row['nome'];
					$ora_prenotazione = $row['ora_prenotazione'];
					// costruisce un array che contiene il dettaglio delle prenotazioni 
					$dettaglio .= "$cognome $nome - $ora_prenotazione;";
				}
			}
			// Stampa le date sul calendario evidenziando il mese corrente:
			// 	le caselle che rappresentano possibili giorni di ricevimento sono in 
			//	VERDE se sul giorno non insiste nessuna prenotazione
			// 	ARANCIO se sul giorno insiste già almeno una prenotazione
			//  ROSSO se lo specialista risulta non disponibile per quella data
			?>		
			<td style="background-color:
				<?php
				if($mm!=$mese_numero) {
					echo 'BEIGE';
				}
				else {
					if(in_array($week_day, $gg_ricevimento)) {
						// Se si tratta di un giorno di ricevimento allora si deve verificare 
						// se per la data in oggetto, lo specialista ha già segnalato una indisponibilità
						$sql1 = "select * from date_no_disp where data = '$data_cur' and ci_medico = '$ci_medico';";
						$res1 = mysql_query($sql1);
						$no_disp = mysql_num_rows($res1);
						// se per il giorno in esame lo specialista non è disponibile, il giorno viene marcato in rosso
						if($no_disp>0) {
							echo 'RED';
						}
						else {
							if($num_prenotazioni == 0) {
								echo 'MEDIUMSEAGREEN';
							}
							else {
								echo 'DARKORANGE';
							}
						}
					}
					else {
						echo 'BISQUE';
					}
				}
				?>
			">
				<?php
				if($_ruolo=="U") { 
					// il ruolo U è quello attribuito agli specialisti che usano l'applicazione solo per visualizzare le 
					// prenotazioni e per segnalare eventuali indisponibilità
					if( ($mm==$mese_numero) && (in_array($week_day, $gg_ricevimento))) {
						// se si tratta di un giorno di ricevimento
						if($no_disp>0) {
							// lo specialista può segnalare il giorno come non disponibile
							echo("<b>$gg</b>&nbsp;");				
						}
						else { // $no_disp=0
							// lo specialista può all'occorrenza marcare il giorno come NON DISPONIBILE escludendolo da quelli prenotabili
							echo "<input type='hidden' class='data' value='$data_cur'>";
							echo "<input type='hidden' class='ci' value='$ci_medico'>";
							echo("<b>$gg</b>&nbsp;" . "<a style='text-decoration:none;' href='#' class='no_disp'>" .
											($num_prenotazioni>0?"":'-') .
										"</a>"
							);
						}
					}
					else {
						echo("<b>$gg</b>&nbsp;");				
					}				
				}
				else
				{
					// gli altri ruoli, ovvero A (Amministratore) e P (Prenotatatore), hanno la gestione completa delle prenotazioni
					if( ($mm==$mese_numero) && (in_array($week_day, $gg_ricevimento))) {
						// se si tratta di un giorno di ricevimento
						if($no_disp>0) {
							// se il giorno in oggetto risulta tra quelli segnalati come non disponibili dallo specialista
							// allora il prenotatore non può inserire alcuna prenotazione sul giorno
							echo("<b>$gg</b>&nbsp;");				
						}
						else { // $no_disp=0
							// se il giorno in oggetto risulta tra quelli per cui lo specialista garantisce la disponibilità
							// allora il prenotatore può aggiungere una prenotazione sul giorno
							echo("<small>" . $fascia[array_search($week_day, $gg_ricevimento)][1] . " - " . $fascia[array_search($week_day, $gg_ricevimento)][2] . "</small><br>" . 					
								"<b>$gg</b>&nbsp;" . "<a style='text-decoration:none;' href='#' id='num_pre' onclick='mostra_dettaglio(\"$dettaglio\",\"$data_cur\",\"$ci_medico\");'>" .
											($num_prenotazioni>0?"($num_prenotazioni)":'+') .
										"</a>" . "<br>" .
								"<small>" . $fascia[array_search($week_day, $gg_ricevimento)][3] . " - " . $fascia[array_search($week_day, $gg_ricevimento)][4]	. "</small>"	
							);
						}
					}
					else {
						echo("<b>$gg</b>&nbsp;");				
					}
				}
				?>
			</td> 
			<?php 		
			// somma un giorno alla data per prepararsi alla prossima iterazione
			$data_print = strtotime('+1 days', $data_print);
		}
		?>
	</tr>
	<?php 		
	}
	?>
	</table>
	<br><a href='home.php'>&lt;&lt; Torna alla Home Page</a>

	<?php 		
}
?>
<div id="container">
	<div id="header">
		<?php include("inc/header.php"); ?>
	</div>
	
	<div id="sidebarleft">
		<?php 
		// serve ad evidenziare la voce di menù corrente
		//$_selected = "calendariopren"; 
		//include("inc/navigation.php"); ?>
	</div>	
		
	<div id="content">
		<?php
		$_ruolo = $_SESSION["_ruolo"];
		$_nome = $_SESSION["_nome"];
		$_codiceunitaoperativa = $_SESSION["_codiceunitaoperativa"];
		// se l'utente è uno specialista che accede per consultare le proprie prenotazioni e visualizzare il proprio calendario
		// allora deve saltare la fase di selezione dello specialista
		if($_ruolo == "U") {
			aggiorna_calendario();
		}
		else { // se l'utente è un prenotatore allora deve mostrare il riquadro di selezione dello specialista
			if($_POST['_calendario_form']=='1') {
				aggiorna_calendario();
			}
			else {
				sel_specialista();
			}	
		}
		?>
	</div>
	
	<div id="footer">
		<?php //include("inc/footer.php"); ?>
	</div>	
</div>	
</body>
</html> 