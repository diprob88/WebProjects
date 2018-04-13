<?php

// Costanti e classi per la creazione di file PDF
define('FPDF_FONTPATH', 'fpdf/font/');
require('fpdf/fpdf.php');

// il progressivo e l'anno della scheda da stampare sono passati come parametri nella GET
$progressivo = $_POST["progressivo"];
$anno = $_POST["anno"];

//DEBUG
//$progressivo = 7;
//$anno = 2014;

// --> Estrae dal db i dati della prenotazione e della scheda di prericovero
connect_to_db();
$sql="select *
	from prenotazioni as ep, pazienti as p, unitaoperativa as uo
	where ep.progressivo = $progressivo 
	and ep.anno = '$anno'
	and ep.id_pazienti = p.id
	and ep.codiceunitaoperativa = uo.codiceunitaoperativa";
//print "$sql<br>";

$result = mysql_query($sql);
$row = mysql_fetch_array($result);
// dati del  paziente
$id_pazienti = $row["id_pazienti"];
$cognome = $row["cognome"];
$nome = $row["nome"];
$datanascita = $row["datanascita"];
list($yyyy, $mm, $dd) = split('[/.-]',$datanascita);	
$datanascita = "$dd-$mm-$yyyy";
$luogonascita = $row["luogonascita"];
$telefono = $row["telefono"];
$codicefiscale = $row["codicefiscale"];
// dati della diagnosi
$coddiagnosi = $row["coddiagnosi"];
$diagnosi = "";
$sql3 = "select * from diagnosi where coddiagnosi = '$coddiagnosi';";
$res3 = mysql_query($sql3);
if($row3 = mysql_fetch_array($res3)) {
	$diagnosi = $row3["diagnosi"];
}
// dati dell'intervento
$codprest = $row["codprest"];
$intervento = "";
$sql4 = "select * from interventi where codintervento = '$codprest';";
$res4 = mysql_query($sql4);
if($row4 = mysql_fetch_array($res4)) {
	$intervento = $row4["intervento"];
}
// dati della unità operativa
$unitaoperativa = $row["unitaoperativa"];
$presidio = substr($unitaoperativa, -6);
if($presidio == "(V.E.)") {
	$presidio = "Vittorio Emanuele";
}
elseif($presidio == "(G.R.)") {
	$presidio = "Gaspare Rodolico";
}
// dati del medico
$codmedico = $row["codmedico"];
$medico = "";
$sql2 = "select * from medici where codmedico = '$codmedico';";
$res2 = mysql_query($sql2);
if($row2 = mysql_fetch_array($res2)) {
	$medico = $row2["medico"];
}
// dati del prericovero
$dataprenotazione = $row["dataprenotazione"]; list($yyyy, $mm, $dd) = split('[/.-]',$dataprenotazione); $dataprenotazione = "$dd-$mm-$yyyy";
$codicepriorita = $row["codicepriorita"];
$anestesia = $row["anestesia"];
$notepat = $row["notepat"];
$cardio = $row["cardio"];
$resp = $row["resp"];
$nerv = $row["nerv"];
$endocr = $row["endocr"];
$allergie = $row["allergie"];
$obesi = $row["obesi"];
$coagulopatie = $row["coagulopatie"];
$fumo = $row["fumo"];
$epatite = $row["epatite"];
$altro = $row["altro"];
$notepat = $row["notepat"];
$esstrum = $row["esstrum"];
$dtprevric = $row["dtprevric"]; list($yyyy, $mm, $dd) = split('[/.-]',$dtprevric); $dtprevric = "$dd-$mm-$yyyy";

// --> Crea la pagina PDF
$p = new fpdf();
$p->Open();
$p->AddPage();
// Imposta il font di default
$p->SetFont('Arial', 'B', 8);

