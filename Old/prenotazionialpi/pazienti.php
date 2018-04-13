<?php include("check.php");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<title>Gestione Pazienti</title>
<link rel="stylesheet" type="text/css" href="css/style.css" /></big>
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

// Mostra la maschera di selezione dell'operazione da effettuare sui pazienti
function show_pazienti_form() {
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
	<!--<div align="center">-->
	<h2>Amministrazione - Pazienti:</h2>
	</div>	
	<form method='post' action='<?php echo $_SERVER[PHP_SELF];?>'>
	Filtro: <input type='text' name='filtro' value='*' maxlenght='50' />
	<br>
	<br>
	<input type='submit' value='Filtra'/>
	</form>
	<br>
	<?php
	// estrae i pazienti
	if($filtro=='*') {
		$sql="select * from pazienti order by cognome, nome";	
	}
	else {
		$sql="select * from pazienti where cognome like '$filtro%' order by cognome, nome";
	}
	$result = mysql_query($sql);
	?>
	<a href='pazienti_ins.php'><div><img src='images/add-file-icon.png' alt='Crea nuovo'></div></a>	
	<div id="table_scroll">
	<table>
	<tr>
	<th></th>
	<th bgcolor='#6495ED'>Cognome</th>
	<th bgcolor='#6495ED'>Nome</th>
	<th bgcolor='#6495ED'>Data Nascita</th>
	<th bgcolor='#6495ED'>Telefono</th>
	<th bgcolor='#6495ED'>Codice Fiscale</th>
	</tr>	
	<?php		
	while ($row = mysql_fetch_array($result)) {
		$id = $row["id"];
		$cognome = $row["cognome"];
		$nome = $row["nome"];
		$datanascita = $row["datanascita"];
		list($yyyy, $mm, $dd) = split('[/.-]',$datanascita);	
		$datanascita = "$dd-$mm-$yyyy";
		$telefono = $row["telefono"];
		$codicefiscale = $row["codicefiscale"];
		?>	
		<tr>
		<td bgcolor='#d3d3d3'><a href='pazienti_mod.php?id=<?php echo $id;?>'><div align='center'><img src='images/edit-icon.png' alt='Modifica'></div></a></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><?php echo $cognome;?></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><?php echo $nome;?></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><?php echo $datanascita;?></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><?php echo $telefono;?></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><?php echo $codicefiscale;?></td>
		</tr>
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
		$_selected = "pazienti"; // serve ad evidenziare la voce di menù corrente
		include("inc/navigation.php"); 
		?>
	</div>	
		
	<div id="content">
		<?php
		// --- MAIN ---
		show_pazienti_form();
		?>
	</div>	

	<div id="footer">
		<?php include("inc/footer.php"); ?>
	</div>	
</div>
</body>
</html>
