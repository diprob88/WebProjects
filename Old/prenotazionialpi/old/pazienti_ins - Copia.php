<?php include("check.php"); print"<u><big>Utente: $_nome - $_ruolo - $_codiceunitaoperativa<br></big></u>";?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<link rel="stylesheet" type="text/css" href="css/stile.css" />
</head>
<body>
<div align="center">
	<a href="http://www.policlinicovittorioemanuele.it/" target="_blank"><img
		alt="Azienda Policlinico"
		src="http://10.5.0.254/esami/images/logo.jpg" border="0"
		height="100" width="135"></a>
	<font color="#7B68EE">
	<h1>Amministrazione Pazienti - Inserimento</h1>
	</font>
</div>
<?php
// Esegue la connessione al DB
function connect_to_db() {
  $user = "root";
  $passwd = "";
  $db = "esami";
  // Si connette al server MySql
  mysql_connect(localhost,$user,$passwd);
  // Seleziona il database che contiene i pazienti
  @mysql_select_db($db) or die( "Errore durante la selezione del database!");
}

// Mostra la maschera per l'inserimento dei pazienti
function show_pazienti_form() {
  connect_to_db();
  ?>
  <div align="center">
  <form method="post" action="<?php $_SERVER[PHP_SELF];?>">
  <small>(I campi contrassegnati con * sono obbligatori)</small>
  <br><br>
  <table>
  <tr>
  <td><label for="cognome">Cognome*:</label></td> 
  <td><input id="cognome" type="text" name="cognome" size=50 maxlenght="50"/></td>
  </tr>
  <tr>
  <td><label for="nome">Nome*:</label></td>
  <td><input id="nome" type="text" name="nome" size=50 maxlenght=50/><br></td>  
  </tr>
  <tr>
  <td><label for="sesso">Sesso*:</label></td>
  <td>
  <select id="sesso" name="sesso"/>
  <option value=""></option>
  <option value="F">Femmina</option>
  <option value="M">Maschio</option>
  </select>
  </td>
  </tr>  
  <tr>  
  <td><label for="datanas">Data di Nascita* (gg/mm/aaaa):</label></td>
  <td><input id="datanas" type="text" name="datanascita" size=10 maxlenght=10/></td>
  </tr>  
  <tr>
  <td><label for="luogonas">Luogo di Nascita:</label></td>
  <td><input id="luogonas" type="text" name="luogonascita" size=50 maxlenght=50/></td>
  </tr>
  <tr>
  <td><label for="codfis">Codice Fiscale:</label></td>
  <td><input id="codfis" type="text" name="codicefiscale" size=16 maxlenght=16/></td>
  </tr>
  <tr>  
  <td><label for="cittares">Citt&agrave; di Residenza:</label></td>
  <td><input id="cittares" type="text" name="cittaresidenza" size=50 maxlenght=50/></td>
  </tr>
  <tr>
  <td><label for="viares">Via:</label></td>
  <td><input id="viares" type="text" name="viaresidenza" size=50 maxlenght=50/></td>
  </tr>
  <tr>
  <td><label for="tel">Telefono:</label></td>
  <td><input id="tel" type="text" name="telefono" size=25 maxlenght=25/></td>
  </tr>
  <tr>
  <td><label for="telmed">Telefono Medico Curante:</label></td>
  <td><input id="telmed" type="text" name="medico" size=25 maxlenght=25/></td>
  </tr>  
  </table>
  <br /><br />
  </font>
  <input type='hidden' name='_pazienti_form' value='1'/>
  <input type='submit' value='Registra'/>
  <br /><br /><a href='pazienti.php'>&lt;&lt;Indietro</a>	
  </form>
  </div>
  <?php
  mysql_close();
}

function validate_form() {
	if(empty($_POST["cognome"])) {
		print "<font face='Georgia' color='#ff0000'>";
		print "<b>Non e' stato specificato il cognome del paziente!</b><br />";
		print "</font>";
		return FALSE;
	}
	if(empty($_POST["nome"])) {
		print "<font face='Georgia' color='#ff0000'>";
		print "<b>Non e' stato specificato il nome del paziente!</b><br />";
		print "</font>";
		return FALSE;
	}
	if(empty($_POST["sesso"])) {
		print "<font face='Georgia' color='#ff0000'>";
		print "<b>Non e' stato specificato il sesso del paziente!</b><br />";
		print "</font>";
		return FALSE;
	}	
	if(empty($_POST["datanascita"])) {
		print "<font face='Georgia' color='#ff0000'>";
		print "<b>Non e' stata specificata la data di nascita del paziente!</b><br />";
		print "</font>";
		return FALSE;
	}
	$arrayData = split("[/.-]", $_POST["datanascita"]);
	$Giorno = $arrayData[0];
	$Mese = $arrayData[1];
	$Anno = $arrayData[2];
	if(!checkdate($Mese, $Giorno, $Anno))
	{
		print "<font face='Georgia' color='#ff0000'>";
		print "<b>La data di nascita inserita non è valida!</b><br />";
		print "</font>";		
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
	$codicefiscale = $_POST["codicefiscale"];
	$luogonascita = $_POST["luogonascita"];
	$viaresidenza = $_POST["viaresidenza"];
	$cittaresidenza = $_POST["cittaresidenza"];
	$telefono = $_POST["telefono"];
	$medico = $_POST["medico"];
	
	// registrazione dati esami
	$sql = "insert into pazienti(cognome, nome, datanascita, sesso, luogonascita, codicefiscale, viaresidenza, cittaresidenza, telefono, medico) values(";
	$sql.="'$cognome', '$nome', '$datanascita', '$sesso', '$luogonascita', '$codicefiscale', '$viaresidenza', '$cittaresidenza', '$telefono', '$medico')";
	mysql_query($sql) or die("Errore durante la registrazione del paziente! o il paziente è in archivio");
	print "<font face='Georgia' color='#0000ff'>";
	print "<center><b>La registrazione è stata eseguita con successo.</b></center>";
	print "</font>";	
	mysql_close();	
}

//include("inc/header.inc");

//include("inc/navigation.inc"); 
?>

<div id="content">
  <?php
	// --- MAIN ---
	if(array_key_exists("_pazienti_form",$_POST)) {
		if(validate_form()) {
			exec_admin();
			print "<META HTTP-EQUIV='refresh' content='1; URL=pazienti.php'>";
	  		exit();
		}
	}
	show_pazienti_form();
	?>
</div>

</body>
</html>
