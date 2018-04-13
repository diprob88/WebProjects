<!doctype html>
<html lang="it">
<head>
<meta charset="utf-8">
<meta name="description" content="HomePage" />
<meta name="author" content="Roberto Di Perna"/>
<link rel="stylesheet" href="css/struttura.css">
<title>Cacellazione Articolo</title>
</head>
<body>
<?php
// Includo la connessione al database
include('core.php');



if(isset($_SESSION['username']))
{
 
 	   $chiave_articolo=$_REQUEST['x'];
       $sql= ("DELETE FROM articolo WHERE id = '$chiave_articolo' ");
       $res = mysql_query($sql);
     
    ?>
	
	<div id="cancella">
     		 <img src="img/cancella.png">
      		<p>Articolo Eliminato con successo</p>
            <p>Attendi il reindirizzamento</p>

      </div>
	
	<?php     
}

	
	header("refresh:5;url=ilmioprofilo.php");
exit();


?>
</body>
</html>