<?php include("check.php");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<title>Gestione Unità Operative</title>
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

// Mostra la maschera di selezione dell'operazione da effettuare sulle unita' operative
function show_unitaoperativa_form() {
	// variabili di sessione
	$_nome = $_SESSION["_nome"];
	$_ruolo = $_SESSION["_ruolo"];
	$_codiceunitaoperativa = $_SESSION["_codiceunitaoperativa"];
	connect_to_db();
	// Controlla se è stato immesso un filtro
	if(isset($_POST["filtro"])) {
		$filtro = strtoupper($_POST["filtro"]);
	}
	else {
		$filtro = "*";
	}
	//
	?>
	<div>
	<h2>Amministrazione - Unita' Operative:</h2>
	</div>	
	<form method='post' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
	Filtro: <input type='text' name='filtro' value='*' maxlenght=10 />
	<br>
	<br>
	<input type='submit' value='Filtra'/>
	</form>
	<br>
	<?php	
	// estrae le unita' operative
	if($filtro=='*') {
		$sql="select * from unita_operative order by descrizione; ";	
	}
	else {
		$sql="select * from unita_operative where descrizione like '$filtro%' order by descrizione; ";
	}	
	$result = mysql_query($sql);
	?>
	<a href='unitaoperativa_ins.php'><div><img src='images/add-file-icon.png' alt='Crea nuovo'></div></a>	
	<div id="table_scroll">
	<table>
	<tr>
	<th></th>
	<th bgcolor='#6495ED'>Unita' Operative</th>
	</tr>
	<?php			
	while ($row = mysql_fetch_array($result)) {
		$codice = $row["codice"];
		$descrizione = $row["descrizione"];
		?>			
		<tr>
		<td bgcolor='#d3d3d3'><a href='unitaoperativa_upd.php?codice=<?php echo $codice;?>'><div align='center'><img src='images/edit-icon.png' alt='Modifica'></div></a></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><?php echo $descrizione;?></td></tr>
		<?php	
		$i++;			
	}
	?>	
	</table>
	</div>
	</div>
	<?php
	mysql_close();
}

?>

<div id="container">
	<div id="header">
		<?php include("inc/header.php"); ?>
	</div>
	
	<div id="sidebarleft">
		<?php 
		$_selected = "unitaoperativa"; // serve ad evidenziare la voce di menù corrente
		include("inc/navigation.php"); 
		?>
	</div>	
		
	<div id="content">
		<?php
		// --- MAIN ---
		show_unitaoperativa_form();
		?>
	</div>	

	<div id="footer">
		<?php include("inc/footer.php"); ?>
	</div>	
</div>

</body>
</html>
