<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Modifica Agende</title>
<!--link rel="stylesheet" type="text/css" href="css/style.css" /-->
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

// Mostra la maschera per la selezione dello specialista
function sel_specialista() {
	connect_to_db();
	?>
	<form name='sel_specialista' method='POST' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
	<select name='ci'>
	<option value=''>- Selezionare lo specialista -</option>
	<?php
	// Selezione dello specialista di cui modificare le agende
	$sql = "select * from medici where tipo_autorizzazione = 'Studio Privato' order by nominativo";
	$res = mysql_query($sql);
	print "res=$res";
	while($row = mysql_fetch_array($res)) {
	$ci = $row['ci'];
	$nominativo = $row['nominativo'];
	$specialita = $row['specialita'];
	print "<option value='$ci'>$ci - $nominativo - $specialita</option>";
	}
	?>
	</select>
	
	</form>
	
	<?php
}

	<br>
	<table name='griglia_agenda' style='background-color:aliceblue; border:1px solid blue;'>
	<tr>
	<th>Giorno</th> <th colspan=2>fascia n.1</th> <th colspan=2>fascia n.2</th>
	</tr>
	
	
	
	<!-- G I O R N O   N . 1 -->
	<tr>
	<td>
	<select name='giorno1'>
	<option value=''>- Selezionare il giorno -</option>
	<option value='lun'>Luned&igrave;</option>
	<option value='mar'>Marted&igrave;</option>
	<option value='mer'>Mercoled&igrave;</option>
	<option value='gio'>Gioved&igrave;</option>
	<option value='ven'>Venerd&igrave;</option>
	<option value='sab'>Sabato</option>
	<option value='dom'>Domenica</option>
	</select>
	</td> 
	<td><input type='text' name='fascia1_1' maxlength=5/></td> <td><input type='text' name='fascia1_2' maxlength=5/></td>
	<td><input type='text' name='fascia1_3' maxlength=5/></td> <td><input type='text' name='fascia1_4' maxlength=5/></td>
	</tr>

	<!-- G I O R N O   N . 2 -->
	<tr>
	<td>
	<select name='giorno2'>
	<option value=''>- Selezionare il giorno -</option>
	<option value='lun'>Luned&igrave;</option>
	<option value='mar'>Marted&igrave;</option>
	<option value='mer'>Mercoled&igrave;</option>
	<option value='gio'>Gioved&igrave;</option>
	<option value='ven'>Venerd&igrave;</option>
	<option value='sab'>Sabato</option>
	<option value='dom'>Domenica</option>
	</select>
	</td> 
	<td><input type='text' name='fascia2_1' maxlength=5/></td> <td><input type='text' name='fascia2_2' maxlength=5/></td>
	<td><input type='text' name='fascia2_3' maxlength=5/></td> <td><input type='text' name='fascia2_4' maxlength=5/></td>
	</tr>

	<!-- G I O R N O   N . 3 -->
	<tr>
	<td>
	<select name='giorno3'>
	<option value=''>- Selezionare il giorno -</option>
	<option value='lun'>Luned&igrave;</option>
	<option value='mar'>Marted&igrave;</option>
	<option value='mer'>Mercoled&igrave;</option>
	<option value='gio'>Gioved&igrave;</option>
	<option value='ven'>Venerd&igrave;</option>
	<option value='sab'>Sabato</option>
	<option value='dom'>Domenica</option>
	</select>
	</td> 
	<td><input type='text' name='fascia3_1' maxlength=5/></td> <td><input type='text' name='fascia3_2' maxlength=5/></td>
	<td><input type='text' name='fascia3_3' maxlength=5/></td> <td><input type='text' name='fascia3_4' maxlength=5/></td>
	</tr>

	<!-- G I O R N O   N . 4 -->
	<tr>
	<td>
	<select name='giorno4'>
	<option value=''>- Selezionare il giorno -</option>
	<option value='lun'>Luned&igrave;</option>
	<option value='mar'>Marted&igrave;</option>
	<option value='mer'>Mercoled&igrave;</option>
	<option value='gio'>Gioved&igrave;</option>
	<option value='ven'>Venerd&igrave;</option>
	<option value='sab'>Sabato</option>
	<option value='dom'>Domenica</option>
	</select>
	</td> 
	<td><input type='text' name='fascia4_1' maxlength=5/></td> <td><input type='text' name='fascia4_2' maxlength=5/></td>
	<td><input type='text' name='fascia4_3' maxlength=5/></td> <td><input type='text' name='fascia4_4' maxlength=5/></td>
	</tr>

	<!-- G I O R N O   N . 5 -->
	<tr>
	<td>
	<select name='giorno5'>
	<option value=''>- Selezionare il giorno -</option>
	<option value='lun'>Luned&igrave;</option>
	<option value='mar'>Marted&igrave;</option>
	<option value='mer'>Mercoled&igrave;</option>
	<option value='gio'>Gioved&igrave;</option>
	<option value='ven'>Venerd&igrave;</option>
	<option value='sab'>Sabato</option>
	<option value='dom'>Domenica</option>
	</select>
	</td> 
	<td><input type='text' name='fascia5_1' maxlength=5/></td> <td><input type='text' name='fascia5_2' maxlength=5/></td>
	<td><input type='text' name='fascia5_3' maxlength=5/></td> <td><input type='text' name='fascia5_4' maxlength=5/></td>
	</tr>

	<!-- G I O R N O   N . 6 -->
	<tr>
	<td>
	<select name='giorno6'>
	<option value=''>- Selezionare il giorno -</option>
	<option value='lun'>Luned&igrave;</option>
	<option value='mar'>Marted&igrave;</option>
	<option value='mer'>Mercoled&igrave;</option>
	<option value='gio'>Gioved&igrave;</option>
	<option value='ven'>Venerd&igrave;</option>
	<option value='sab'>Sabato</option>
	<option value='dom'>Domenica</option>
	</select>
	</td> 
	<td><input type='text' name='fascia6_1' maxlength=5/></td> <td><input type='text' name='fascia6_2' maxlength=5/></td>
	<td><input type='text' name='fascia6_3' maxlength=5/></td> <td><input type='text' name='fascia6_4' maxlength=5/></td>
	</tr>
	</table>

	<input type='hidden' name="_agende_form" value=1/>
	<input type='submit' value='Registra'/>

	</form>
	<?php
}

