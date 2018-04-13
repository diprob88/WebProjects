<?php include("check.php");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<title>Amministrazione delle prestazioni</title>
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

// Mostra la maschera di selezione dell'operazione da effettuare sugli interventi
function show_prestazioni_form() {
	// variabili di sessione
	$_nome = $_SESSION["_nome"];
	$_ruolo = $_SESSION["_ruolo"];
	$_codiceunitaoperativa = $_SESSION["_codiceunitaoperativa"];
	connect_to_db();
	// Controlla se sono stati immessi dei filtri
	if(isset($_POST["filtro_med"])) {
		if(substr($_POST["filtro_med"],-1) == '%') {
			$filtro_med = $_POST["filtro_med"]; // filtro sul nominativo dello specialista
		}
		else {
			$filtro_med = $_POST["filtro_med"] . "%"; 
		}
	}
	else {
		$filtro_med = "%";
	}
	if(isset($_POST["filtro_descr"])) {
		if(substr($_POST["filtro_descr"],-1) == '%') {
			$filtro_descr = $_POST["filtro_descr"]; // filtro sulla descrizione della prestazione
		}
		else {
			$filtro_descr = "%" . $_POST["filtro_descr"] . "%";
		}
	}
	else {
		$filtro_descr = "%";
	}	
	//
	?>
	<div>
	<h2>Amministrazione - Prestazioni Sanitarie:</h2>
	</div>	
	<form method='post' action='<?php echo $_SERVER[PHP_SELF];?>'>
	Filtro (Medico): <input type='text' name='filtro_med' value='<?php echo $filtro_med;?>' maxlength=50 />
	Filtro (contiene 'Descrizione'): <input type='text' name='filtro_descr' value='<?php echo $filtro_descr;?>' maxlength=25 />
	<input type='submit' value='Filtra'/>
	</form>
	<br>
	<?php	
	// estrae le prestazioni
	$sql = "select * from prestazioni as p, medici as m
			where p.ci_medico = m.ci 
			and m.nominativo like '$filtro_med' 
			and p.descrizione like '$filtro_descr' 
			order by m.nominativo, p.descrizione ";
	//print $sql;
	$result = mysql_query($sql);
	?>
	<a href='prestazioni_ins.php'><div><img src='images/add-file-icon.png' alt='Crea nuovo'></div></a>	
	<div id="table_scroll">
	<table>
	<tr>
	<th></th>
	<th bgcolor='#6495ED'>Medico</th>
	<th bgcolor='#6495ED'>Codice Prestazione</th>
	<th bgcolor='#6495ED'>Descrizione</th>
	<th bgcolor='#6495ED'>Tariffa euro</th>
	</tr>
	<?php			
	while ($row = mysql_fetch_array($result)) {
		$ci = $row["ci"];
		$nominativo = $row["nominativo"];
		$codice = $row["codice"];
		$descrizione = $row["descrizione"];
		$tariffa_euro = $row["tariffa_euro"];
		?>					
		<tr>
		<td bgcolor='#d3d3d3'><a href='prestazioni_upd.php?ci_medico=<?php echo $ci;?>&codice=<?php echo $codice;?>&descrizione=<?php echo $descrizione;?>'><div align='center'><img src='images/edit-icon.png' alt='Modifica'></div></a></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><?php echo "$ci - $nominativo";?></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><?php echo $codice;?></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><?php echo $descrizione;?></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><?php echo $tariffa_euro;?></td></tr>
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
		$_selected = "prestazioni"; // serve ad evidenziare la voce di menù corrente
		include("inc/navigation.php"); 
		?>
	</div>	
		
	<div id="content">
		<?php
		// --- MAIN ---
		show_prestazioni_form();
?>
	</div>	

	<div id="footer">
		<?php include("inc/footer.php"); ?>
	</div>	
</div>

</body>
</html>
