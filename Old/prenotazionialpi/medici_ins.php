<?php include("check.php");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<title>Gestione Medici Specialiasti - Inserimento</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
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

// Mostra la maschera per l'inserimento degli esami
function show_medici_form() {
	connect_to_db();
	
	?>
	<h2>Inserimento Medici Specialisti:</h2>
	<h5>(I campi contrassegnati con * sono obbligatori)</h5>
	<div>
	<form method="post" action="<?php echo $_SERVER[PHP_SELF];?>">
	<label>
	<span>Codice Individuale*<span>
	<input type="text" name="ci" size=10 maxlenght=10/></td>
	</label>

	<label>
	<span>Nominativo*<span>
	<input type="text" name="nominativo" size=50 maxlength=50/></td>
	</label>
	
	<label>
	<span>Specialit&agrave;*<span>
	<select name="specialita">
	<option value="">--Scegliere--</option>	
	<?php
	$sql = "select distinct specialita from medici;";
	$res = mysql_query($sql);
	while($row = mysql_fetch_array($res)) {
		$specialita = $row["specialita"];
		?>
		<option value="<?php echo $specialita;?>"><?php echo $specialita;?></option>
	<?php
	}
	?>
	</select>
	</label>	
	
	<label>
	<span>Qualifica<span>
	<select name="qualifica">
	<option value="">--Scegliere--</option>	
	<option value="Dott.">Dottore/Dottoressa</option>
	<option value="Prof.">Professore/Professoressa</option>
	</select>
	</label>	
	
	<label>
	<span>Locali Azienda<span>
	<input type="text" name="locali_azienda" size=50 maxlength=150/></td>
	</label>

	<label>
	<span>Telefono<span>
	<input type="text" name="telefono" size=50 maxlength=50/></td>
	</label>

	<label>
	<span>Priorit&agrave;<span>
	<input type="text" name="priorita" size=5 maxlength=5/></td>
	</label>

	<label>
	<span>Tipo Autorizzazione*<span>
	<select name="tipo_autorizzazione">
	<option value="">--Scegliere--</option>	
	<option value="Interna Azienda">Interna Azienda</option>
	<option value="Studio Privato">Studio Privato</option>
	</select>
	</label>	
	
	<label>
	<span>email<span>
	<input type="text" name="email" size=25 maxlength=25/></td>
	</label>
	
	<input type='hidden' name='_medici_form' value='1'/>
	<input type='submit' value='Registra'/>
	</form>
	</div>
<?php
	mysql_close();
}

function validate_form() {
	if(empty($_POST["ci"])) {
		?>
		<font face='Georgia' color='#ff0000'>
		Non e' stato specificato il Codice Individuale del medico!
		</font>
		<?php
		return FALSE;
	}
	if(empty($_POST["nominativo"])) {
		?>
		<font face='Georgia' color='#ff0000'>
		Non e' stata specificato il nominativo del medico!
		</font>
		<?php
		return FALSE;
	}
	
	if(empty($_POST["specialita"])) {
		?>
		<font face='Georgia' color='#ff0000'>
		Non e' stata specificata la specialit&agrave; del medico!
		</font>
		<?php
		return FALSE;
	}

	if(empty($_POST["tipo_autorizzazione"])) {
		?>
		<font face='Georgia' color='#ff0000'>
		Non e' stata specificato il tipo di autorizzazione interna/esterna del medico!
		</font>
		<?php
		return FALSE;
	}
	
	return TRUE;
}	  

// Registra il medico
function exec_admin() { 
	connect_to_db();
	$ci = $_POST["ci"];
	$nominativo = $_POST["nominativo"];
	$specialita = $_POST["specialita"];	
	$qualifica = $_POST["qualifica"];
	$locali_azienda = $_POST["locali_azienda"];	
	$telefono = $_POST["telefono"];	
	$priorita = $_POST["priorita"];	
	$tipo_autorizzazione = $_POST["tipo_autorizzazione"];	
	$email = $_POST["email"];	
		
	// registrazione dati del medico
	$sql = "insert into medici(ci, nominativo, specialita, qualifica, locali_azienda, telefono, priorita, tipo_autorizzazione, email) 
			values('$ci', '$nominativo', '$specialita', '$qualifica', '$locali_azienda', 
					'$telefono', '$priorita', '$tipo_autorizzazione', '$email')";
	mysql_query($sql) or die("Errore durante la registrazione dei dati del medico!");
	print "<font face='Georgia' color='#0000ff'>";
	print "<b>La registrazione è stata eseguita con successo.</b>";
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
		$_selected = "medici"; // serve ad evidenziare la voce di menù corrente
		include("inc/navigation.php"); 
		?>
	</div>	
		
	<div id="content">
		<?php
		// --- MAIN ---
		if(array_key_exists("_medici_form",$_POST)) {
			if(validate_form()) {
				exec_admin();
				print "<META HTTP-EQUIV='refresh' content='1; URL=medici.php'>";
				exit();
			}
		}
		show_medici_form();
		?>
	</div>
	
	<div id="footer">
		<?php include("inc/footer.php"); ?>
	</div>	

</div>
</body>
</html>
