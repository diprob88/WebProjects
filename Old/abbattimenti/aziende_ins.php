<?php 
ob_start();
include("./assets/php/check.php");
include("./assets/php/core.php");
 ?>

<!DOCTYPE html>
<html>
<head>
<title>Inserimento Azienda</title>
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
if(isset($_POST['registra_azienda'])) 
{
	
	$codazienda = strtoupper($_POST["codazienda"]);
	$azienda = $_POST["azienda"];
	
	if(mysql_num_rows(mysql_query("SELECT * FROM aziende WHERE codazienda LIKE '$codazienda'"))>0)
	{ 		
	header('Refresh: 5; url=aziende.php');  
		?>
        <div class="container">
        	<div class="row">
            	<div class="col-md-6 col-md-offset-3">
                <img class="img-responsive" src="assets/img/fail.png">
            	<br/>
                <h1 class="text-center" style="color:#337ab7">
				Azienda gi&agrave; presente nel database.<br/><br/><small>Attendi verrai reinderizzato alla pagina delle aziende</small>
            	</h1>
                </div>
       		 </div>
        </div>
            <?php
	}
	else
	{
		$sql = "insert into aziende(codazienda, azienda) values(";
		$sql.="'$codazienda', '$azienda')";
		mysql_query($sql) or die("Errore durante l'inserimento!");
		header('Refresh: 5; url=aziende.php');
	?>
    <br/>
    	<div class="container">
        	<div class="row">
            	<div class="col-md-6 col-md-offset-3">
                <img class="img-responsive" src="assets/img/successo.jpg">
            	<br/>
                <h1 class="text-center" style="color:#337ab7">
					Inserimento eseguito con successo.<br/><br/><small>Attendi verrai reinderizzato alla pagina delle aziende</small>
            	</h1>
                </div>
       		 </div>
        </div>
    
    <?php
		
	}
	mysql_close();	
	

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
                            	<h3 class="text-center"><span>Inserimento Aziende Sanitarie</span></h3>
								<h5 class="text-center">(I campi contrassegnati con * sono obbligatori)</h5>
                                <big><span>Utente:&nbsp;</big></span> 
                                <big><b><?php echo $_nome;?></big></b>
                            </div>
                            <div class="panel-body">
                            <form class="form-horizontal" role="form" method='post' action='<?php echo $_SERVER[PHP_SELF];?>'>
    							<div class="form-group">
    								<label class="control-label col-sm-4">Codice:*</label>
    								<div class="col-sm-4">
										<input class="form-control" type='text' name='codazienda' placeholder="Inserisci Codice" required/></td>
    								</div>
 		 						</div>
                                <div class="form-group">
    								<label class="control-label col-sm-4">Azienda Sanitaria:*</label>
    								<div class="col-sm-4">
										<input class="form-control" type='text' name='azienda' placeholder="Inserisci Azienda" required/></td>
    								</div>
 		 						</div>                            
         						<div class="form-group"> 
    								<div class="col-sm-offset-2 col-sm-10">
      									<button type="submit" name="registra_azienda" class="btn btn-default">Inserisci</button>
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