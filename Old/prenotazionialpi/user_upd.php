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
  // Seleziona il database che contiene le delibere
  @mysql_select_db($db) or die( "Errore durante la selezione del database!");
}

// Mostra la maschera per la modifica dell'utente
function show_user_form() {
	// variabili di sessione
	$_nome = $_SESSION["_nome"];
	$_ruolo = $_SESSION["_ruolo"];
	$_codiceunitaoperativa = $_SESSION["_codiceunitaoperativa"];
	connect_to_db();
	$nome = $_GET["nome"];
	// estrae i dati completi dell'utente
	$sql = "select * from utenti where nome='".$nome."'";	
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$password = $row["password"];
	$ruolo = $row["ruolo"];
	$codiceunitaoperativa1 = $row["codiceunitaoperativa"];
	$email = $row["email"];
	// estrae i dati completi delle unità operative
	connect_to_db();
	$sql2 = "select * from unitaoperativa order by unitaoperativa ";	
	$result2 = mysql_query($sql2);
	//$row2 = mysql_fetch_array($result2);
	?>
	<h3>Modifica Utente:</h3>
	<h5>(I campi contrassegnati con * sono obbligatori)</h5>	
	</div>
	<div>
	<form method='post' action='<?php echo $_SERVER[PHP_SELF];?>'>
	<label>
	<span>Utente*</span>
	<input type='text' name='nome' value="<?php echo $nome;?>" size=25 maxlength=25 disabled />
	</label>
	
	<label>
	<span>Password*</span><br>
	<input type='password' name='password' value='********' size=25 maxlength=25 />
	</label><br>
	
	<label>
	<span>Ruolo*</span>
	<select name="ruolo">
	<?php if($_ruolo=='A') { ?> <option value="A" <?php echo ($ruolo=='A'?'selected':'');?>>Amministratore</option> <?php } ?>
	<?php if($_ruolo=='A') { ?> <option value="P" <?php echo ($ruolo=='P'?'selected':'');?>>Utente per prenotazioni</option> <?php } ?>
	<option value="U" <?php echo ($ruolo=='U'?'selected':'');?>>Specialista</option>
	</select> 
	</label>
	
	<!--
	<label>
	<span>Unit&agrave; Operativa</span>
	<select name="codiceunitaoperativa">
	<option value="">Selezionare l'unit&agrave; operativa</option>		
	<?php
	/*
	$sql="select * from unitaoperativa order by unitaoperativa";
	while($row2 = mysql_fetch_array($result2)) {
		$codiceunitaoperativa = $row2["codiceunitaoperativa"];
		$unitaoperativa = $row2["unitaoperativa"];		
		?>
		<option value="<?php echo $codiceunitaoperativa;?>" <?php echo ($codiceunitaoperativa==$codiceunitaoperativa1?'selected':'');?>><?php echo $unitaoperativa;?></option>
		<?php
	}
	*/
	?>	
	</select>
	</label>
	-->
	
	<label>
	<span>E-mail</span>
	<input type='text' name='email' value='<?php echo $email;?>' size=40 maxlength=40 />
	</label>
	
	<input type='hidden' name='_user_form' value='1'/>
	<input type='hidden' name='id' value='<?php echo $id?>;'/>
	<input type='hidden' name='_old_passwd' value='<?php echo $password;?>'/>		
	<input type='hidden' name='_nome' value='<?php echo $nome;?>'/>	
	<input type='submit' value='Registra'/>	
	</form>	
	</div>
	<?php
	mysql_close();
}

function validate_form() {
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

// Modifica i dati dell'utente
function exec_admin() { 
	connect_to_db();
	$nome = $_POST["_nome"];
	$email = $_POST["email"];
	$password = $_POST["password"];
	$old_passwd = $_POST["_old_passwd"];
	$ruolo = $_POST["ruolo"];
	$codiceunitaoperativa=$_POST["codiceunitaoperativa"];
	if($codiceunitaoperativa=='') {
		$codiceunitaoperativa='%';
	}	
	// Esegue la query di modifica
	if($password != "********") {
	  // la password è stata cambiata
		$pwd_md5 = MD5($password);
	}
	else {
	  // la password non è stata cambiata
		$pwd_md5 = $old_passwd;
	}
	$sql = "update utenti set password='$pwd_md5',ruolo='$ruolo',codiceunitaoperativa='$codiceunitaoperativa',email='$email' ";
	$sql.="where nome='$nome'";
	//print $sql; exit();
	mysql_query($sql) or die("Errore durante la modifica dei dati dell'utente!");
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
