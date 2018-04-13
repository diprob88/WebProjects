<?php include("check.php");?>
<?php require("PHPMailerAutoload.php"); ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Invia le prenotazioni selezionate via email</title>
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
	
// Mostra la maschera di selezione delle prenotazioni da inviare
function sel_prenotazioni() {
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
	$sql = "select pre.id, paz.cognome, paz.nome, paz.datanascita, paz.telefono, med.ci, med.nominativo, med.specialita, med.tipo_autorizzazione, pre.data_prenotazione, pre.ora_prenotazione, prenotazione_annullata
			from prenotazioni as pre, pazienti as paz, medici as med
			where pre.id_paziente = paz.id 
			and pre.ci_medico = med.ci
			and pre.data_prenotazione >= '$data_prenotazione'
			and med.nominativo like '$nominativo'
			and paz.cognome like '$cognome'
			and pre.prenotazione_annullata = ''" .
			($filtro_ci != ""?" and med.ci = $filtro_ci ":"") .
			" order by med.nominativo, med.ci, pre.data_prenotazione, pre.ora_prenotazione, paz.cognome, paz.nome";
	
	//print "$sql<br>";
	?>
	<br><br><br>
	<form name="send_pren" method="post" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
	<table name='elenco_prenotazioni' style='background-color:aliceblue; border:1px solid blue;'>
	<thead><b>Mettere la spunta solo sulle prenotazioni che si desidera inviare via email allo specialista.</b></thead>
	<tr>
	<th>Cognome</th> <th>Nome</th> <th>Data nasc.</th> <th>Telefono</th> <th>Specialista</th> <th>Data prenotaz.</th> <th>Ora prenotaz.</th> <th>Invia</th>
	</tr>
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
		$tipo_autorizzazione = $row["tipo_autorizzazione"];
		?>
		<tr style="<?php echo ($tipo_autorizzazione=='Interna Azienda'?'background-color:paleturquoise':'background-color:beige');?>">
		<td><?php echo "$cognome";?></td>
		<td><?php echo "$nome";?></td>
		<td><?php echo "$datanascita";?></td>
		<td><?php echo "$telefono";?></td>
		<td><?php echo "$ci - $nominativo - $specialita";?></td>
		<td><?php echo "$data_prenotazione";?></td>
		<td><?php echo "$ora_prenotazione";?></td>
		<td><input type="checkbox" name="sel[]" value="<?php echo $id_prenotazione;?>" checked="checked"></td>		
		</tr>
		<?php	
		$i++;					
	}
	?>		
	</table>
	<br>
	<input type='hidden' name='_send_mail' value=1>
	<input type="submit" value="Invia email">
	</form>
	
	<br><a href='home.php'>&lt;&lt; Torna alla Home Page</a>
	<?php
	mysql_close();
}

// invia le prenotazioni selezionate via mail agli specialisti
function send_prenotazioni() {
	connect_to_db("prenotazionialpi");
	$sel = $_POST["sel"];
	// costruisce una stringa separata da virgole che contiene tutti gli id delle prenotazioni selezionate dal prenotatore e da inviare via email
	$id_sel = implode(",", $sel);
	// costruisce la query per l'estrazione dal DB delle prenotazioni da inviare via email
	$sql = "select pre.id, paz.cognome, paz.nome, paz.datanascita, paz.telefono, med.ci, med.nominativo, med.specialita, med.tipo_autorizzazione, med.email, pre.data_prenotazione, pre.ora_prenotazione, prenotazione_annullata
	from prenotazioni as pre, pazienti as paz, medici as med
	where pre.id_paziente = paz.id
	and pre.ci_medico = med.ci
	and prenotazione_annullata = ''
	and pre.id in ($id_sel) 
	order by med.nominativo, med.ci, pre.data_prenotazione, pre.ora_prenotazione, paz.cognome, paz.nome";
	
	// ciclo per la costruzione della mail per ogni singolo specialista ed il relativo inoltro
	$old_ci = ""; $old_nominativo = "";
	$res = mysql_query($sql);
	while($row=mysql_fetch_array($res)) {
		$cognome = $row["cognome"];
		$nome = $row["nome"];
		$datanascita = $row["datanascita"];
		$telefono = $row["telefono"];
		$ci = $row["ci"];
		$nominativo = $row["nominativo"];
		$specialita = $row["specialita"];
		$data_prenotazione = $row["data_prenotazione"];
		$ora_prenotazione = $row["ora_prenotazione"];
		$lista_prenotazioni[$ci] .= "$cognome\t$nome\t$datanascita\t$telefono\t$data_prenotazione\t$ora_prenotazione\n";
		if($old_ci != $ci) {
			// il record appena letto si riferisce ad un altro specialista; pertanto occorre provvedere all'inoltro dei dati 
			// delle prenotazioni fin qui recuperati, al precedente specialista
			$mail = new PHPMailer();
			$mail->IsSMTP();                // set mailer to use SMTP
			$mail->Host = "mail.ao-ve.it";  // specify main and backup server
			$mail->SMTPAuth = true;     // turn on SMTP authentication
			$mail->Username = "";  // SMTP username
			$mail->Password = ""; // SMTP password
			$mail->From = "f.bentivegna@ao-ve.it";
			$mail->FromName = "Sig. Francesco Bentivegna";
			$mail->AddAddress("lodovico65@gmail.com", "Ing. Lorenzo Anastasi");
			$mail->WordWrap = 50;                                 // set word wrap to 50 characters
			$mail->AddAttachment();         // add attachments
			$mail->IsHTML(true);                                  // set email format to HTML
			$mail->Subject = "Prenotazioni in Intramoenia";
			$mail->Body    = $lista_prenotazioni[$old_ci];
			$mail->AltBody = "";
			if(!$mail->Send())
			{
			   echo "Il messaggio a '$old_ci - $old_nominativo' non può essere inviato. ";
			   echo "Si è verificato l'errore: " . $mail->ErrorInfo . " <br>";
			   exit;
			}
			echo "Il messaggio a '$old_ci $old_nominativo' è stato inviato!<br>";
			$old_ci = $ci; $old_nominativo = $nominativo;
		}
	}
	//print_r($lista_prenotazioni);
}

?>
<div id="container">
	<div id="header">
		<?php include("inc/header.php"); ?>
	</div>
	
	<div id="sidebarleft">
		<?php 
		//$_selected = ""; // serve ad evidenziare la voce di menù corrente
		//include("inc/navigation.php"); 
		?>
	</div>	
		
	<div id="content">
		<?php
		// --- MAIN ---
		if($_POST["_send_mail"]==1) {
			send_prenotazioni();
			exit();
		}
		sel_prenotazioni();
		?>
	</div>
	<div id="footer">
		<?php //include("inc/footer.php"); ?>
	</div>	
</div>
</body>
</html>
