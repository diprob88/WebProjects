<?php
session_start();

function login_form() {
?>
	<div>
	<form method='post' action='<?php $_SERVER[PHP_SELF];?>'>
	<h1>Login:</h1>
	<label>
	<span>User name</span>
	<input id="nome" type='text' name='nome' value="" size='25' maxlength='25' />
	</label>
	<label>
	<span>Password</span><br>
	<input id="password" type='password' name='password' value="" size='15' maxlength='15' />
	</label>
	<input type='submit' value='Login'/>
	<input type='hidden' name='_login_form' value='1'/>
<?php	
}

if(array_key_exists("_login_form",$_POST)) {
	// parametri per la connessione al db
	$user = "root";
	$passwd = "";
	$db = "prenotazionialpi";
	// Si connette al server MySql
	mysql_connect(localhost,$user,$passwd);
	// Seleziona il database che contiene le prenotazioni
	@mysql_select_db($db) or die( "Errore durante la selezione del database!");
	$ret = FALSE;
	// verifica se l'account esiste	
	$sql="select * from utenti where nome='".$_POST["nome"]."'";	
	$result = mysql_query($sql);
	if(mysql_num_rows($result)>0) {
		$row = mysql_fetch_array($result);
		$_nome = $row["nome"];
		$_ruolo = $row["ruolo"];
		$_codiceunitaoperativa = $row["codiceunitaoperativa"];
		$_password = $row["password"];
		// verifica la password
		$pwd_md5 = MD5($_POST["password"]);
		if( $_password == $pwd_md5 ) {
			// imposta le variabili di sessione
			session_register("_nome");
			session_register("_ruolo");
			session_register("_codiceunitaoperativa");
			$_SESSION['_nome']= $_nome;
			$_SESSION['_ruolo'] = $_ruolo;
			$_SESSION['_codiceunitaoperativa'] = $_codiceunitaoperativa;
			if($_ruolo == 'U') {
				// Schermata Utente
				print "<script language=javascript>document.location.href='home.php'</script>";	
			}
			elseif($_ruolo == 'P') {
				// Schermata Power User
				print "<script language=javascript>document.location.href='home.php'</script>";
			}
			elseif($_ruolo == 'A') {
				// Schermata Amministratore
				print "<script language=javascript>document.location.href='home.php'</script>";
			}
			
			elseif($_ruolo == 'C') {
				// Schermata per Prenotazioni
				print "<script language=javascript>document.location.href='home.php'</script>";
			}
			
			else {
				?>
				<font face='Georgia' color='#ff0000'>
				L'utente non ha un ruolo definito!
				</font>
				<?php
				session_unset();
				session_destroy();				
			}
		} 
		else {
			?>
			<font face='Georgia' color='#ff0000'>
			La password e' errata! Riprova o chiedi una nuova password <a href='mailto:l.anastasi@ao-ve.it?subject=richiesta password'>all'amministratore.</a>
			</font>
			<?php
			session_unset();
			session_destroy();
		}
	}
  else {
		?>
		<font face='Georgia' color='#ff0000'>
		Non esiste un account per l'utente specificato!
		</font>
		<?php
		session_unset();
		session_destroy();
	}
	mysql_close();
}
else {
// HTML ?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Login</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>

<div id="container">
	<div id="header">
		<?php include("inc/header.php"); ?>
	</div>
	
	<div id="sidebarleft">
		<?php include("inc/navigation.php"); ?>
	</div>	
		
	<div id="content">
		<?php
		// --- MAIN ---
		login_form();
		?>
	</div>
	
	<div id="footer">
		<?php include("inc/footer.php"); ?>
	</div>
</div>
</body>

</html>
<?php
} // End HTML
?>
