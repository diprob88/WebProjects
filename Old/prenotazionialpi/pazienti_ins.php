<?php include("check.php"); ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<title>Inserimento anagrafica Paziente</title>
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

// Mostra la maschera per l'inserimento dei pazienti
function show_pazienti_form() {
	connect_to_db();
	// la variabile 'pren_call' se passata in GET indica che la form di inserimento paziente è stata richiamata da una form di prenotazione
	// e pertanto al termine della registrazione la finestra di inserimento paziente deve essere chiusa in modo  che il controllo ritorni
	// alla finestra padre di inserimento della prenotazione
	if(isset($_GET['pren_call'])) {
		$pren_call = $_GET['pren_call'];
	}
	else {
		$pren_call = '0';
	}
	?>
	<div>
	<!--<div align="center">-->	
	<h2>Inserimento Pazienti:</h2>
	<h5>(I campi contrassegnati con * sono obbligatori)</h5>	
	</div>
	<form method="post" action="<?php $_SERVER[PHP_SELF];?>">
	<label>
	<span>Cognome*</span></td> 
	<input id="cognome" type="text" name="cognome" size=50 maxlenght="50"/>
	</label>

	<label>
	<span>Nome*</span>
	<input id="nome" type="text" name="nome" size=50 maxlenght=50 />
	</label>	
	
	<label>
	<span>Sesso*</span>
	<select id="sesso" name="sesso"/>
	<option value=""></option>
	<option value="F">Femmina</option>
	<option value="M">Maschio</option>
	</select>
	</label>
	
	<label>
	<span>Data di Nascita* (ggmmaaaa)</span>
	<input id="datanas" type="text" name="datanascita" size=10 maxlenght=10 />
	</label>
	
	<label>
	<span>Luogo di Nascita*<span>
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
		<option value="<?php echo $codice;?>"><?php echo "$descrizione - $provincia";?></option>
	<?php
	}
	?>
	</select>
	</label>
	
	<label>
	<span>Codice Fiscale*</span>
	<input id="codfis" type="text" name="codicefiscale" size=16 maxlenght=16/>
	</label>
	
	<label>
	<span>Citt&agrave; di Residenza<span>
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
		<option value="<?php echo $codice;?>"><?php echo "$descrizione - $provincia";?></option>
	<?php
	}
	?>
	</select>
	</label>
	
	<!--<label>
	<span>Citt&agrave; di Residenza</span>
	<input id="cittares" type="text" name="cittaresidenza" size=50 maxlenght=50/>
	</label>-->

	<label>
	<span>Via</span>
	<input id="viares" type="text" name="viaresidenza" size=50 maxlenght=50/>
	</label>
	
	<label>
	<span>Telefono*</span>
	<input id="tel" type="text" name="telefono" size=50 maxlenght=50/>
	</label>
	
	<!--<label>
	<span>Medico Curante</span>
	<td><input id="telmed" type="text" name="medico" size=25 maxlenght=25/></td>
	</label>
	
	<label>
	<span>Telefono Medico Curante</span>
	<td><input id="telmed" type="text" name="telefonomc" size=25 maxlenght=25/></td>
	</label>-->
	
	<label>
	<span>email</span>
	<input id="email" type="text" name="email" size=50 maxlenght=50/>
	</label>	

	<input type='hidden' name='_pazienti_form' value='1'/>
	<input type='hidden' name='pren_call' value='<?php echo $pren_call;?>'/>	
	<input type='submit' value='Registra'/>
	</form>
	</div>
	<?php
	mysql_close();
}

function validate_form() {
	if(empty($_POST["cognome"])) {
		?>
		<font face='Georgia' color='#ff0000'>
		Non e' stato specificato il cognome del paziente!
		</font>
		<?php
		return FALSE;
	}
	if(empty($_POST["nome"])) {
		?>
		<font face='Georgia' color='#ff0000'>
		Non e' stato specificato il nome del paziente!
		</font>
		<?php
		return FALSE;
	}
	if(empty($_POST["sesso"])) {
		?>
		<font face='Georgia' color='#ff0000'>		
		Non e' stato specificato il sesso del paziente!
		</font>
		<?php
		return FALSE;
	}	
	if(empty($_POST["datanascita"])) {
		?>
		<font face='Georgia' color='#ff0000'>		
		Non e' stata specificata la data di nascita del paziente!
		</font>
		<?php
		return FALSE;
	}
	if(empty($_POST["luogonascita"])) {
		?>
		<font face='Georgia' color='#ff0000'>				
		Non e' stato specificato il luogo di nascita del paziente!
		</font>
		<?php
		return FALSE;
	}
	if(empty($_POST["codicefiscale"])) {
		?>
		<font face='Georgia' color='#ff0000'>		
		Non e' stato specificato il codice fiscale del paziente!
		</font>
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
		<font face='Georgia' color='#ff0000'>				
		La data di nascita inserita non è valida!
		</font>
		<?php
		return FALSE;
	}
	else
	{
		return TRUE;
	}
	
	return TRUE;
}	  

// Registra il paziente
function exec_admin() { 
	connect_to_db();
	$cognome = strtoupper($_POST["cognome"]);
	$nome = strtoupper($_POST["nome"]);
	
	$datanascita = $_POST["datanascita"];
	list($dd, $mm, $yyyy) = split('[/.-]', $datanascita);
	$datanascita = $yyyy . "-" . $mm . "-" . $dd;
	
	$sesso = strtoupper($_POST["sesso"]);
	$codicefiscale = strtoupper($_POST["codicefiscale"]);
	$luogonascita = strtoupper($_POST["luogonascita"]);
	$viaresidenza = strtoupper($_POST["viaresidenza"]);
	$cittaresidenza = strtoupper($_POST["cittaresidenza"]);
	$telefono = $_POST["telefono"];
	$medico = $_POST["medico"];
	$telefonomc = $_POST["telefonomc"];
	$email = $_POST["email"];
	
	// registrazione dati esami
	$sql = "insert into pazienti(cognome, nome, datanascita, sesso, luogonascita, codicefiscale, viaresidenza, cittaresidenza, telefono, medico, telefonomc, email) values(";
	$sql.="'$cognome', '$nome', '$datanascita', '$sesso', '$luogonascita', '$codicefiscale', '$viaresidenza', '$cittaresidenza', '$telefono', '$medico', '$telefonomc', '$email')";
	mysql_query($sql) or die("Errore durante la registrazione del paziente! O il paziente è in archivio.");
	print "<font face='Georgia' color='#0000ff'>";
	print "<center><b>La registrazione è stata eseguita con successo.</b></center>";
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
				if($_POST['pren_call'] == '1') {
					?>
					<center><a href="javascript:window.close();">Ritorna alla prenotazione</a><center>
					<?php
					exit();
				}
				elseif($_POST['pren_call'] == '0') {
					print "<META HTTP-EQUIV='refresh' content='1; URL=pazienti.php'>";
					exit();
				}
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
