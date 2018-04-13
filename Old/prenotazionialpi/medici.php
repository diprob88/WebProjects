<?php include("check.php");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<title>Gestione Medici Specialisti</title>
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

// Mostra la maschera di selezione dell'operazione da effettuare sui medici chirurghi
function show_medici_form() {
	// variabili di sessione
	$_nome = $_SESSION["_nome"];
	$_ruolo = $_SESSION["_ruolo"];
	$_codiceunitaoperativa = $_SESSION["_codiceunitaoperativa"];
	connect_to_db();
	// Controlla se sono stati immessi dei filtri per la selezione dei medici specialisti di interesse
	if(isset($_POST["specialita_flt"])) {
		$specialita_flt = $_POST["specialita_flt"];
	}
	if(isset($_POST["prestazione_flt"])) {
		$prestazione_flt = $_POST["prestazione_flt"];
	}
	//
	?>
	<div>
	<h2>Amministrazione - Medici Specialisti:</h2>
	</div>	
	<h4>Indicare la 'Specialit&agrave;' e/o la 'Prestazione erogata' per filtrare i medici specialisti di interesse</h4>
	<form method='post' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
	Specialit&agrave;: 
	<select name='specialita_flt' onchange="form.submit();">
	<option value=''>-Scegliere-</option>
	<?php	
	$sql = "select distinct specialita from medici;";
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$specialita = $row["specialita"];			
		?>
		<option value='<?php echo $specialita;?>' <?php echo ($specialita==$specialita_flt?'selected':'');?>><?php echo "$specialita";?></option>
	<?php	
    }
	?>
	</select>
	Prestazioni erogate: 	
	<select name='prestazione_flt'>
	<option value=''>-Scegliere-</option>
	<?php	
	$sql = "select distinct p.descrizione from prestazioni as p, medici as m where p.ci_medico = m.ci " .
		($specialita_flt != "" ? " AND m.specialita = '$specialita_flt'" : "") .
		" order by p.descrizione;";
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) {
		$descrizione = $row["descrizione"];			
		?>
		<option value='<?php echo $descrizione;?>' <?php echo ($descrizione==$prestazione_flt?'selected':'');?>><?php echo substr("$descrizione", 0, 100);?></option>
	<?php	
    }
	?>
	</select>
	<br>
	<input type='submit' value='Filtra'/>
	</form>
	<br>
	
	<?php	
	// estrae i medici specialisti in base ai filtri specificati dall'operatore
	$sql = "select distinct m.* from medici as m, prestazioni as p where m.ci = p.ci_medico  " . 
		($specialita_flt != "" ? " AND m.specialita = '$specialita_flt'" : "") .
		($prestazione_flt != "" ? " AND p.descrizione = '$prestazione_flt'" : "") .
		" order by m.nominativo;";
	$result = mysql_query($sql);
	?>
	<a href='medici_ins.php'><div><img src='images/add-file-icon.png' alt='Crea nuovo'></div></a>	
	<div id="table_scroll">
	<table>
	<tr>
	<th></th>
	<th bgcolor='#6495ED'>Codice Individuale</th>
	<th bgcolor='#6495ED'>Nominativo</th>
	<th bgcolor='#6495ED'>Specialit&agrave;</th>	
	</tr>
	<?php				
	while ($row = mysql_fetch_array($result)) {
		$ci = $row["ci"];
		$nominativo = $row["nominativo"];
		$specialita = $row["specialita"];
		?>			
		<tr>
		<td bgcolor='#d3d3d3'><a href='medici_upd.php?ci=<?php echo $ci;?>'><div align='center'><img src='images/edit-icon.png' alt='Modifica'></div></a></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><?php echo $ci;?></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><?php echo $nominativo;?></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><?php echo $specialita;?></td></tr>
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
		$_selected = "medici"; // serve ad evidenziare la voce di menù corrente
		include("inc/navigation.php"); 
		?>
	</div>	
		
	<div id="content">
		<?php
		// --- MAIN ---
		show_medici_form();
		?>
	</div>	

	<div id="footer">
		<?php include("inc/footer.php"); ?>
	</div>	
</div>

</body>
</html>
