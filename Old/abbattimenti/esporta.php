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
<title>Esporta Abbattimenti</title>
<link rel="shortcut icon" href="./assets/img/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap-theme.css">
<script type="text/javascript" src="./assets/js/jquery-1.11.3.js"></script>
<script type="text/javascript" src="./assets/js/bootstrap.js"></script>
<link href="./assets/css/simple-sidebar.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="./assets/css/mycss.css" />
<link rel="stylesheet"  href="./assets/css/jquery-ui.css">

<script type="text/javascript" src="./assets/js/jquery-ui.js"></script>
<script>
    $(function() {
        $( "#datepicker" ).datepicker();
		$( "#datepicker2" ).datepicker();
    });
</script>
<script type="text/javascript" src="./assets/js/ui.datepicker-it.js" ></script>    
<script type="text/javascript">    
    $(function() {
	$.datepicker.setDefaults($.datepicker.regional['it']);
	$(".data:input").datepicker();
});
</script>   
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
  <div class="col-md-12">
             <?php
			if(isset($_POST["filtro"])) 
			{
				$inizio = $_POST['inizio'];
				$inizio=convertiData($inizio);
				$fine = $_POST["fine"];
				$fine=convertiData($fine);
				$codazienda = $_POST['azienda'];
				
			}
			else 
			{
				/*select * from hockey_stats 
where game_date between '11/3/2012 00:00:00' and '11/5/2012 23:59:00' 
order by game_date desc;*/
				$inizio = "*";
				$fine = "*";
			}
		$sql="select * from calcolo order by numero_cartella ";
			$result = mysql_query($sql);
			
			?>  
     <div class="col-md-6 col-md-offset-3">                  <!-- questo è la parte dove mettere tutto-->
 	<div class="panel panel-primary">	
    	<div class="panel-heading">
			<h2 class="text-center">Esporta Abbattimenti</h2>
    		</div>
    <div class="panel-body">  
    <div class="col-md-8 col-md-offset-2">
	<form class="form-horizontal" role="form" method='post' action='<?php echo $_SERVER[PHP_SELF];?>'>
    	<div class="form-group">
    		<label class="control-label col-sm-4">Dal:</label>
    			<div class="col-sm-6">
     				<input type='text' class="form-control" id="datepicker" name="inizio" value='*' />
    			</div>
 		 </div>
         <div class="form-group">
    		<label class="control-label col-sm-4">Al:</label>
    			<div class="col-sm-6">
     				<input type='text' class="form-control" id="datepicker2" name="fine" value='*' />
    			</div>
 		 </div>
         <div class="form-group">
    		<label class="control-label col-sm-4">Azienda:</label>
				<div class="col-sm-6">
					<select class="form-control" name="azienda" required>
					<?php
					$sql="select * from aziende order by azienda ";
					$result = mysql_query($sql);
					while ($row = mysql_fetch_array($result)) 
					{	
						$codazienda = $row["codazienda"];
						$azienda = $row["azienda"];
						?>
						<option value='<?php echo $codazienda;?>'><?php echo $azienda;?></option>
						<?php
					}
					?>
					</select>
				</div>
 		 </div>
         <div class="form-group"> 
    		<div class="col-sm-offset-4 col-sm-6">
      			<button type="submit" name="filtro" class="btn btn-default">Filtra</button>
    		</div>
  		</div>
	</form>
    </div>
    </div>
	</div>
    
    </div>
    <div class="col-md-12">
    <p> <a href="assets/php/elaborazioni/esporta_tabella.php?inizio=<?php echo $inizio; ?>&fine=<?php echo $fine; ?>"><span class="glyphicon glyphicon-download-alt" style="font-size: 20px;">&nbsp;Esporta</span></a>	</p>
    </div>
     <?php	
	// filtro
	if(($inizio=="*")&&($fine=="*"))
	{
		$sql="select * from calcolo  order by numero_cartella ";
		
	}
	else 
	{
		/*select * from hockey_stats 
where game_date between '11/3/2012 00:00:00' and '11/5/2012 23:59:00' 
order by game_date desc;

*/
		$sql="select * 
				from calcolo, unitaoperativa, presidi, aziende
				where calcolo.coduo = unitaoperativa.coduo 
				and unitaoperativa.codpresidio = presidi.codpresidio 
				and presidi.codazienda = aziende.codazienda
				and aziende.codazienda = '$codazienda'
				and data_calcolo between '$inizio' and '$fine' ";
		//print "$sql<br>";
		
	}	
	$result = mysql_query($sql);
	?>
    
    
	
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
            
          
    <!-- chiude md12-->
    </div>
    
        
                      <!-- chiude row-->
                </div>
                    <!-- chiude container-->
            </div>
                <!-- chiude page-wrapper-->

        </div>
    <!-- chiude wrapper-->

    </div>
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