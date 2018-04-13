<?php include("check.php"); print"<u><big>Utente: $_nome - $_ruolo - $_codiceunitaoperativa<br>";?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<font color="#ff6666"><big><title>Amministrazione Utenti - Inserimento</title>
<link rel="stylesheet" type="text/css" href="css/stile.css" />
<div align="center">
	<a href="http://www.policlinicovittorioemanuele.it/" target="_blank"><img
		alt="Azienda Policlinico"
		src="http://10.5.0.254/esami/images/logo.jpg" border="0"
		height="100" width="135"></a>
</head>
<body>
<?php
// Esegue la connessione al DB
function connect_to_db() {
  $user = "root";
  $passwd = "";
  $db = "esami";
  // Si connette al server MySql
  mysql_connect(localhost,$user,$passwd);
  // Seleziona il database che contiene gli esami
  @mysql_select_db($db) or die( "Errore durante la selezione del database!");
}

// Mostra la maschera per l'inserimento dell'utente
function show_user_form() {
	connect_to_db();
	print "<form method='post' action='$_SERVER[PHP_SELF]'>";
	print "<font face='Georgia'>";
	print "<b>Amministrazione - Inserimento Utenti:</b><br /><br /><br />";
	print "Utente: <input type='text' name='nome' size='29' maxlenght='25'/><br><br>";
	print "Password: <input type='password' name='password' size='25' maxlenght='25'/><br><br>";
	print "Ruolo (U=Utente/P=Power User/A=Amministratore): <input type='text' name='ruolo' size='1' maxlenght='1'/><br><br>";
	print "E-mail: <input type='text' name='email' size='40' maxlenght='40'/><br><br>";
	// costruisce l'interrogazione per estrarre le unità operative
	$sql="select * from unitaoperativa order by unitaoperativa";	
	// estrae le unità operative 
	$result = mysql_query($sql);
	// crea il pull-down menù
	print "&nbsp;&nbsp;Settore (se non specificato, l'utente è abilitato su tutte): <select name='codiceunitaoperativa'><br>";
	print "<option value='' selected>-Scegliere-"; 	
	while ($row = mysql_fetch_array($result)) {
		$codiceunitaoperativa = $row["codiceunitaoperativa"];
		$unitaoperativa = $row["unitaoperativa"];
		print "<option value='$codiceunitaoperativa'>$unitaoperativa"; 
  } 	
	print "</select>";
	print "<br /><br />";
	print "<input type='hidden' name='_user_form' value='1'/>";
	print "<input type='submit' value='Registra'/>";
	print "<br /><br /><a href='user.php'>&lt;&lt;Indietro</a>";	
	print "</form>";
	mysql_close();
}

function validate_form() {
  print "<font face='Georgia' color='#ff0000'>";
	if(empty($_POST["nome"])) {
	  print "<b>Non e' stato specificato il nome utente!</b><br />";
  	print "</font>";
		return FALSE;
	}
	if(empty($_POST["password"])) {
	  print "<b>Non e' stata specificata la password!</b><br />";
  	print "</font>";
		return FALSE;
	}
	else {
	  if(strlen($_POST["password"]) < 8) {
		print "<b>La password deve essere di almeno 8 caratteri!</b><br />";
		print "</font>";
		return FALSE;
		}
	}
	if(empty($_POST["ruolo"])) {
		print "<b>Non e' stato specificato il ruolo!</b><br />";
		print "</font>";
		return FALSE;
	}
	if(strtoupper($_POST["ruolo"]) == "U") {
		if(empty($_POST["codiceunitaoperativa"])) {
			print "<b>Non è stata specificate l'unità operativa!</b><br />";
			print "</font>";
			return FALSE;
			
		}
		
	}
  return TRUE;
}	  

// Registra l'utente
function exec_admin() { 
  connect_to_db();
	$nome = $_POST["nome"];
	$email = $_POST["email"];
	$password = $_POST["password"];
	$ruolo = strtoupper($_POST["ruolo"]); // converte il carattere che indica il ruolo (U o A o P) in maiuscolo
	$codiceunitaoperativa = $_POST["codiceunitaoperativa"];
	if($codiceunitaoperativa=='') {
		$codiceunitaoperativa='%';
	}
	// registrazione dati utente
	$pwd_md5 = MD5($password); // hash password
	$sql = "insert into utenti(nome,password,ruolo,codiceunitaoperativa,email) values(";
	$sql.="'$nome','$pwd_md5','$ruolo','$codiceunitaoperativa','$email')";
	mysql_query($sql) or die("Errore durante la registrazione dell'utente!");
	print "<font face='Georgia' color='#0000ff'>";
	print "<b>La registrazione è stata eseguita con successo.</b>";
	print "</font>";	
	mysql_close();	
}

//include("inc/header.inc");

//include("inc/navigation.inc"); 
?>

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

</body>
</html>
