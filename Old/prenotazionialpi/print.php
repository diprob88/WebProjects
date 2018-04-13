<?php

// Costanti e classi per la creazione di file PDF
define('FPDF_FONTPATH', 'fpdf/font/');
require('fpdf/fpdf.php');

// Crea una pagina PDF vuota
$p = new fpdf();
$p->Open();
$p->AddPage();
// Imposta il font di default
$p->SetFont('Arial', '', 10);

$progressivo = $_GET["progressivo"];
$anno = $_GET["anno"];

// estrae dal db i dati della prenotazione e della scheda di prericovero
connect_to_db();
$sql="select p.id, p.cognome, p.nome, p.datanascita, uo.codiceunitaoperativa, uo.unitaoperativa, codiceasa, ep.datarichiesta, dataprenotazione,
		ep.coddiagnosi, ep.codintervento, codmedico, codmedicoan, codmedicoca, dataanticiporic, noteantric, noricovero, notenoric, note, altri, completato
	from prenotazioni as ep, pazienti as p, unitaoperativa as uo, diagnosi as d, medici as m
	where ep.progressivo = $progressivo 
	and ep.anno = '$anno'
	and ep.id_pazienti = p.id
	and ep.codiceunitoperativa = uo.codiceunitaoperativa
	and ep.coddiagnosi = d.coddiagnosi
	and ep.codmedico = m.codmedico";
	
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
// dati della diagnosi
$diagnosi = $row["diagnosi"];
// dati della unità operativa
$unitaoperativa = $row["unitaoperativa"];
// dati del medico
$medico = $row["medico"];
// dati del prericovero
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
$esstrum = $row["esstrum"];

// Imposta il font di default
$p->SetFont('Arial', 'B', 8);
// Stampa i dati anagrafici e di ricovero
$p->Cell(80); $p->Cell(30,5,'Regione Siciliana',0,0,'C'); $p->Ln(); // centrato
$p->Cell(80); $p->Cell(30,5,'Azienda Ospedaliero Universitaria Policlinico - Vittorio Emanuele',0,0,'C'); $p->Ln();
$p->Cell(80); $p->Cell(30,5,'Catania',0,0,'C'); $p->Ln(); $p->Ln();
$p->SetFont('Arial', 'B', 10);
$p->Cell(80); $p->Cell(30,5,'D I R E Z I O N E   M E D I C A',0,0,'C'); $p->Ln();
$p->Cell(80); $p->Cell(30,5,'P.O. VITTORIO EMANUELE',0,0,'C'); $p->Ln(); $p->Ln(); 
$p->Cell(80); $p->Cell(30,5,'S E R V I Z I O   D I   P R E - R I C O V E R O',0,0,'C'); $p->Ln();
$p->SetFont('Arial', 'B', 8);
$p->Cell(80); $p->Cell(30,5,'COMMA 18 Art. 1 Legge 662 del 23 dicembre 1996',0,0,'C'); $p->Ln();
$p->SetFont('Arial', 'B', 6);
$p->Cell(80); $p->Cell(30,5,'............................................................................................',0,0,'C'); $p->Ln(); $p->Ln(); $p->Ln(); $p->Ln();
$p->SetFont('Arial', 'B', 10);
$p->Write(8, "UNITA' OPERATIVA di: $unitaoperativa"); $p->Ln();
//$p->Write(8, "Data Pre-ricovero: $datarichiesta"); $p->Ln();
$p->Write(8, "Il Paziente: $cognome $nome, nato il $datanascita, affetto da:"); $p->Ln();
//$p->Write(8, "Nato il: $datanascita ha "); $p->Ln();
//$p->Write(8, "Data Prenotazione: '$dataprenotazione'"); $p->Ln();

//$p->Write(8, "Data Anticipo Ricovero: '$dataanticiporic'"); $p->Ln();
//$p->Write(8, "Motivo Anticipo Ricovero: '$noteantric'"); $p->Ln();

// Stampa la diagnosi
//$p->Write(8, "DIAGNOSI: ");
$sql="select * from diagnosi where coddiagnosi = '$_coddiagnosi'";	
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$diagnosi = $row["diagnosi"];	
$p->Write(8, $diagnosi); $p->Ln();

$p->Write(8, "ha effettuato in data $datarichiesta un Pre-ricovero per un intervento chirurgico di:"); $p->Ln();

// Stampa l'intervento
$p->Write(8, " ");
$sql="select * from interventi WHERE codintervento = '$_codintervento'";	
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$intervento = $row["intervento"];	
$p->Write(8, $intervento); $p->Ln();

// Stampa la classificazione ASA
$p->Write(8, "Classificazione ASA: ");
$sql="select * from asa where codiceasa = '$_codiceasa'";	
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$asa = $row["asa"];	
$p->Write(8, $asa); $p->Ln(); $p->Ln(); $p->Ln(); $p->Ln();

// Stampa il medico chirurgo
//$p->Write(8, "MEDICO CHIRURGO: ");
//$sql="select * from medici where codmedico = '$_codmedico'";	
//$result = mysql_query($sql);
//$row = mysql_fetch_array($result);
//$medico = $row["medico"];	
//$p->Write(8, $medico); $p->Ln();

// Stampa il medico anestesista
$p->Write(8, "Il Medico Anestesista: ");
$sql="select * from medici_an where codmedicoan = '$_codmedicoan'";	
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$medicoan = $row["medicoan"];	
$p->Write(8, $medicoan); $p->Ln();

// Stampa il medico cardiologo
//$p->Write(8, "MEDICO CARDIOLOGO: ");
//$sql="select * from medici_ca where codmedicoca = '$_codmedicoca'";	
//$result = mysql_query($sql);
//$row = mysql_fetch_array($result);
//$medicoca = $row["medicoca"];	
//$p->Write(8, $medicoca); $p->Ln();

// Stampa l'elenco degli esami già prescritti
//$p->Write(8, "ELENCO ESAMI PRESCRITTI: ");
//$sql="select e.* 
//from esami_pazienti ep, esami e
//where ep.codiceesame = e.codice
//and ep.id_pazienti = $id 
//and ep.datarichiesta = '$dt'
//order by tipo";
//$result = mysql_query($sql);
//while($row = mysql_fetch_array($result)) {
	//$codice = $row["codice"];
	//$descrizione = $row["descrizione"];	
	//$tipo = $row["tipo"];
	//$es_pre[] = $codice;
	//$p->Write(8, "$descrizione - $tipo"); 
//}
$p->Ln();

//$p->Write(8, "Altri: '$altri'"); $p->Ln();
//$p->Write(8, "Note: '$note'"); $p->Ln();
//$p->Write(8, "Ricovero annullato: '$noricovero'"); $p->Ln();
//$p->Write(8, "Motivo dell'annullamento: '$notenoric'"); $p->Ln();
//$p->Write(8, "Completato: '$completato'"); $p->Ln();
	
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
