

<?php 

include("../core.php");


$drg = $_GET['drg'];

$sql = "select * from tariffario where drg='$drg'";
$res = mysql_query($sql);
$row = mysql_fetch_array($res);
?>

					<div class="col-md-4">
  						<label class="text-center" id="tariffario_descrizione">Descrizione</label>
              <input type="text" value="<?php echo $row[1]?>" class="form-control" id="descrizione" readonly>

  

  					</div>
  					<div class="col-md-2">
  						<label class="text-center" id="tariffario_ro1" >ro>1</label>
              <input type="number" class="form-control" id="ro1" value="<?php echo $row[2]?>" readonly>

  						<input type="radio" id="radior1" name="selezione_calcolo" value="ro>1" onchange="calcola(this.value)"/> 

  					</div>
  					<div class="col-md-2">
  						<label class="text-center" id="tariffario_ro" >ro0-1</label>
              <input type="number" class="form-control" id="ro01" value="<?php echo $row[3]?>" readonly>
              <input type="radio" name="selezione_calcolo" id="radioro01" value="ro0-1" onchange="calcola(this.value)"/>               
  					</div>
  					<div class="col-md-2">
  						<label class="text-center" id="tariffario_dh">dh0-1</label>
              <input type="number" class="form-control" id="dh" value="<?php echo $row[4]?>" readonly>
              				 <input type="hidden" id="tipo" value="<?php echo $row[7]?>">
  						<input type="radio" name="selezione_calcolo" value="dh0-1" onchange="calcola(this.value)"/> 
                        <?php if($row[5]!=0)
						{?>
                        <input type="checkbox" id="checkbox" onchange="nascondicheck()" value="<?php echo $row[5]?>" /><small>Cambio Setting</small>
						<?php
                        }
						?>
  					</div>
  					<div class="col-md-2">
  						<label class="text-center" id="tariffario_ds">ds</label>
              <input type="number" class="form-control" id="ds" value="<?php echo $row[5]?>" readonly>         
  						<input type="radio" name="selezione_calcolo" id="radiods" value="ds" onchange="calcola(this.value)"/> 
  					</div>