<?php
ob_start(); 
include("./assets/php/check.php");
include("./assets/php/core.php");
 ?>

<!DOCTYPE html>
<html>
<head>
<title>Modifica Presidi Ospedalieri</title>
<link rel="shortcut icon" href="./assets/img/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap-theme.css">
<script type="text/javascript" src="./assets/js/jquery-1.11.3.js"></script>
<script type="text/javascript" src="./assets/js/bootstrap.js"></script>
<link href="./assets/css/simple-sidebar.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="./assets/css/mycss.css" />
</head>

<body>
  <?php
// estrae il nome utente registrato come variabile di sessione   
$_nome = $_SESSION["_nome"];
$codpresidio = $_GET["codpresidio"];
// estrae i dati completi dei presidi
$sql="select * from presidi where codpresidio='".$codpresidio."'";	
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$presidio = $row["presidio"];
$codazienda_old = $row["codazienda"];
if(isset($_POST['modifica_presidio'])) 
{
	
	$codpresidio = $_POST["codpresidio"];
	$presidio = $_POST["presidio"];
	$azienda = $_POST["azienda"];
	// Esegue la query di modifica
	$sql = "update presidi set presidio='$presidio', codazienda='$azienda' ";
	$sql.="where codpresidio='$codpresidio'";
	
	mysql_query($sql) or die("Errore durante la modifica dei dati del presidio ospedaliero!");
	header('Refresh: 5; url=presidi.php');  

	?>
        <div class="container">
        	<div class="row">
            	<div class="col-md-6 col-md-offset-3">
                <img class="img-responsive" src="assets/img/edit.png">
            	<br/>
                <h1 class="text-center" style="color:#337ab7">
					Modifica Completata.<br/><br/><small>Attendi verrai reinderizzato alla pagina Presidi</small>
            	</h1>
                </div>
       		 </div>
        </div>
            <?php
	

}
else 
{
// HTML ?>
  
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
                    <div class="col-md-6 col-md-offset-3">
                      	<div class="panel panel-primary">
                        	<div class="panel-heading">
                            	<h3 class="text-center"><span>Modifica Presidi Ospedalieri</span></h3>
								<h5 class="text-center">(I campi contrassegnati con * sono obbligatori)</h5>
                                <big><span>Utente:&nbsp;</big></span> 
                                <big><b><?php echo $_nome;?></big></b>
                            </div>
                            <div class="panel-body">
                            <form class="form-horizontal" role="form" method='post' action='<?php echo $_SERVER[PHP_SELF];?>'>
    							<div class="form-group">
    								<label class="control-label col-sm-4">Codice:*</label>
    								<div class="col-sm-4">
									<input class="form-control" type='text' name='codpresidio' value="<?php echo $codpresidio;?>" readonly />
    								</div>
 		 						</div>
                                <div class="form-group">
    								<label class="control-label col-sm-4">Presidio Ospedaliero*</label>
    								<div class="col-sm-4">
										<input class="form-control" type='text' name='presidio' value='<?php echo $presidio;?>' required/></td>
    								</div>
 		 						</div>   
                                 <div class="form-group">
    								<label class="control-label col-sm-4">Azienda Sanitaria*</label>
                                    <div class="col-md-4">
    								<select class="form-control " name="azienda" required>
										<option value="">--Seleziona--</option>	
										<?php
										$sql = "select * from aziende order by azienda";
										$res = mysql_query($sql);
										while($row = mysql_fetch_array($res)) 
										{
											$codazienda = $row["codazienda"];
											$azienda = $row["azienda"];
										?>
		<option value="<?php echo $codazienda;?>" <?php echo ($codazienda==$codazienda_old?'selected':'');?>><?php echo $azienda;?></option>
										<?php
										}
										?>
									</select>
                                    </div>
 		 						</div>                          
         						<div class="form-group"> 
    								<div class="col-sm-offset-2 col-sm-10">
      									<button type="submit" name="modifica_presidio" class="btn btn-default">Modifica</button>
    								</div>
  								</div>
							</form>
                            </div>
                        </div>
                      
                      
                      
                      
 						
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

<?php }?>
</body>
</html>