<?php include("check.php");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<title>Prenotazioni</title>
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

// Mostra la maschera per l'inserimento dell'utente
function show_user_form() {
	// variabili di sessione
	$_nome = $_SESSION["_nome"];
	$_ruolo = $_SESSION["_ruolo"];
	$_codiceunitaoperativa = $_SESSION["_codiceunitaoperativa"];
	connect_to_db();
	// estrae i dati completi delle unità operative
	$sql2 = "select * from unitaoperativa order by unitaoperativa";	
	$result2 = mysql_query($sql2);
	
?>
	<h2>Inserimento Utenti:</h2>
	<h5>(I campi contrassegnati con * sono obbligatori)</h5>
	</div>
	<div>  
	<form method="post" action="<?php echo $_SERVER[PHP_SELF];?>">  
	<label>
	<span>Utente*</span>
	<input type="text" name="nome" size=25 maxlength=25/></td>
	</label>

	<label>
	<span>Password*<span><br>
	<input type="password" name="password" size=25 maxlength=25/></td>  
	</label><br>

	<label>
	<span>Ruolo*</span>
	<select name="ruolo">
	<option value="">Selezionare il ruolo</option>	
	<?php if($_ruolo=='A') { ?> <option value="A">Amministratore</option> <?php } ?>
	<?php if($_ruolo=='A') { ?> <option value="P">Utente per prenotazioni</option> <?php } ?>
	<option value="U">Specialista</option>
	</select> 
	</label>

	<!--
	<label>
	<span>Unit&agrave; Operativa<span>
	<select name="codiceunitaoperativa">
	<option value="">Selezionare l'unit&agrave; operativa</option>	
	<?php
	/*
	$sql="select * from unitaoperativa order by unitaoperativa";	
	while($row2 = mysql_fetch_array($result2)) {
		$codiceunitaoperativa = $row2["codiceunitaoperativa"];
		$unitaoperativa = $row2["unitaoperativa"];		
		?>
		<option value="<?php echo $codiceunitaoperativa;?>"><?php echo $unitaoperativa;?></option>
		<?php
	}
	*/
	?>	
	</select>
	</label>
	-->
	
	<label>
	<span>E-mail<span>
	<input type="text" name="email" size=40 maxlength=40/></td>  
	</label>
	<input type='hidden' name='_user_form' value='1'/>
	<input type='submit' value='Registra'/>
	</form>
	</div>
<?php
	mysql_close();
}
function validate_form() {
	if(empty($_POST["nome"])) {
		?>
		<p id="error">Non e' stato specificato il nome utente!</p>
		<?php
		return FALSE;
	}
	if(empty($_POST["password"])) {
		?>
		<p id="error">Non e' stata specificata la password dell'utente!</p>
		<?php
		return FALSE;
	}
	if(empty($_POST["ruolo"])) {
		?>
		<p id="error">Non e' stato specificata il ruolo dell'utente!</p>
		<?php
		return FALSE;
	}
	return TRUE;
}

// Registra l'utente
function exec_admin() { 
	connect_to_db();
	$nome = $_POST["nome"];
	$email = $_POST["email"];
	$password = $_POST["password"];
	$ruolo = strtoupper($_POST["ruolo"]); // converte il carattere che indica il ruolo (U o A o P o C) in maiuscolo
	$codiceunitaoperativa = $_POST["codiceunitaoperativa"];
	if($codiceunitaoperativa=='') {
		$codiceunitaoperativa='%';
	}
	// registrazione dati utente
	$pwd_md5 = MD5($password); // hash password
	$sql = "insert into utenti(nome,password,ruolo,codiceunitaoperativa,email) values(";
	$sql.="'$nome','$pwd_md5','$ruolo','$codiceunitaoperativa','$email')";
	//print $sql; exit();
	mysql_query($sql) or die("Errore durante la registrazione dell'utente!");
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
		$_selected = "user"; // serve ad evidenziare la voce di menù corrente
		include("inc/navigation.php"); 
		?>
	</div>	
		
	<div id="content">
		<?php
		// --- MAIN ---
		if(array_key_exists("_user_form",$_POST)) {
			if(validate_form()) {
				exec_admin();
				print "<META HTTP-EQUIV='refresh' content='1; URL=user.php'>";
				exit();
			}
		}
		show_user_form();
		?>
	</div>
	
	<div id="footer">
		<?php include("inc/footer.php"); ?>
	</div>	
</div>
</body>
</html>
