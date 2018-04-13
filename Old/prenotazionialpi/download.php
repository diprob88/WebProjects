<?php include("check.php");?> 

<?php
// variabili di sessione
$_nome = $_SESSION["_nome"];
$_ruolo = $_SESSION["_ruolo"];
$_codiceunitaoperativa = $_SESSION["_codiceunitaoperativa"];
?>
	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>prenotazioni</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<div id="container">
	<div id="header">
		<?php include("inc/header.php"); ?>
	</div>
	
	<div id="sidebarleft">
		<?php 
		$_selected = "download"; // serve ad evidenziare la voce di menù corrente
		include("inc/navigation.php"); 
		?>
	</div>	
		
	<div id="content">
		<div>
		<h3>Download:</h3>
		</div>
		<div>
		<ul id="download">
			<!-- <li><a href="http://10.5.0.254/download/infutente.pdf" target="_blank">Info Utente</a></li>
			<li><a href="http://10.5.0.254/download/schedaprericovero.pdf" target="_blank">Scheda Pre-Ricovero</a></li>
			<li><a href="http://10.5.0.254/download/servizioprericovero.pdf" target="_blank">Scheda Servizio Pre-Ricovero</a></li>
			<li><a href="http://10.5.0.254/download/guidaprericovero.pdf" target="_blank">Guida all'utilizzo dell'Applicativo</a></li>
			<li><a href="http://10.5.0.254/download/I_PDT_dell'Azienda_valutazione_preoperatoria2014.pdf" target="_blank">I PDT dell'Azienda valutazione preoperatoria 2014</a></li> -->
		</ul>
		</div>
	</div>
	
	<div id="footer">
		<?php include("inc/footer.php"); ?>
	</div>
</div>	
</body>
</html>