function valida_form_agende() {
	return true;
}

function registra_agende() {
	connect_to_db();

	$ci = $_POST['ci'];

	$giorno1 = $_POST['giorno1'];
	$fascia1_1 = $_POST['fascia1_1'];
	$fascia1_2 = $_POST['fascia1_2'];
	$fascia1_3 = $_POST['fascia1_3'];
	$fascia1_4 = $_POST['fascia1_4'];

	$giorno2 = $_POST['giorno2'];
	$fascia2_1 = $_POST['fascia2_1'];
	$fascia2_2 = $_POST['fascia2_2'];
	$fascia2_3 = $_POST['fascia2_3'];
	$fascia2_4 = $_POST['fascia2_4'];

	$giorno3 = $_POST['giorno3'];
	$fascia3_1 = $_POST['fascia3_1'];
	$fascia3_2 = $_POST['fascia3_2'];
	$fascia3_3 = $_POST['fascia3_3'];
	$fascia3_4 = $_POST['fascia3_4'];

	$giorno4 = $_POST['giorno4'];
	$fascia4_1 = $_POST['fascia4_1'];
	$fascia4_2 = $_POST['fascia4_2'];
	$fascia4_3 = $_POST['fascia4_3'];
	$fascia4_4 = $_POST['fascia4_4'];

	$giorno5 = $_POST['giorno5'];
	$fascia5_1 = $_POST['fascia5_1'];
	$fascia5_2 = $_POST['fascia5_2'];
	$fascia5_3 = $_POST['fascia5_3'];
	$fascia5_4 = $_POST['fascia5_4'];

	$giorno6 = $_POST['giorno6'];
	$fascia6_1 = $_POST['fascia6_1'];
	$fascia6_2 = $_POST['fascia6_2'];
	$fascia6_3 = $_POST['fascia6_3'];
	$fascia6_4 = $_POST['fascia6_4'];

	$sql = "insert into agende(ci, 
				giorno1, fascia1_1, fascia1_2, fascia1_3, fascia1_4, 
				giorno2, fascia2_1, fascia2_2, fascia2_3, fascia2_4, 
				giorno3, fascia3_1, fascia3_2, fascia3_3, fascia3_4, 
				giorno4, fascia4_1, fascia4_2, fascia4_3, fascia4_4, 
				giorno5, fascia5_1, fascia5_2, fascia5_3, fascia5_4, 
				giorno6, fascia6_1, fascia6_2, fascia6_3, fascia6_4)
			values('$ci', 
				'$giorno1', '$fascia1_1', '$fascia1_2', '$fascia1_3', '$fascia1_4', 
				'$giorno2', '$fascia2_1', '$fascia2_2', '$fascia2_3', '$fascia2_4', 
				'$giorno3', '$fascia3_1', '$fascia3_2', '$fascia3_3', '$fascia3_4', 
				'$giorno4', '$fascia4_1', '$fascia4_2', '$fascia4_3', '$fascia4_4', 
				'$giorno5', '$fascia5_1', '$fascia5_2', '$fascia5_3', '$fascia5_4', 
				'$giorno6', '$fascia6_1', '$fascia6_2', '$fascia6_3', '$fascia6_4')";
				
	//print "sql=$sql";

	mysql_query($sql) or die("Errore durante la registrazione dei dati dell'agenda");
	?>

	<b>L'agenda e' stata registrata correttamente, premere 'Avanti' per un nuovo inserimento</b><br>
	<a href='agende_ins.php'>Avanti>>></a>

	<?php
}
?>
<div id="container">
	<div id="header">
		<?php include("inc/header.php"); ?>
	</div>
	
	<div id="sidebarleft">
		<?php 
		// serve ad evidenziare la voce di menù corrente
		//$_selected = "calendariopren"; 
		//include("inc/navigation.php"); ?>
	</div>	
		
	<div id="content">
		<?php
		// --- MAIN ---
		if(array_key_exists("_agende_form",$_POST)) {
			if(valida_form_agende()) {
				registra_agende();
			}
		}
		else {
			mostra_form_agende();
		}
		?>
	</div>
	
	<div id="footer">
		<?php if($_POST['_insert_form'] >= '1') {include("inc/footer.php");} ?>
	</div>	
</div>	
</body>
</html>
