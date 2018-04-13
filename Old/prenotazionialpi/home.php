<?php include("check.php"); ?>
<?php
// variabili di sessione
$_nome = $_SESSION["_nome"];
$_ruolo = $_SESSION["_ruolo"];
$_codiceunitaoperativa = $_SESSION["_codiceunitaoperativa"];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
	<title>home</title>
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
			$_selected = "home"; // serve ad evidenziare la voce di menù corrente
			include("inc/navigation.php");
			?>
		</div>	
			
		<div id="content">
			<img src="images/shapeimage2.png" alt="Scheda Anestesiologica">
		</div>
		<div id="footer">
			<?php 
			include("inc/footer.php"); ?>
		</div>
	</div>

	</body>
</html>