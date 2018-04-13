<?php include("check.php");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>calendario pre-ricoveri</title>
<!-- link rel="stylesheet" type="text/css" href="css/style.css" /-->
</head>
<body>
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

function show_calendario_form() {
	// MAIN
	connect_to_db();

	?>
	<br>
	<div align="center">
	<h1><font color=DARKBLUE>Calendario Pre-Ricoveri</h1>
	</div align="center">
	<?php	
	// variabili di sessione
	$_nome = $_SESSION["_nome"];
	$_ruolo = $_SESSION["_ruolo"];
	$_codiceunitaoperativa = $_SESSION["_codiceunitaoperativa"];

	// ricava la data a partire dalla quale costruire il calendario
	$mese_desc = array('Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre');
	if(isset($_POST['_mese'])) {
		$mese_numero = $_POST['_mese'];
		$anno = $_POST['_anno'];
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
	print "Data di inizio mese: {$inizio_mese_array['year']}-{$inizio_mese_array['mon']}-{$inizio_mese_array['mday']}<br>"; // DEBUG

	// ricava la data del primo Lunedì antecedente la data di inizio mese
	$giorno_settimana_ini = $inizio_mese_array['wday'];
	$sub = $giorno_settimana_ini - 1;
	print "Valore da sottrarre per ottenere la data del Luned&igrave; precedente: $sub<br>"; // DEBUG

	$primo_lunedi_tstamp = mktime(0, 0, 0, $mese_numero, 1 - $sub, $anno);
	$primo_lunedi_array = getdate($primo_lunedi_tstamp);
	print "Data Luned&igrave; precedente: {$primo_lunedi_array['year']}-{$primo_lunedi_array['mon']}-{$primo_lunedi_array['mday']}<br>"; // DEBUG
	$data_print = $primo_lunedi_tstamp;

	?>
	<div align="center">

	<table name='bottoni' border=0>
	<tr>
	<td>
	<form name='mese-1' method='POST' action='calendario.php'>
	<input type='hidden' name='_mese' value='<?php echo ($mese_numero-1);?>'>
	<input type='hidden' name='_anno' value='<?php echo ($anno);?>'>
	<input type='submit' name='mese-1' value='<<Indietro'>
	</form>
	</td>
	<td>
	<form name='mese1' method='POST' action='calendario.php'>
	<input type='hidden' name='_mese' value='<?php echo ($mese_numero+1);?>'>
	<input type='hidden' name='_anno' value='<?php echo ($anno);?>'>
	<input type='submit' name='mese1' value='Avanti>>'><br>
	</form>
	</td>
	</tr>
	</table>

	<table name='calendario' width="800" height="400" border=1>
	<caption><h3><font color=NAVY><?php echo $mese_desc[$mese_numero-1] . "/" . $anno;?></caption>
	<tr>
	<th><font color=NAVY>Luned&igrave;</th> <th><font color=NAVY>Marted&igrave;</th> <th><font color=NAVY>Mercoled&igrave;</th> <th><font color=NAVY>Gioved&igrave;</th> <th><font color=NAVY>Venerd&igrave;</th> <th><font color=NAVY>Sabato</th> <th><font color=NAVY>Domenica</th>
	</tr>

	<?php 
	for($i=1; $i<=5; $i++) {
	?>
	<tr>
		<?php 
		for($j=1; $j<=7; $j++) {
			$mm = date('m', $data_print); // ricava il mese della data da stampare sul calendario
			$gg = date('d', $data_print); // ricava il giorno della data da stampare sul calendario
			$aaaa = date('Y', $data_print); // ricava l'anno della data da stampare sul calendario
			// costruisce la data per determinare il numero dei prericoveri
			$data_cur = "$aaaa-$mm-$gg";
			$sql = "select count(distinct id_pazienti) as num_prericoveri 
			from esami_pazienti 
			where datarichiesta = '$data_cur' 
			and codiceunitoperativa like '$_codiceunitaoperativa';";
			//echo $sql; exit();
			$result = mysql_query($sql);
			if($row = mysql_fetch_array($result)) {
				$num_prericoveri = $row['num_prericoveri'];
			}
			else {
				$num_prericoveri = 0;
			}
			// stampa la data sul calendario evidenziando il mese corrente
			?>		
			<td bgcolor="<?php echo($mm==$mese_numero?'LIGHTSTEELBLUE':'SKYBLUE');?>"><font color=INDIGO>&nbsp;&nbsp;&nbsp;<?php echo ("$gg " . ($num_prericoveri!=0?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<big><b><font color=MIDNIGHTBLUE>(' . $num_prericoveri. ')':''));?></td> 
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
<br>
<br>
<h3><a href="esamipazienti.php"> << Indietro</a></h3>
</br>
</br>
</div>
</body>
</html>
	
<?php
} // fine della funzione per la visualizzazione del calendario

show_calendario_form();

?>

</body>
</html>
