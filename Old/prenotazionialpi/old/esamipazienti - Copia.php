<?php include("check.php"); print"<u><big>Utente: $_nome - $_ruolo - $_codiceunitaoperativa<br>"; ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<center><u><font color="#CD5C5C">
<title>Pre-Ricovero</title>
<link rel="stylesheet" type="text/css" href="css/stile.css" />
</head>
<body>
<div align="center">
	<a href="http://www.policlinicovittorioemanuele.it/" target="_blank"><img
		alt="Azienda Policlinico"
		src="http://10.5.0.254/esami/images/logo.jpg" border="0"
		height="100" width="135"></a>
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
	
// Mostra la maschera di selezione dell'operazione da effettuare sugli esami
function show_esamipazienti_form() {
	// variabili di sessione
	$_nome = $_SESSION["_nome"];
	$_ruolo = $_SESSION["_ruolo"];
	$_codiceunitaoperativa = $_SESSION["_codiceunitaoperativa"];
	// Controlla se è stato immesso un filtro
	if(isset($_POST["filtro"])) {
		$filtro = strtoupper($_POST["filtro"]);
	}
	else {
		$filtro = "*";
	}

	connect_to_db();
	print "<b>Elenco richieste esami:</b><br />";
	print "</table>";
	if($_ruolo == 'U') {
		print "<br /><a href='home.php'>^Home</a>";
	}
	elseif($_ruolo == 'A') {
		print "<br /><a href='home.php'>^Home</a><br>";
	}
	else {
		print "<br /><a href='home.php'>^Home</a><br>";
	}
	print "</font>";
	print "<a href='esamipazienti_ins.php'>Crea nuova richiesta</a>";
	print "<br /><br />";
	
	// Filtro per la ricerca
	print "<form enctype='multipart/form-data' method='post' action='$_SERVER[PHP_SELF]'>";
	print "Filtro: <input type='text' name='filtro' value='*' maxlenght='25' />";
	//print "<input type='hidden' name='_pazienti_form' value='1'/>";
	print "<input type='submit' value='Filtra'/>";	
	print "</form>";
	// estrae l'unità operativa
	/*
	if($filtro=='*') {
		$sql="select * from unitaoperativa order by unitaoperativa";	
	}
	else {
		$sql="select * from unitaoperativa where unitaoperativa like '$filtro%' order by unitaoperativa";
	}
	*/
	
	// estrae le richieste per paziente - unità operativa - asa e data richiesta
	//print "ruolo=$_ruolo - filtro=$filtro<br>";
	if($_ruolo == 'A' or $_ruolo == 'P') {
		if($filtro != '*') {
			$_codiceunitaoperativa = $filtro . '%';
		}
	}
	$sql="select p.id, p.cognome, p.nome, p.datanascita, uo.codiceunitaoperativa, uo.unitaoperativa, datarichiesta, codiceasa, completato, codannullato, telefono
		from esami_pazienti as ep, pazienti as p, unitaoperativa as uo
		where ep.id_pazienti = p.id and uo.codiceunitaoperativa=ep.codiceunitoperativa and ep.id_pazienti = p.id
		and ep.codiceunitoperativa like '$_codiceunitaoperativa'
		group by p.id, p.cognome, p.nome, p.datanascita, uo.codiceunitaoperativa, uo.unitaoperativa, datarichiesta 
		order by datarichiesta desc, uo.unitaoperativa, p.cognome, p.nome";
	//print "$sql<br>";
	$result = mysql_query($sql);
	print "<table id='sel_tab'>";
	print "<tr>";
	print"<td></td> <td bgcolor='#6495ED'>Cognome</td> <td bgcolor='#6495ED'>Nome</td> <td bgcolor='#6495ED'>Data Nascita</td> <td bgcolor='#6495ED'>Telefono</td> 
		<td bgcolor='#6495ED'>U.O.</td> <td bgcolor='#6495ED'>Cod. ASA</td> <td bgcolor='#6495ED'>ASA</td> <td bgcolor='#6495ED'>Data Richiesta</td> <td bgcolor='#6495ED'>Completato</td> <td bgcolor='#6495ED'>Annullato</td>";
	print "</tr>";
	while ($row = mysql_fetch_array($result)) {
		$id = $row["id"];
		$cognome = $row["cognome"];
		$nome = $row["nome"];
		$datanascita = $row["datanascita"];
		list($yyyy, $mm, $dd) = split('[/.-]',$datanascita);	
		$datanascita = "$dd-$mm-$yyyy";
		$codiceunitaoperativa = $row["codiceunitaoperativa"];
		$telefono = $row["telefono"];
		$unitaoperativa = $row["unitaoperativa"];
		// Ricava la descrizione dell'asa se esiste
		$codiceasa = $row["codiceasa"];
		if($codiceasa != "") {
			$sql2 = "select * from asa where codiceasa = '$codiceasa'";
			$res2 = mysql_query($sql2);
			if ($row2 = mysql_fetch_array($res2)) {
				$asa = $row2["asa"];
			}
			else $asa="";
		}
		else $asa="";
		//
		$datarichiesta = $row["datarichiesta"];
		list($yyyy, $mm, $dd) = split('[/.-]',$datarichiesta);	
		$datarichiesta = "$dd-$mm-$yyyy";
		$codiceasa = $row["codiceasa"];
		$completato = $row["completato"];
		$codannullato = $row["codannullato"];
		if($codannullato == '01') {
			$annullato = 'Annullato per volontà del Paziente';
		}
		elseif($codannullato == '02') {
			$annullato = 'Annullato dal Nosocomio';		
		}		
		print "<tr>";
		print "<td bgcolor='#d3d3d3'>";
		print "<a href='esamipazienti_upd.php?id=$id&datarichiesta=$datarichiesta'>Modifica</a>";
		print "</td>";	
		print "<td bgcolor='#B0C4DE'>$cognome</td>";
		print "<td bgcolor='#B0C4DE'>$nome</td>";
		print "<td bgcolor='#B0C4DE'>$datanascita</td>";
		print "<td bgcolor='#B0C4DE'>$telefono</td>";
		print "<td bgcolor='#B0C4DE'>$unitaoperativa</td>";
		print "<td bgcolor='#B0C4DE'>$codiceasa</td>";
		print "<td bgcolor='#B0C4DE'>$asa</td>";
		print "<td bgcolor='#B0C4DE'>$datarichiesta</td>";
		print "<td bgcolor='#B0C4DE'>$completato</td>";
		print "<td bgcolor='#B0C4DE'>$annullato</td>";
		print "</tr>";
	}
	print "</table>";
	if($_ruolo == 'U') {
		print "<br /><a href='home.php'>^Home</a>";
	}
	elseif($_ruolo == 'A') {
		print "<br /><a href='home.php'>^Home</a><br>";
	}
	else {
		print "<br /><a href='home.php'>^Home</a><br>";
	}
	print "</font>";
	mysql_close();
}

//include("inc/header.inc");

//include("inc/navigation.inc");
?>

<div id="content">
  <?php
	// --- MAIN ---
	show_esamipazienti_form();
	?>
</div>

</body>
</html>
