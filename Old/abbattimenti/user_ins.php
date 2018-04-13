<?php 
ob_start();
include("./assets/php/check.php");
include("./assets/php/core.php");
$_nome = $_SESSION["_nome"];
$_ruolo = $_SESSION["_ruolo"];
$_codazienda = $_SESSION["_codazienda"];
$_codpresidio = $_SESSION["_codpresidio"];
 ?>

<!DOCTYPE html>
<html>
<head>
<title>Inserimento Utente</title>
<link rel="shortcut icon" href="./assets/img/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap-theme.css">
<script type="text/javascript" src="./assets/js/jquery-1.11.3.js"></script>
<script type="text/javascript" src="./assets/js/bootstrap.js"></script>
<link href="./assets/css/simple-sidebar.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="./assets/css/mycss.css" />
</head>

<script type="text/x-javascript">

	function amministratore()
	{
		var valore = $("select[name=ruolo]").val();
		if (valore=="A")
		{
			 $("#_azienda").removeAttr("required");
			  $("#_presidio").removeAttr("required");
			//$('#_azienda').prop('required', false);
			//$('#_presidio').prop('required', false);
		}
		else if (valore=="P")
		{
			$("#_azienda").attr("required",true);
			$("#_presidio").removeAttr("required");
			//$('#_presidio').attr('required', true);
			//$('#_azienda').prop('required', true);
			//$('#_presidio').prop('required', true);
		}
		else if (valore=="U")
		{
			$("#_azienda").attr("required",true);
			$('#_presidio').attr('required', true);
			//$('#_azienda').prop('required', true);
			//$('#_presidio').prop('required', true);
		}
	}
</script>
<body>
  <?php
// estrae il nome utente registrato come variabile di sessione   
$_nome = $_SESSION["_nome"];
if(isset($_POST['registra_utente'])) 
{
	
	$nome = $_POST["nome"];
	$email = $_POST["email"];
	$password = $_POST["password"];
	$ruolo = strtoupper($_POST["ruolo"]);
	$codazienda = $_POST["codazienda"];
	$codicepresidio = $_POST["presidio"];
	
	if(mysql_num_rows(mysql_query("SELECT * FROM utenti WHERE nome LIKE '$nome'"))>0)
	{ 	
	header('Refresh: 5; url=user.php');  
		?>
        
        <div class="container">
        	<div class="row">
            	<div class="col-md-6 col-md-offset-3">
                <img class="img-responsive" src="assets/img/fail.png">
            	<br/>
                <h1 class="text-center" style="color:#337ab7">
				Utente gi&agrave; presente nel database.<br/><br/><small>Attendi verrai reinderizzato alla pagina utenti.</small>
            	</h1>
                </div>
       		 </div>
        </div>
            <?php
	}
	else
	{
		$pwd_md5 = MD5($password); // hash password
		$sql = "insert into utenti(nome,password,ruolo,codazienda,codpresidio,email) values(";
		$sql.="'$nome','$pwd_md5','$ruolo','$codazienda','$codicepresidio','$email')";
		mysql_query($sql) or die("Errore durante l'inserimento!");
		header('Refresh: 5; url=user.php');
	?>
    <br/>
    	<div class="container">
        	<div class="row">
            	<div class="col-md-6 col-md-offset-3">
                <img class="img-responsive" src="assets/img/successo.jpg">
            	<br/>
                <h1 class="text-center" style="color:#337ab7">
					Inserimento eseguito con successo.<br/><br/><small>Attendi verrai reinderizzato alla pagina utenti.</small>
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
                            	<h3 class="text-center"><span>Inserimento Utente</span></h3>
								<h5 class="text-center">(I campi contrassegnati con * sono obbligatori)</h5>
                                <big><span>Utente:&nbsp;</big></span> 
                                <big><b><?php echo $_nome;?></big></b>
                            </div>
                            <div class="panel-body">
                            <form class="form-horizontal" role="form" method='post' action='<?php echo $_SERVER[PHP_SELF];?>'>
    							<div class="form-group">
    								<label class="control-label col-sm-4">Username:*</label>
    								<div class="col-sm-4">
										<input class="form-control" type='text' name='nome' placeholder="Username" required/></td>
    								</div>
 		 						</div>
                                <div class="form-group">
    								<label class="control-label col-sm-4">Password*</label>
    								<div class="col-sm-4">
										<input class="form-control" type='password' name='password' placeholder="Password" required/></td>
    								</div>
 		 						</div>
                                
                                <div class="form-group">
    								<label class="control-label col-sm-4">Ruolo*</label>
                                    <div class="col-md-4">
    								<select class="form-control " name="ruolo" onchange="amministratore()"  required>
										<?php if($_ruolo=='A') { ?> <option value="A">Amministratore</option> <?php } ?>
										<?php if($_ruolo=='A') { ?> <option value="P">Utente con privilegi</option> <?php } ?>
										<option value="U">Utente</option>
									</select>
                                    </div>
                                </div>
                                   
                                 <div class="form-group">
    								<label class="control-label col-sm-4">Azienda Sanitaria*</label>
                                    <div class="col-md-4">
    								<select class="form-control " name="codazienda" id="_azienda" >
										<option value="">--Seleziona--</option>	
										<?php
										$sql = "select * from aziende order by azienda";
										$res = mysql_query($sql);
										while($row = mysql_fetch_array($res)) 
										{
											$codazienda = $row["codazienda"];
											$azienda = $row["azienda"];
										?>
										<option value="<?php echo $codazienda;?>"><?php echo $azienda;?></option>
										<?php
										}
										?>
									</select>
                                    </div>
 		 						</div>  
                                <div class="form-group">
    								<label class="control-label col-sm-4">Presidio Ospedaliero*</label>
                                    <div class="col-md-4">
    								<select class="form-control " name="presidio" id="_presidio" >
										<option value="">--Seleziona--</option>	
										<?php
										$sql = "select * from presidi order by presidio";
										$res = mysql_query($sql);
										while($row = mysql_fetch_array($res)) 
										{
											$codpresidio = $row["codpresidio"];
											$presidio = $row["presidio"];
										?>
										<option value="<?php echo $codpresidio;?>"><?php echo $presidio;?></option>
										<?php
										}
										?>
									</select>
                                    </div>  
                                   </div>
                                  <div class="form-group">
    								<label class="control-label col-sm-4">E-mail</label>
    								<div class="col-sm-4">
										<input class="form-control" type="email" name="email" placeholder="E-Mail" /></td>
    								</div>
 		 						</div>                      
         						<div class="form-group"> 
    								<div class="col-sm-offset-2 col-sm-10">
      									<button type="submit" name="registra_utente" class="btn btn-default">Inserisci</button>
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