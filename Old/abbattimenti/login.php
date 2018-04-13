<?php
session_start();

if(array_key_exists("_login_form",$_POST)) 
{
	// parametri per la connessione al db
	$user = "root";
	$passwd = "";
	$db = "abbattimenti";
	// Si connette al server MySql
	mysql_connect(localhost,$user,$passwd);
	// Seleziona il database che contiene gli esami
	@mysql_select_db($db) or die( "Errore durante la selezione del database!");
	$ret = FALSE;
	// verifica se l'account esiste	
	$sql="select * from utenti where nome='".$_POST["nome"]."'";	
	$result = mysql_query($sql);
	if(mysql_num_rows($result)>0) {
		$row = mysql_fetch_array($result);
		$_nome = $row["nome"];
		$_ruolo = $row["ruolo"];
		$_codazienda = $row["codazienda"];
		$_codpresidio = $row["codpresidio"];
		$_password = $row["password"];
		// verifica la password
		$pwd_md5 = MD5($_POST["password"]);
		if( $_password == $pwd_md5 ) {
			// imposta le variabili di sessione
			session_register("_nome");
			session_register("_ruolo");
			session_register("_codazienda");
			session_register("_codpresidio");
			$_SESSION['_nome']= $_nome;
			$_SESSION['_ruolo'] = $_ruolo;
			$_SESSION['_codazienda'] = $_codazienda;
			$_SESSION['_codpresidio'] = $_codpresidio;
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
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel="shortcut icon" href="./assets/img/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap-theme.css">
<script type="text/javascript" src="./assets/js/jquery-1.11.3.js"></script>
<script type="text/javascript" src="./assets/js/bootstrap.js"></script>
<link rel="stylesheet" type="text/css" href="./assets/css/mycss.css" />
</head>
<body>



<div class="container-fluid">
	<header>
		<?php include("./assets/php/header.php");?>
	</header>
<br><br><br>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">

  			<div class="panel panel-primary">
  				<div class="panel-heading">
  					<h2 class="text-center">Inserisci i dati di Accesso</h2>
  				</div>
  				<div class="panel-body">
  					<form class="form-signin form-horizontal" method='post' action='<?php $_SERVER['PHP_SELF'];?>'>
        				<div class="form-group">
      						<label class="col-sm-2 control-label col-sm-offset-2">Username</label>
      						<div class="col-sm-4">
         						<input type="text" class="form-control" name="nome" maxlength='25' placeholder="Username">
      						</div>
   						</div>
   						<div class="form-group">
      						<label class="col-sm-2 control-label col-sm-offset-2">Password</label>
      						<div class="col-sm-4">
         						<input type="password" class="form-control" name="password" maxlength='15' placeholder="Password">
      						</div>
   						</div>
   						<div class="form-group">
      						<div class="col-sm-offset-4 col-sm-4">
        						<button class="btn btn-lg btn-primary btn-block" type="submit">Accedi</button>
        					</div>
        				</div>
        				<input type='hidden' name='_login_form' value='1'/>

      				</form>
      			</div>
  			</div>
  		<!-- questo div sotto chiude md6-->
  		</div>
  		 <!-- questo div sotto chiude row-->
  	</div>
  	
</div>
<br><br><br>

	<footer>
		<?php include("./assets/php/footer.php");?>
	</footer>

</body>
<?php
} // 
?>
</html>

