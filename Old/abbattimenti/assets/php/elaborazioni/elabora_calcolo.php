<?php
include("../core.php");

/*funzione PHP per arrotondare
round($numero, 1)
*/


$punteggio = $_GET['punteggio'];
$abbattimento=round($_GET['abb'],2);
$rimborso=round($_GET['rimb'],2);


?>

<div class="col-md-4">
            <div class="row">
              <div class="col-md-8 col-md-offset-2">
                <label>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspRimborso:</label>
                <input type="number" class="form-control" value="<?php echo $rimborso?>" size="10" id="rimborso" readonly>
              </div>
              <div class="col-md-8 col-md-offset-2">
                  <label>Punteggio Abbattimento:&nbsp</label>
                  <input type="number" class="form-control" value="<?php echo $punteggio?>" size="10" id="punteggio_abbattimento" readonly>
              </div>
            </div>


            
					   <!-- questo div sotto chiude row-->
				  </div>
				  <div class="col-md-8">
				    <h1 class="text-center">Abbattimento</h1><br><br>
            <div class="col-md-6 col-md-offset-3">
				        <input type="number" class="form-control" value="<?php echo $abbattimento?>" id="abbattimento" readonly><br><br>
            </div>
				
                
				  </div>
<div class="col-md-8 col-md-offset-4">
            <button type="button" class="btn btn-primary" onclick="inserisci_dati()">Invia Calcolo</button>
            <button type="button" class="btn btn-primary" onclick="resetta()">Nuovo Calcolo</button>
        </div>