<?php include("check.php");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Gestione Prenotazioni</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<link href="CalendarControl.css" rel="stylesheet" type="text/css">
<script src="CalendarControl.js" language="javascript"></script>
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
	
// Mostra la maschera di selezione dell'operazione da effettuare sulle prenotazioni
function show_prenotazioni_form() {
	// variabili di sessione
	$_nome = $_SESSION["_nome"];
	$_ruolo = $_SESSION["_ruolo"];
	$_codiceunitaoperativa = $_SESSION["_codiceunitaoperativa"];
	connect_to_db();
	// Controlla se è stato immesso un filtro
	if(isset($_POST["filtro_dt"])) { // filtro sulla data di prenotazione (solo prenotazioni con data successiva)
		$filtro_dt = $_POST["filtro_dt"];
	}
	else {
		// il filtro di default sulla data, visualizza tutte le prenotazioni con data uguale o successiva a quella odierna
		$oggi = date('d-m-Y');
		$filtro_dt = $oggi;
	}
	if(isset($_POST["filtro_med"])) { // filtro sul nome del medico 
		$filtro_med = $_POST["filtro_med"];
	}
	else {
		$filtro_med = "*";
	}
	if(isset($_POST["filtro_an"])) { // filtro sul nome del paziente
		$filtro_an = $_POST["filtro_an"];
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
	?>
	<div>
	<h2>Elenco Prenotazioni:</h2>
	</div>
	<div>
	<form method='post' action='<?php echo $_SERVER[PHP_SELF];?>'>
	Filtro (Data Prenotazione >): 	<input type='text' onfocus='showCalendarControl(this);' name='filtro_dt' value='<?php echo $filtro_dt;?>' size=10 maxlength=10 />
	Filtro (Medico =): <input type='text' name='filtro_med' value='<?php echo $filtro_med;?>' maxlength=50 />
	Filtro (Paziente =): <input type='text' name='filtro_an' value='<?php echo $filtro_an;?>' maxlength=25 />	
	<input type='submit' value='Filtra'/>
	</form>
	</div>	
	<br>
	<?php	
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
	$result = mysql_query($sql);
	?>
	<!--<a href='prenotazioni_ins.php' style="visibility:<?php echo ($_ruolo=='U'?'hidden':'visible');?>"><img src='images/add-file-icon.png' alt='Crea nuovo' style="float:left;"></a>-->	
	<a href="prenotazioni_prt.php?filtro_dt=<?php echo $filtro_dt;?>&filtro_med=<?php echo $filtro_med;?>&filtro_an=<?php echo $filtro_an;?>&filtro_ci=<?php echo $filtro_ci;?>"><img src='images/excel.png' alt='Esporta in XLS'></a>	
	<a href="prenotazioni_send.php?filtro_dt=<?php echo $filtro_dt;?>&filtro_med=<?php echo $filtro_med;?>&filtro_an=<?php echo $filtro_an;?>&filtro_ci=<?php echo $filtro_ci;?>"><img src='images/email.png' alt='Invia prenotazioni via email'></a>	
	<div id="table_scroll">
	<table>
	<tr>
	<th></th>
	<th bgcolor='#6495ED'><small>Cognome</small></th>
	<th bgcolor='#6495ED'><small>Nome</small></th>
	<th bgcolor='#6495ED'><small>Data di Nascita</small></th>
	<th bgcolor='#6495ED'><small>Telefono</small></th> 
	<th bgcolor='#6495ED'><small>Specialista</small></th>
	<th bgcolor='#6495ED'><small>Data Prenotazione</small></th>	
	<th bgcolor='#6495ED'><small>Ora Prenotazione</small></th>
	<th bgcolor='#6495ED'><small>Pren. Ann.</small></th>
	</tr>
	<?php
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
		$prenotazione_annullata = $row["prenotazione_annullata"];
		?>
		<tr>
		<td bgcolor='#d3d3d3'><a href="prenotazioni_upd.php?id_prenotazione=<?php echo $id_prenotazione;?>" style="visibility:<?php echo ($_ruolo=='U'?'hidden':'visible');?>"><div align='center'><img src='images/edit-icon.png' alt='Modifica'></div></a></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><small><?php echo $cognome;?></small></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><small><?php echo $nome;?></small></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><small><?php echo $datanascita;?></small></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><small><?php echo $telefono;?></small></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><small><small><?php echo "$ci - $nominativo - $specialita";?></small></small></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><small><?php echo $data_prenotazione;?></small></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><small><?php echo $ora_prenotazione;?></small></td>
		<!--<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><small><?php echo $prenotazione_annullata;?></small></td> -->
		<td <?php echo (in_array($prenotazione_annullata, array('ANN1', 'ANN2', 'ANN3'))?"bgcolor='red'":($i%2==0?"bgcolor='lightsteelblue'":"bgcolor='lavender'"));?>><small><?php echo $prenotazione_annullata;?></small></td>
		</tr>
		<?php	
		$i++;					
	?>
		
	<?php	
	}
	?>		
	</table>
	</div>
	<?php
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
		include("inc/navigation.php");
		?>
	</div>	
		
	<div id="content">
		<?php
		// --- MAIN ---
		show_prenotazioni_form();
		?>
	</div>	

	<div id="footer">
		<?php include("inc/footer.php"); ?>
	</div>	
</div>
</body>
</html>
