<?php include("check.php"); print"<u><big>Utente: $_nome - $_ruolo - $_codiceunitaoperativa<br>"; ?>
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
	<br>
	<br>
	<div align="center">
	<a href="pazienti.php"><font color="#CD5C5C"> Pazienti - </big>
	<a href="diagnosi.php"><big><font color="#CD5C5C"> Diagnosi - </big></big>
	<a href="interventi.php"><big><font color="#CD5C5C"> Interventi Chirurgici - </big>
	<a href="esami.php"><big><font color="#CD5C5C"> Esami - </big>
	<a href="unitaoperativa.php"><big><font color="#CD5C5C"> Unita' Operative - </big>
	<a href="asa.php"><big><font color="#CD5C5C"> Classificazione ASA - </big>
	<a href="medici.php"><big><font color="#CD5C5C"> Medici Chirurghi - </big>
	<a href="medician.php"><big><font color="#CD5C5C"> Medici Anestesisti - </big>
	<a href="medicica.php"><big><font color="#CD5C5C"> Medici Cardiologi - </big>
	<a href="user.php"><big><font color="#CD5C5C"> Utenti - </big>
	<a href="download.php"><big><font color="#CD5C5C"> Download</big><br><br>
	<a href="esamipazienti.php"><big><big><font color="#800080">Richiesta Esami</big></big><br><br><hr/>
  </head>
  <br>
  <body>
    <div align="center">
	<a href="http://www.policlinicovittorioemanuele.it/" target="_blank"><img
		alt="Azienda Policlinico"
		src="http://10.5.0.254/esami/images/logo.jpg" border="0"
		height="100" width="150"></a>
        <br>
        <font color="#6633ff"><i>Azienda Ospedaliero - Universitaria
            "Policlinico - Vittorio Emanuele"</i><i><br>
          </i></font><u><font color="#6633ff">Catania</font><br>
          <br>
          <small><font color="#330099">DIREZIONE MEDICA <br>
            PRESIDIO VITTORIO EMANUELE</font><br>
        </u></blockquote>
    </div>
    <br>
    <div align="center"><font color="#ff6666"><big><big>SERVIZIO DI PRE-RICOVERO
                </big></big></font><br>
	<br>
      <font color="#cc33cc"><u>COMMA 18 Art. 1 Legge 662 del 23.12.96</u></font><br><hr/>
	</div>
    <br>	
    <br>
	<a href="chiudi.php"><big><big><big><font color="#ff6666">Esci</big></big></big>
	<br>
	<br>
      <div align="center"><h1>info<br></h1>
	  <div align="center"><h4>Tel. - 2958<br>
	  <div align="center"><h4>Email - f.bentivegna@ao-ve.it<br>
      </div>
      <br>
    </center>
  </body>
</html>
