

<?php 

//include("C:/xampp/htdocs/abbattimenti2/assets/php/core.php");
include("../core.php");

 
$data = $_POST["data"];
$anno = $_POST["anno"];
$unita = $_POST["unita"];
$numero_cartella = $_POST["numero_cartella"];
$giorni_app = $_POST["giorni_app"];
$giorni_non_app = $_POST["giorni_non_app"];
$punteggio_ottenuto = $_POST["punteggio_ottenuto"];
$drg = $_POST["drg"];
$descrizione = $_POST["descrizione"];
$selezione = $_POST["selezione"];
$valore = $_POST["valore"];
$rimborso = $_POST["rimborso"];
$abbattimento = $_POST["abbattimento"];
$punteggio_abbattimento = $_POST["punteggio_abbattimento"];
 
 
 if(mysql_num_rows(mysql_query("SELECT * FROM calcolo WHERE numero_cartella LIKE '$numero_cartella' AND coduo LIKE '$unita' AND anno_calcolo LIKE '$anno' AND abbattimento LIKE'$abbattimento'"))>0)
	{
		echo "Calcolo gia' effettuato!!!";
	}
	else
	{
 
 
 
$sql = "insert into calcolo(numero_cartella, data_calcolo,anno_calcolo,coduo,giorni_app,giorni_non_app,punteggio_ottenuto,drg,descrizione,selezione,valore,rimborso,abbattimento,punteggio_abbattimento) values(";
$sql.="'$numero_cartella','$data','$anno','$unita','$giorni_app','$giorni_non_app','$punteggio_ottenuto','$drg','$descrizione','$selezione','$valore','$rimborso','$abbattimento','$punteggio_abbattimento')";
mysql_query($sql) or die("Errore durante l'inserimento!");

	echo "inserimento riuscito";
	}


?>
