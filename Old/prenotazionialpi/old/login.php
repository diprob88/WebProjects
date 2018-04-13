<?php
session_start();
if(array_key_exists("_login_form",$_POST)) {
	// parametri per la connessione al db
	$user = "root";
	$passwd = "";
	$db = "esami";
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
				// Schermata Amministratore
				print "<script language=javascript>document.location.href='power.php'</script>";
			}
			elseif($_ruolo == 'A') {
				// Schermata Amministratore
				print "<script language=javascript>document.location.href='amministrazione.php'</script>";
			}
			else {
				print "<table ".
				  "style='position: absolute;top:40%;left:40%;background-color:lightsteelblue;border:1px solid darkblue;'>";
				print "<tr><th>Login:</th></tr>";
				print "<tr><td align='center'>";
				print "L'utente non ha un ruolo definito!<br />";
				print "</td></tr>";
				print "</table>";			  
				session_unset();
				session_destroy();				
			}
		} 
		else {
			print "<table ".
			  "style='position: absolute;top:30%;left:30%;background-color:lightsteelblue;border:1px solid darkblue;'>";
			print "<tr><th>Login:</th></tr>";
			print "<tr><td align='center'>";
			print "La password e' errata!<br />";
			print "<a href='login.php'>Riprova</a><br />";
			print "o chiedi una nuova password ";
			print "<a href='mailto:l.anastasi@ao-ve.it?subject=richiesta password'>all'amministratore.</a>";
			print "</td></tr>";
			print "</table>";			  
			session_unset();
			session_destroy();
		}
	}
  else {
			print "<table ".
			  "style='position: absolute;top:40%;left:40%;background-color:lightsteelblue;border:1px solid darkblue;'>";
			print "<tr><th>Login:</th></tr>";
			print "<tr><td align='center'>";
			print "Non esiste un account<br />";
			print "per l'utente specificato!";
			print "</td></tr>";
			print "</table>";			  
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
<link rel="stylesheet" type="text/css" href="css/stile.css" />
</head>
<?php //include("inc/header.inc"); ?>
<body>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>home</title>
  </head>
  <body>
	<br>
	<div align="center"><big><BIG><a href='http://localhost/direzionemedicaove/'><font color="#800080"></a></big></big></div>
	<br>
    <div align="center">
	<a href="http://www.policlinicovittorioemanuele.it/" target="_blank"><img
		alt="Azienda Policlinico"
		src="http://10.5.0.254/esami/images/logo.jpg" border="0"
		height="150" width="220"></a>
        <br>
        <font color="#6633ff"><i>Azienda Ospedaliero - Universitaria
            "Policlinico - Vittorio Emanuele"</i><i><br>
          </i></font><u><font color="#6633ff">Catania</font><br>
          <br>
          <font color="#330099">DIREZIONE MEDICA <br>
            PRESIDIO VITTORIO EMANUELE</font><br>
			<br>
			<div align="center"><font color="#ff6666"><big><big>SERVIZIO DI PRE-RICOVERO
                </big></big></big></font><br>
      <font color="#cc33cc"><u><big>COMMA 18 Art. 1 Legge 662 del 23.12.96</big></u></font><br>
    </div>	
	<div align="center">
<form method='post' action= <?php $_SERVER[PHP_SELF] ?> >
<table>
<tr><th align="center" colspan="2"><font color="#A52A2A"><big><big><u>Login:</th> </tr>
<br>
<tr>
<td><font color="#A52A2A"><u><big><big>User name:&nbsp;&nbsp;</td>
<td><input type='text' align='middle' name='nome' size='10' maxlength='25'/></td>
</tr>
<tr>
<td><font color="#A52A2A"><u><big><big>Password:&nbsp;&nbsp;</td>
<td><input type='password' align='middle' name='password' size='10' maxlength='25'/></td>
</tr>
<tr><td align="center"  colspan="2"><input type='submit' value='Login'/></td></tr>
</table><br><br>
<div align="center"><big><big><big><a href='http://localhost/direzionemedicaove/'><font color="#800080"></a></big></div>
<input type='hidden' name='_login_form' value='1'/>
<br>
<a href="http://10.5.0.254/download/guidaprericovero.pdf" target="_blank"><b><li>Guida all'utilizzo dell'Applicativo</b></i></a><br><br></li>
<div align="center">info<br><br>
<div align="center">Tel. - 2958<br><br>
<div align="center">Email - f.bentivegna@ao-ve.it<br>
</form>
</body>
</html>
<?php
} // End HTML

?>
