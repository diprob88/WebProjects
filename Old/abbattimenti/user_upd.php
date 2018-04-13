<?php 
ob_start();
include("./assets/php/check.php");
include("./assets/php/core.php");
$_nome = $_SESSION["_nome"];
$_ruolo = $_SESSION["_ruolo"];
$_codazienda = $_SESSION["_codazienda"];
$_codpresidio = $_SESSION["_codpresidio"];
$nome = $_GET["nome"];
// estrae i dati completi dell'utente
$sql = "select * from utenti where nome='".$nome."'";	
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$ruolo = $row["ruolo"];
$codazienda1 = $row["codazienda"];
$codpresidio1 = $row["codpresidio"];
$email = $row["email"];
 ?>

<!DOCTYPE html>
<html>
<head>
<title>Modifica dati Utente</title>
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
if(isset($_POST['modifica_utente'])) 
{
	
	$nome = $_POST["_nome"];
	$email = $_POST["email"];
	$ruolo = $_POST["ruolo"];
	$codazienda=$_POST["codazienda"];
	$codpresidio=$_POST["codpresidio"];
	
	
	
	
	$sql = "update utenti set ruolo='$ruolo',codazienda='$codazienda',codpresidio='$codpresidio',email='$email' ";
	$sql.="where nome='$nome'";
	//print $sql; exit();

	mysql_query($sql) or die("Errore durante la modifica dei dati dell'utente!");
	header('Refresh: 5; url=user.php');  

	?>
        <div class="container">
        	<div class="row">
            	<div class="col-md-6 col-md-offset-3">
                <img class="img-responsive" src="assets/img/edit.png">
            	<br/>
                <h1 class="text-center" style="color:#337ab7">
					Modifica Completata.<br/><br/><small>Attendi verrai reinderizzato alla pagina utenti</small>
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
                            	<h3 class="text-center"><span>Modifica dati Utente</span></h3>
								<h5 class="text-center">(I campi contrassegnati con * sono obbligatori)</h5>
                                <big><span>Utente:&nbsp;</big></span> 
                                <big><b><?php echo $_nome;?></big></b>
                            </div>
                            <div class="panel-body">
                            <form class="form-horizontal" role="form" method='post' action='<?php echo $_SERVER[PHP_SELF];?>'>
    							<div class="form-group">
    								<label class="control-label col-sm-4">Username:*</label>
    								<div class="col-sm-4">
										<input type='text' class="form-control" name='nome' value="<?php echo $nome;?>"disabled />
    								</div>
 		 						</div>                                                       
                                <div class="form-group">
    								<label class="control-label col-sm-4">Ruolo*</label>
                                    <div class="col-md-4">
    									<select class="form-control " name="ruolo" required>
								<?php if($_ruolo=='A') { ?> <option value="A" <?php echo ($ruolo=='A'?'selected':'');?>>Amministratore</option> <?php } ?>
						<?php if($_ruolo=='A') { ?> <option value="P" <?php echo ($ruolo=='P'?'selected':'');?>>Utente con privilegi</option> <?php } ?>
								<option value="U" <?php echo ($ruolo=='U'?'selected':'');?>>Utente</option>
								<option value="C" <?php echo ($ruolo=='C'?'selected':'');?>>Utente per prenotazioni</option>
										</select> 
                                    </div>
                                </div>
                                   
                                 <div class="form-group">
    								<label class="control-label col-sm-4">Azienda Sanitaria*</label>
                                    <div class="col-md-4">
    								<select class="form-control " name="codazienda"  required>
										<option value="">--Seleziona--</option>	
										<?php
										$sql = "select * from aziende order by azienda";
										$res = mysql_query($sql);
										while($row = mysql_fetch_array($res)) 
										{
											$codazienda = $row["codazienda"];
											$azienda = $row["azienda"];
										?>
		<option value="<?php echo $codazienda;?>" <?php echo ($codazienda==$codazienda1?'selected':'');?>><?php echo $azienda;?></option>
										<?php
										}
										?>
									</select>
                                    </div>
 		 						</div>  
                                <div class="form-group">
    								<label class="control-label col-sm-4">Presidio Ospedaliero*</label>
                                    <div class="col-md-4">
    								<select class="form-control " name="codpresidio"  required>
										<option value="">--Seleziona--</option>	
										<?php
										$sql = "select * from presidi order by presidio";
										$res = mysql_query($sql);
										while($row = mysql_fetch_array($res)) 
										{
											$codpresidio = $row["codpresidio"];
											$presidio = $row["presidio"];
										?>
		<option value="<?php echo $codpresidio;?>" <?php echo ($codpresidio==$codpresidio1?'selected':'');?>><?php echo $presidio;?></option>
										<?php
										}
										?>
									</select>
                                    </div>  
                                   </div>
                                  <div class="form-group">
    								<label class="control-label col-sm-4">E-mail</label>
    								<div class="col-sm-4">
										<input class="form-control" type="email" value='<?php echo $email;?>' name="email" placeholder="E-Mail" />
    								</div>
 		 						</div>                      
         						<div class="form-group"> 
    								<div class="col-sm-offset-2 col-sm-10">
                                    	<input type='hidden' name='_nome' value='<?php echo $nome;?>'/>	
      									<button type="submit" name="modifica_utente" class="btn btn-default">Modifica</button>
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