// -->	Stampa i dati anagrafici e di ricovero
$p->Image(".\images\logo_print.jpg", 85, 10);
$p->Image(".\images\im.png", 43, 87.7);
$p->Image(".\images\im.png", 58, 87.7);
$p->Image(".\images\im.png", 73, 87.7);
$p->Image(".\images\im.png", 88, 87.7);
$p->Image(".\images\im.png", 53.5, 128);
$p->Image(".\images\im.png", 79.5, 128);
$p->Image(".\images\im.png", 112.5, 128);
$p->Image(".\images\im.png", 137.5, 128);
$p->Image(".\images\im.png", 54, 143.5);
$p->Image(".\images\im.png", 74.7, 143.5);
$p->Image(".\images\im.png", 54, 151.5);
$p->Image(".\images\im.png", 74.7, 151.5);
$p->Image(".\images\im.png", 54, 159.5);
$p->Image(".\images\im.png", 74.7, 159.5);
$p->Image(".\images\im.png", 54, 167.5);
$p->Image(".\images\im.png", 74.7, 167.5);
$p->Image(".\images\im.png", 54, 175.5);
$p->Image(".\images\im.png", 74.7, 175.5);
$p->Image(".\images\im.png", 54, 183.2);
$p->Image(".\images\im.png", 74.7, 183.2);
$p->Image(".\images\im.png", 54, 191.6);
$p->Image(".\images\im.png", 74.7, 191.6);
$p->Image(".\images\im.png", 54, 199.6);
$p->Image(".\images\im.png", 74.7, 199.6);
$p->Image(".\images\im.png", 54, 207.6);
$p->Image(".\images\im.png", 74.7, 207.6);
$p->SetY(35);
$p->SetX(92); $p->Write(8, 'Regione Siciliana'); $p->Ln(); // centrato
$p->SetX(60); $p->Write(8, 'Azienda Ospedaliero Universitaria Policlinico - Vittorio Emanuele'); $p->Ln();
$p->SetX(98); $p->Write(8, 'Catania'); $p->Ln(); 
$p->SetX(86); $p->Write(12, 'SCHEDA PRERICOVERO');
$p->SetFont('Arial', 'B', 8); $p->Ln();
$p->SetX(105); $p->Write(8, "SCHEDA PRE-RICOVERO U.O. N. ______________________ "); $p->Ln();//$p->SetX(130); $p->Write(8, "$progressivo/$anno"); $p->Ln();
// unità operativa e presidio
$p->Write(8, "U.O.: ___________________________________________________ "); $p->SetX(20); $p->Write(8, "$unitaoperativa"); $p->SetX(100); $p->Write(8, "P.O.: __________________________________________________ "); $p->SetX(110); $p->Write(8, "$presidio"); $p->Ln();
// codice priorità
$p->Write(8, "CODICE PRIORITA': ");
$p->SetX(38); ($codicepriorita=="A"?$p->Write(8, " A    X "):$p->Write(8, "  A"));
$p->SetX(53); ($codicepriorita=="B"?$p->Write(8, " B    X "):$p->Write(8, "  B"));
$p->SetX(68); ($codicepriorita=="C"?$p->Write(8, " C    X "):$p->Write(8, "  C"));
$p->SetX(83); ($codicepriorita=="D"?$p->Write(8, " D    X "):$p->Write(8, "  D"));

// anagrafica paziente
$p->SetX(100);$p->Write(8, "COD. FISC.: ____________________________________________ "); $p->SetX(140); $p->Write(8, "$codicefiscale"); $p->SetX(110);$p->Ln();
$p->Write(8, "COGNOME e NOME: ___________________________________________________________________ "); $p->SetX(40); $p->Write(8, "$cognome $nome"); $p->SetX(110); //$p->Write(8, "NOME: "); $p->SetX(125); $p->Write(8, "$nome"); $p->Ln();
$p->SetX(145);$p->Write(8, "DATA NASCITA: ____________ "); $p->SetX(169); $p->Write(8, "$datanascita"); $p->Ln(); $p->Write(8, "LUOGO DI NASCITA: ___________________________________________________________________ "); $p->SetX(40); $p->Write(8, "$luogonascita"); $p->SetX(145);$p->Write(8, "TELEFONO: ________________ "); $p->SetX(164); $p->Write(8, "$telefono"); $p->Ln();
$p->Write(8, "DIAGNOSI: _______________________________________________________________________________________________________ "); $p->SetX(27); $p->Write(8, "$diagnosi");
$p->Ln();
$p->Write(8, "INTERVENTO PREVISTO: ___________________________________________________________________________________________ "); $p->SetX(47); $p->Write(8, "$intervento");
$p->Ln();
$p->Write(8, "ANESTESIA: ");
$p->SetX(35); ($anestesia=="GENER"?$p->Write(8, "GENERALE     X "):$p->Write(8, "GENERALE  "));  
$p->SetX(65); ($anestesia=="LOCAL"?$p->Write(8, "LOCALE     X "):$p->Write(8, "LOCALE  "));
$p->SetX(95); ($anestesia=="LOCOR"?$p->Write(8, "LOCOREG.     X "):$p->Write(8, "LOCOREG.  "));
$p->SetX(125); ($anestesia=="ALTRO"?$p->Write(8, "ALTRO     X "):$p->Write(8, "ALTRO  ")); $p->Ln();

