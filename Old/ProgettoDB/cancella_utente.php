<!doctype html>
<html lang="it">
<head>
<meta charset="utf-8">
<meta name="description" content="HomePage" />
<meta name="author" content="Roberto Di Perna"/>
<link rel="stylesheet" href="css/struttura.css">

<title>Cacellazione Account</title>
</head>
<body>
<?php
// Includo la connessione al database
include('core.php');



if(isset($_SESSION['username']))
{
 
      $user  = $_SESSION['username'];
   
       $sql= ("DELETE FROM utenti WHERE username = '$user' ");
       $res = mysql_query($sql);
	   ?>
      <div id="cancella">
      		<img src="img/cancella.png">
      		<p>Account Eliminato con successo</p>
            <p>Attendi il reindirizzamento</p>

      </div>
     
      <?php   
}

	session_destroy();
	header("refresh:5;url=login.php");
exit();


?>
 
</body>
</html>
