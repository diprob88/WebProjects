<?php include("check.php");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<title>Gestione Medici Specialisti - Modifica dati</title>
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
  // Seleziona il database che contiene i medici
  @mysql_select_db($db) or die( "Errore durante la selezione del database!");
}

// Mostra la maschera per la modifica dei medici
function show_medici_form() {
	connect_to_db();
	$ci = $_GET["ci"];
	// estrae i dati completi dei medici
	$sql="select * from medici where ci = '$ci';";	
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$nominativo = $row["nominativo"];
	$specialita = $row["specialita"];
	$qualifica = $row["qualifica"];
	$locali_azienda = $row["locali_azienda"];
	$telefono = $row["telefono"];
	$priorita = $row["priorita"];
	$tipo_autorizzazione = $row["tipo_autorizzazione"];
	$email = $row["email"];
	
?>
	<h3>Modifica i dati del Medico Specialista:</h3>
	<h5>(I campi contrassegnati con * sono obbligatori)</h5>
	</div>
	<div>	
	<form method='post' action='<?php echo $_SERVER[PHP_SELF];?>'>
	<label>
	<span>Codice Individuale*</span>
	<input type='text' name='ci' value="<?php echo $ci;?>" size=10 maxlength=10 />
	</label>
	
	<label>
	<span>Nominativo*</span>
	<input type='text' name='nominativo' value='<?php echo $nominativo;?>' size=50 maxlength=50 />
	</label>

	<label>
	<span>Specialit&agrave;*<span>
	<select name="specialita">
	<option value="">--Scegliere--</option>
	<?php
	$sql = "select distinct specialita from medici;";
	$res = mysql_query($sql);
	while($row = mysql_fetch_array($res)) {
		$spec = $row["specialita"];
		?>
		<option value="<?php echo $spec;?>" <?php echo ($spec==$specialita?'selected':'');?>><?php echo $spec;?></option>
	<?php
	}
	?>
	</select>
	</label>	

	<label>
	<span>Qualifica<span>
	<select name="qualifica">
	<option value="">--Scegliere--</option>
	<option value="Dott." <?php echo ("Dott."==$qualifica?'selected':'');?>><?php echo "Dottore/Dottoressa";?></option>
	<option value="Prof." <?php echo ("Prof."==$qualifica?'selected':'');?>><?php echo "Professore/Professoressa";?></option>
	</select>
	</label>	

	<label>
	<span>Locali Azienda</span>
	<input type='text' name='locali_azienda' value='<?php echo $locali_azienda;?>' size=50 maxlength=150 />
	</label>

	<label>
	<span>Telefono</span>
	<input type='text' name='telefono' value='<?php echo $telefono;?>' size=25 maxlength=25 />
	</label>
	
	<label>
	<span>Priorit&agrave;</span>
	<input type='text' name='priorita' value='<?php echo $priorita;?>' size=5 maxlength=5 />
	</label>
	
	<label>
	<span>Tipo Autorizzazione*<span>
	<select name="tipo_autorizzazione">
	<option value="">--Scegliere--</option>
	<option value="Interna Azienda" <?php echo ("Interna Azienda"==$tipo_autorizzazione?'selected':'');?>><?php echo "Interna Azienda";?></option>
	<option value="Studio Privato" <?php echo ("Studio Privato"==$tipo_autorizzazione?'selected':'');?>><?php echo "Studio Privato";?></option>
	</select>
	</label>	
	
	<label>
	<span>Email</span>
	<input type='text' name='email' value='<?php echo $priorita;?>' size=25 maxlength=25 />
	</label>	

	<input type='hidden' name='_medici_form' value='1'/>
	<input type='hidden' name='id' value='<?php echo $id?>'/>
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
		Non e' stato specificato il codice individuale del medico!
		</font>		
		<?php
		return FALSE;
	}

	if(empty($_POST["nominativo"])) {
		?>
		<font face='Georgia' color='#ff0000'>		
		Non e' stato specificato il nominativo del medico!
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

// Modifica i dati del medico
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
	
	// Esegue la query di modifica
	$sql = "update medici set nominativo = '$nominativo', specialita='$specialita', qualifica='$qualifica', locali_azienda='$locali_azienda', 
			telefono='$telefono', priorita='$priorita', tipo_autorizzazione='$tipo_autorizzazione', email='$email'
			where ci='$ci'";
	mysql_query($sql) or die("Errore durante la modifica dei dati del medico!");
	print "<font face='Georgia' color='#0000ff'>";
	print "<b>La modifica è stata eseguita con successo.</b>";
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
