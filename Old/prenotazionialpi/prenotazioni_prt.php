<?php
$filename="prenotazioni.xls";
header ("Content-Type: application/vnd.ms-excel");
header ("Content-Disposition: inline; filename=$filename");
?>

<?php include("check.php");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Esporta le prenotazioni in formato Excel</title>
</head>
<body>
<?php
// Esegue la connessione al DB
function connect_to_db($db) {
  $user = "root";
  $passwd = "";
  // Si connette al server MySql
  mysql_connect(localhost,$user,$passwd);
  // Seleziona il database che contiene gli esami
  @mysql_select_db($db) or die( "Errore durante la selezione del database $db!");
}
	
// Mostra la maschera di selezione dell'operazione da effettuare sulle prenotazioni
function exp_prenotazioni() {
	// variabili di sessione
	$_nome = $_SESSION["_nome"];
	$_ruolo = $_SESSION["_ruolo"];
	$_codiceunitaoperativa = $_SESSION["_codiceunitaoperativa"];
	
	connect_to_db('prenotazionialpi');
	// Controlla se è stato immesso un filtro
	if(isset($_GET["filtro_dt"])) { // filtro sulla data di prenotazione (solo prenotazioni con data successiva)
		$filtro_dt = $_GET["filtro_dt"];
	}
	else {
		// il filtro di default sulla data, visualizza tutte le prenotazioni con data uguale o successiva a quella odierna
		$oggi = date('d-m-Y');
		$filtro_dt = $oggi;
	}
	if(isset($_GET["filtro_med"])) { // filtro sul nome del medico 
		$filtro_med = $_GET["filtro_med"];
	}
	else {
		$filtro_med = "*";
	}
	if(isset($_GET["filtro_an"])) { // filtro sul nome del paziente
		$filtro_an = $_GET["filtro_an"];
	}
	else {
		$filtro_an = "*";
	}
	// se l'utente è uno specialista viene attivato automaticamente un filtro che limita le prestazioni visualizzate solo a quelle di pertinenza dello specialista
	if($_ruolo == 'U') {
		$filtro_ci = $_nome;
	}
	else {
		$filtro_ci = "";
	}
	
	// estrae le prenotazioni per paziente - C.I. Medico - data prenotazione
	if($filtro_dt != '*') {
		$data_prenotazione = $filtro_dt;
		list($dd, $mm, $yyyy) = split('[/.-]',$data_prenotazione);	
		$data_prenotazione = "$yyyy-$mm-$dd";
	}
	else {
		$data_prenotazione = '%';
	}
	if($filtro_an != '*') {
		$cognome = $filtro_an . '%';
	}
	else {
		$cognome = '%';
	}
	if($filtro_med != '*') {
		$nominativo = $filtro_med . '%';
	}
	else {
		$nominativo = '%';
	}
	$sql = "select pre.id, paz.cognome, paz.nome, paz.datanascita, paz.telefono, med.ci, med.nominativo, med.specialita, pre.data_prenotazione, pre.ora_prenotazione, prenotazione_annullata
			from prenotazioni as pre, pazienti as paz, medici as med
			where pre.id_paziente = paz.id 
			and pre.ci_medico = med.ci
			and pre.data_prenotazione >= '$data_prenotazione'
			and med.nominativo like '$nominativo'
			and paz.cognome like '$cognome'" .
			($filtro_ci != ""?" and med.ci = $filtro_ci ":"") .
			" order by pre.data_prenotazione, pre.ora_prenotazione, med.nominativo, paz.cognome, paz.nome";
	
	//print "$sql<br>";
	?>
	<table name='elenco_prenotazioni' border="1">
	<?php
	$result = mysql_query($sql);
	while ($row = mysql_fetch_array($result)) {
		$id_prenotazione = $row["id"];
		$cognome = $row["cognome"];
		$nome = $row["nome"];
		$datanascita = $row["datanascita"];
		list($yyyy, $mm, $dd) = split('[/.-]',$datanascita);	
		$datanascita = "$dd-$mm-$yyyy";
		$telefono = $row["telefono"];
		
		$ci = $row["ci"];
		$nominativo = $row["nominativo"];
		$specialita = $row["specialita"];
		
		$data_prenotazione = $row["data_prenotazione"];
		list($yyyy, $mm, $dd) = split('[/.-]',$data_prenotazione);	
		$data_prenotazione = "$dd-$mm-$yyyy";	
		$ora_prenotazione = $row["ora_prenotazione"];
		list($hh, $mm, $ss) = split('[:.,]',$ora_prenotazione);	
		$ora_prenotazione = "$hh.$mm";	
		$prenotazione_annullata = $row["prenotazione_annullata"];
		?>
		<tr>
		<td><?php echo "$cognome";?></td>
		<td><?php echo "$nome";?></td>
		<td><?php echo "$datanascita";?></td>
		<td><?php echo "'$telefono";?></td>
		<td><?php echo "$ci - $nominativo - $specialita";?></td>
		<td><?php echo "$data_prenotazione";?></td>
		<td><?php echo "$ora_prenotazione";?></td>
		<td <?php echo (in_array($prenotazione_annullata, array('ANN1', 'ANN2', 'ANN3'))?"bgcolor='red'":"");?>><?php echo "$prenotazione_annullata";?></td>
		</tr>
		<?php	
		$i++;					
	}
	?>		
	</table>
	<?php
	mysql_close();
}
// MAIN
exp_prenotazioni();
//
?>
</body>
</html>
