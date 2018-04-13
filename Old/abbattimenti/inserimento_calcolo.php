<?php 
include("./assets/php/check.php");
include("./assets/php/core.php");
/*
Convertire la data da formato europeo (gg/mm/aaaa) 
in formato americano (aaaa-mm-gg) per inserirla in una tabella MySQL
*/
function convertiData($dataEur)
{
$rsl = explode ('/',$dataEur);
$rsl = array_reverse($rsl);
return implode($rsl,'-');
}

//fa il contrario della funziona di prima
function convertiData2($dataEur)
{
$rsl = explode ('-',$dataEur);
$rsl = array_reverse($rsl);
return implode($rsl,'/');
}

 ?>

<!DOCTYPE html>
<html>
<head>
<title>Calcolo Abbattimenti</title>
<link rel="shortcut icon" href="./assets/img/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap-theme.css">
<script type="text/javascript" src="./assets/js/jquery-1.11.3.js"></script>
<script type="text/javascript" src="./assets/js/bootstrap.js"></script>
<link href="./assets/css/simple-sidebar.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="./assets/css/mycss.css" />
<script type="text/javascript" src="./assets/js/ajax.js"></script>

</head>

<body>
  
  
 <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">  
       		<?php include("./assets/php/navigation.php");?>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
            	<header>
					<?php include("./assets/php/header.php");?>
                </header>
            
                <a href="#menu-toggle" id="menu-toggle"><img id="aprimenu" src="assets/img/menu.png" width="50px" height="50px"></a>

                <div class="row">
                <?php
				
  					$data=$_POST['data'];
					$data2=convertiData($data);
  					$anno=$_POST['anno'];
					
				?>
          <div class="col-md-10 col-md-offset-1">
                       <!-- questo è la parte dove mettere tutto-->
 						
                        <div class="panel panel-primary">
  				<div class="panel-heading">
  					<div class="row">
  						<div class="col-md-6">
  							<p class="text-center">Data Calcolo:&nbsp <?php echo $data;?></p>
                             <input type='hidden' id="data_calcolo" value='<?php echo $data2;?>'/>	
  						</div>

  						<div class="col-md-6">
  							<p class="text-center">Anno:&nbsp<?php echo $anno?></p>
                             <input type='hidden' id="anno_calcolo" value='<?php echo $anno;?>'/>	
  						</div>

  					</div>			
  				</div>

  				<div class="panel-body">
  					<form >
  					<div class="row">
  						<div class="col-md-4 ">
  							<label><p class="text-center">Unit&agrave Operativa</p></label>
							<?php
							//echo $_ruolo;
							if($_ruolo=='A')
							{
								$sql = "select * from unitaoperativa, presidi, aziende 
										where unitaoperativa.codpresidio = presidi.codpresidio 
										and presidi.codazienda = aziende.codazienda										
										order by unitaoperativa";
							}
							else if($_ruolo=='P')
							{
								$sql = "select * from unitaoperativa, presidi, aziende 
										where aziende.codazienda LIKE '$_codazienda' 
										and unitaoperativa.codpresidio = presidi.codpresidio 
										and presidi.codazienda = aziende.codazienda																			
										order by unitaoperativa";
							}
							else if($_ruolo=='U')
							{
								
								$sql = "select * from unitaoperativa,presidi, aziende
								where unitaoperativa.codpresidio = '$_codpresidio'
								and unitaoperativa.codpresidio = presidi.codpresidio
								and presidi.codazienda = aziende.codazienda
								order by unitaoperativa";
							}
								//echo "$sql<br>";
							?>
    						<select class="form-control" name="unita" required id="operativa">
								<option value="">--Seleziona--</option>	
								<?php
								include("./inc/core.php"); 

								$res = mysql_query($sql);
								$res1= mysql_num_rows($sql);
								while($row = mysql_fetch_array($res)) 
								{
									$coduo = $row["coduo"];
									$unitaoperativa = $row["unitaoperativa"];
									$codpresidio = $row["codpresidio"];
									$codazienda = $row["codazienda"];
								?>
								<option value="<?php echo $coduo;?>"><?php echo "$unitaoperativa - $codpresidio - $codazienda";?></option>
								<?php
								}
								?>
							</select>
							
  						</div>
  						<div class="col-md-2">
  							<label class="text-center"><p class="text-center">Numero Cartella</p></label>
    						<input class="form-control" id="numero_cartella" type="number" min="0" value="0" required="required">
  						</div>
  						<div class="col-md-2">

  							<label class="text-center"><p class="text-center">Giorni Da Appropriare</p></label>
    						<input class="form-control" id="giorni_app" type="number" min="0" max="365" step="1" value="0" onchange="nascondiradio()" required="required" >
  						</div>
  						<div class="col-md-2">
  							<label class="text-center"><p class="text-center">Giorni Inappropriati</p></label>
    						<input class="form-control" id="giorni_non_app" class="form-control" type="number" min="0" max="365" step="1" value="0" required="required">
  						</div>
  						<div class="col-md-2">
  							<label class="text-center"><p class="text-center">Punteggio ottenuto</p></label>
    						<input class="form-control" type="number" id="punteggio" min="0" max="100" step="1" value="0" name="punteggio" required="required">
  						</div>
  					</div>
  						
					<br><br><br>

					<div class="row">
					<div class="col-md-2 ">
  							<label class="text-center">DRG</label>
    						<select id="unita_drg" class="form-control" name="drg" onchange="showUser(this.value)">
								<option value="">--Seleziona--</option>	
								<?php

								$sql = "select drg,descrizione from tariffario order by drg";
								$res = mysql_query($sql);
								while($row = mysql_fetch_array($res)) 
								{
									$drg = $row["drg"];
									$descrizione = $row["descrizione"];
								?>
								<option value="<?php echo $drg;?>"><?php echo $drg;?></option>
								<?php
								}
								?>
							</select>
							
  					</div>
  				
  				<div class="col-md-10" id="cambia_div">
  					<div class="col-md-4">
  						<label class="text-center" id="tariffario_descrizione">Descrizione</label>
              <input type="text" value="" class="form-control" id="descrizione" readonly>
  					</div>
  					<div class="col-md-2">
  						<label class="text-center" id="tariffario_ro1" >ro>1</label>
              <input type="number" class="form-control" value="0" id="ro1" readonly>
              <input type="radio" name="selezione_calcolo" value="ro>1" onchange="calcola(this.value)"/> 

  					</div>
  					<div class="col-md-2">
  						<label class="text-center" id="tariffario_ro" >r01</label>
              <input type="number" class="form-control" value="0" id="ro01" readonly>
              <input type="radio" id="radioro01" name="selezione_calcolo" value="ro0-1" onchange="calcola(this.value)"/> 

  					</div>
  					<div class="col-md-2">
  						<label class="text-center" id="tariffario_dh">dh</label>
              <input type="number" class="form-control" value="0" id="dh" readonly>
              <input type="radio" name="selezione_calcolo" value="dh0-1" onchange="calcola(this.value)"/> 
  					</div>
  					<div class="col-md-2">
  						<label class="text-center" id="tariffario_ds">ds</label>
              <input type="number" class="form-control" value="0" id="ds" readonly>
              <input type="radio" id="radiods" name="selezione_calcolo" value="ds" onchange="calcola(this.value)"/> 

  					</div>
  				</div>
				</div>

				<br><br>
				<div class="row" id="dati_abbattimento">
				  <div class="col-md-4">
            <div class="row">
              <div class="col-md-8 col-md-offset-2">
                <label>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspRimborso:</label>
                <input type="number" class="form-control" value="0" size="10" id="rimborso" readonly>
              </div>
              <div class="col-md-8 col-md-offset-2">
                  <label>Punteggio Abbattimento:&nbsp</label>
                  <input type="number" class="form-control" value="0" size="10" id="punteggio_abbattimento" readonly>
              </div>
            </div>


            
					   <!-- questo div sotto chiude row-->
				  </div>
				  <div class="col-md-8">
				    <h1 class="text-center">Abbattimento</h1><br><br>
            <div class="col-md-6 col-md-offset-3">
				        <input type="number" class="form-control" value="0" id="abbattimento" readonly><br><br>
            </div>
				
				  </div>
          <!-- questo div sotto chiude dati_ababttimento-->
          <div class="col-md-8 col-md-offset-4">
            <button type="button" class="btn btn-primary" >Invia Calcolo</button>
            <button type="button" class="btn btn-primary" onclick="resetta()">Nuovo Calcolo</button>
        </div>
				</div>

        
				</form>

  				<!-- questo div sotto chiude panel body-->
  				</div>


 				<!-- questo div sotto chiude panel -->
  			</div>
                        
           
                        
                    </div>
                      <div class="col-md-12" id="calcolo_effettuati">            
				<table class="table">
				<tr>
				<th bgcolor='#6495ED'><p class="text-center">Numero Cartella</p></th>
				<th bgcolor='#6495ED'><p class="text-center">Unit&agrave; Operativa</p></th>
                <th bgcolor='#6495ED'><p class="text-center">Data Calcolo</p></th>
                <th bgcolor='#6495ED'><p class="text-center">DRG</p></th>
                <th bgcolor='#6495ED'><p class="text-center">Selezione</p></th>
				<th bgcolor='#6495ED'><p class="text-center">Valore</p></th>
				<th bgcolor='#6495ED'><p class="text-center">Giorni Appropriati</p></th>
				<th bgcolor='#6495ED'><p class="text-center">Giorni Non Appropriati</p></th>
				<th bgcolor='#6495ED'><p class="text-center">Punteggio Abbattimento</p></th>
                <th bgcolor='#6495ED'><p class="text-center">Abbattimento</p></th>
				<th bgcolor='#6495ED'><p class="text-center">Rimborso</p></th>           
				</tr>			
				<?php	
				$sql="select * from calcolo WHERE anno_calcolo LIKE '$anno' order by numero_cartella ";
				$result = mysql_query($sql);								
				while ($row = mysql_fetch_array($result)) 
				{		
					$numcart = $row["numero_cartella"];
					$codunita = $row["coduo"];
					$sql2="select * from unitaoperativa WHERE coduo LIKE '$codunita'";
					$ris = mysql_query($sql2);
					$row2=mysql_fetch_array($ris);
					$unitadesc=$row2[1];
					$datacal=$row["data_calcolo"];
					$datacal=convertiData2($datacal);
					$drgcalcolo=$row["drg"];
					$selezione=$row["selezione"];
					$valore=$row["valore"];
					$ga=$row["giorni_app"];
					$gna=$row["giorni_non_app"];
					$pa=$row["punteggio_abbattimento"];
					$abb=$row["abbattimento"];
					$rim=$row["rimborso"];
					
					?>					
				<tr>
		
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><p class="text-center"><?php echo $numcart;?></p></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><p class="text-center"><?php echo $unitadesc;?></p></td>
        <td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><p class="text-center"><?php echo $datacal;?></p></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><p class="text-center"><?php echo $drgcalcolo;?></p></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><p class="text-center"><?php echo $selezione;?></p></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><p class="text-center"><?php echo $valore;?></p></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><p class="text-center"><?php echo $ga;?></p></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><p class="text-center"><?php echo $gna;?></p></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><p class="text-center"><?php echo $pa;?></p></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><p class="text-center"><?php echo $abb;?></p></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><p class="text-center"><?php echo $rim;?></p></td>

        </tr>
		<?php	
		$i++;			
				}
				?>	
			</table>
            <br> <br> 
             </div>      
                    <br> <br> <br> <br> <br>
                    
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->
    <br><br>
<footer>
	<?php include("./assets/php/footer.php");?>
</footer>
    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>


</body>
</html>