$p->Write(8, "PATOLOGIE: "); $p->SetX(35); $p->Ln(); //$p->Write(8, "$notepat"); $p->Ln();
$p->Write(8, "SIST. CARDIOVASCOLARE"); $p->SetX(55); ($cardio=="SI"?$p->Write(8, "SI     "):$p->Write(8, "     ")); $p->SetX(75); ($cardio=="NO"?$p->Write(8, "NO      "):$p->Write(8, "     ")); $p->Ln();
$p->Write(8, "SIST. RESPIRATORIO"); $p->SetX(55); ($resp=="SI"?$p->Write(8, "SI     "):$p->Write(8, "     ")); $p->SetX(75); ($resp=="NO"?$p->Write(8, "NO     "):$p->Write(8, "     ")); $p->Ln();
$p->Write(8, "SIST. NERVOSO"); $p->SetX(55); ($nerv=="SI"?$p->Write(8, "SI  "):$p->Write(8, "   ")); $p->SetX(75); ($nerv=="NO"?$p->Write(8, "NO  "):$p->Write(8, "   ")); $p->Ln();
$p->Write(8, "SIST. ENDOCRINO"); $p->SetX(55); ($endocr=="SI"?$p->Write(8, "SI  "):$p->Write(8, "   ")); $p->SetX(75); ($endocr=="NO"?$p->Write(8, "NO  "):$p->Write(8, "   ")); $p->Ln();
$p->Write(8, "ALLERGIE"); $p->SetX(55); ($allergie=="SI"?$p->Write(8, "SI  "):$p->Write(8, "   ")); $p->SetX(75); ($allergie=="NO"?$p->Write(8, "NO  "):$p->Write(8, "   ")); $p->Ln();
$p->Write(8, "OBESITA'"); $p->SetX(55); ($obesi=="SI"?$p->Write(8, "SI  "):$p->Write(8, "   ")); $p->SetX(75); ($obesi=="NO"?$p->Write(8, "NO  "):$p->Write(8, "   ")); $p->Ln();
$p->Write(8, "COAGULOPATIA"); $p->SetX(55); ($coagulopatie=="SI"?$p->Write(8, "SI  "):$p->Write(8, "   ")); $p->SetX(75); ($coagulopatie=="NO"?$p->Write(8, "NO  "):$p->Write(8, "   ")); $p->Ln();
$p->Write(8, "FUMO"); $p->SetX(55); ($fumo=="SI"?$p->Write(8, "SI  "):$p->Write(8, "   ")); $p->SetX(75); ($fumo=="NO"?$p->Write(8, "NO  "):$p->Write(8, "   ")); $p->Ln();
$p->Write(8, "EPATITE"); $p->SetX(55); ($epatite=="SI"?$p->Write(8, "SI  "):$p->Write(8, "   ")); $p->SetX(75); ($epatite=="NO"?$p->Write(8, "NO  "):$p->Write(8, "   ")); $p->Ln();
$p->Write(8, "ALTRO: "); $p->SetX(23); $p->Write(8, "$altro"); $p->Ln();
$p->Write(8, "NOTE PATOLOGIE: "); $p->SetX(38); $p->Write(8, "$notepat"); $p->Ln();
$p->Write(8, "ESAMI STRUMENTALI ESEGUITI: "); $p->SetX(57); $p->Write(8, "$esstrum"); $p->Ln();
$p->Write(8, "DATA: __________________ "); $p->SetX(25); $p->Write(8, "$dataprenotazione"); 
$p->SetX(50);$p->Write(8, "N.REGISTRO PRENOTAZIONE: _____________ "); $p->SetX(95);$p->Write(8, "$anno/$progressivo");
$p->SetX(115);$p->Write(8, "DATA PREVISTA RICOVERO: __________________ ");  $p->SetX(158);$p->Write(8, "$dtprevric"); $p->Ln();
$p->Ln();
$p->SetX(85); $p->Write(8, "MATR.MEDICO: __________ "); $p->SetX(108);$p->Write(8, "$codmedico"); 
$p->SetX(125); $p->Write(8, "FIRMA MEDICO: ________________________ "); $p->SetX(150);$p->Write(8, "$medico");$p->Ln();

	
// Mostra la pagina in PDF
$p->output();

// Funzioni comuni PHP
// Esegue la connessione al DB
function connect_to_db() {
  $user = "root";
  $passwd = "";
  $db = "esami";
  // Si connette al server MySql
  mysql_connect(localhost,$user,$passwd);
  // Seleziona il database 
  @mysql_select_db($db) or die( "Errore durante la selezione del database!");
}
?>
