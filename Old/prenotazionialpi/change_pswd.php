<?php include("check.php");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<title>Prenotazioni</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<?php
// estrae il nome utente registrato come variabile di sessione   
$_nome = $_SESSION["_nome"];
if(array_key_exists("_exec",$_POST)) {
	// parametri per la connessione al db
	$user = "root";
	$passwd = "";
	$db = "prenotazionialpi";
	// Si connette al server MySql
	mysql_connect(localhost,$user,$passwd);
	// Seleziona il database che contiene le delibere
	@mysql_select_db($db) or die( "Errore durante la selezione del database!");

	// estrae i dati dell'utente dal db
	$sql="select * from utenti where nome = '$_nome'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$_nome = $row["nome"];
	$_password = $row["password"];
	// effettua le validazioni necessarie prima della modifica
	$old_pass = $_POST["old_pass"];
	$new_pass = $_POST["new_pass"];
	$conf_pass = $_POST["conf_pass"];
	if( MD5($old_pass) != $_password ) {
		?>
		<div id="error"><p>Devi inserire la vecchia password prima di poterla modificare!</p></div>
		<META HTTP-EQUIV='refresh' content='2; URL=change_pswd.php'>
		<?php
		exit();
	}
	if( strlen($new_pass) < 8 ) {
		?>
		<div id="error"><p>La password deve contenere almeno 8 caratteri!</p></div>
		<META HTTP-EQUIV='refresh' content='2; URL=change_pswd.php'>
		<?php
		exit();
	}	
	if( $new_pass != $conf_pass ) {
		?>
		<div id="error"><p>Devi confermare correttamente la nuova password!</p></div>
		<META HTTP-EQUIV='refresh' content='2; URL=change_pswd.php'>
		<?php
		exit();
	}
	$md5_passwd = MD5($new_pass);
	$sql="update utenti set password='$md5_passwd' where nome='$_nome'";	
	mysql_query($sql) or die("Errore durante la modifica della password");
	mysql_close();
	?>
	<div id="ok"><p>Password modificata correttamente!</p></div>
	<META HTTP-EQUIV='refresh' content='2; URL=home.php'>
	<?php
}
else {
// HTML ?>
<div id="container">
	<div id="header">
		<?php include("inc/header.php"); ?>
	</div>
	
	<div id="sidebarleft">
		<?php 
		$_selected = "change_pswd"; // serve ad evidenziare la voce di menù corrente
		include("inc/navigation.php"); 
		?>
	</div>	
		
	<div id="content">
		<h3><span>Modifica Password:</span></h3>
		<h5>(I campi contrassegnati con * sono obbligatori)</h5>
		</div></h2>
		<div>
		<form method='post' action='<?php echo $_SERVER[PHP_SELF];?>'>
		<label>
		<big><span>Utente:&nbsp;</big></span> 
		<big><b><?php echo $_nome;?></big></b>
		</label><br><br>

		<label>
		<span>Vecchia password*</span><br>
		<input type='password' name='old_pass' value=''size=25 maxlength=25/></td>
		</label><br>

		<label>
		<span>Nuova password*</span><br>
		<input type='password' name='new_pass' value=''size=25 maxlength=25/></td>
		</label><br>

		<label>
		<span>Conferma password*</span><br>
		<input type='password' name='conf_pass' value=''size=25 maxlength=25/></td>
		</label>

		<input type='submit' value='Modifica'/>
		<input type='hidden' name='_exec' value='1'/>
		</form>
		</div>
	</div>
	
	<div id="footer">
		<?php include("inc/footer.php"); ?>
	</div>
	
</div>	

</body>
</html>
<?php  
}
?>

