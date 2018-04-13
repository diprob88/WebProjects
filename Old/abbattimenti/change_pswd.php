<?php 
include("./assets/php/check.php");
include("./assets/php/core.php");
 ?>

<!DOCTYPE html>
<html>
<head>
<title>Cambia Password</title>
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
if(array_key_exists("_exec",$_POST)) {
	// parametri per la connessione al db
	$user = "root";
	$passwd = "";
	$db = "abbattimenti";
	// Si connette al server MySql
	mysql_connect(localhost,$user,$passwd);
	// Seleziona il database che contiene le delibere
	@mysql_select_db($db) or die( "Errore durante la selezione del database!");

	// estrae i dati dell'utente dal db
	$sql="select * from utenti where nome = '$_nome'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$_nome = $row["nome"];
	$_password = $row["password"];
	// effettua le validazioni necessarie prima della modifica
	$old_pass = $_POST["old_pass"];
	$new_pass = $_POST["new_pass"];
	$conf_pass = $_POST["conf_pass"];
	if( MD5($old_pass) != $_password ) {
		?>
		<div id="error"><p>Devi inserire la vecchia password prima di poterla modificare!</p></div>
		<META HTTP-EQUIV='refresh' content='2; URL=change_pswd.php'>
		<?php
		exit();
	}
	if( strlen($new_pass) < 8 ) {
		?>
		<div id="error"><p>La password deve contenere almeno 8 caratteri!</p></div>
		<META HTTP-EQUIV='refresh' content='2; URL=change_pswd.php'>
		<?php
		exit();
	}	
	if( $new_pass != $conf_pass ) {
		?>
		<div id="error"><p>Devi confermare correttamente la nuova password!</p></div>
		<META HTTP-EQUIV='refresh' content='2; URL=change_pswd.php'>
		<?php
		exit();
	}
	$md5_passwd = MD5($new_pass);
	$sql="update utenti set password='$md5_passwd' where nome='$_nome'";	
	mysql_query($sql) or die("Errore durante la modifica della password");
	mysql_close();
	?>
	<div id="ok"><p>Password modificata correttamente!</p></div>
	<META HTTP-EQUIV='refresh' content='2; URL=home.php'>
	<?php
}
else {
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
                            	<h3 class="text-center"><span>Modifica Password:</span></h3>
								<h5 class="text-center">(I campi contrassegnati con * sono obbligatori)</h5>
                                <big><span>Utente:&nbsp;</big></span> 
                                <big><b><?php echo $_nome;?></big></b>
                            </div>
                            <div class="panel-body">
                            <form class="form-horizontal" role="form" method='post' action='<?php echo $_SERVER[PHP_SELF];?>'>
    							<div class="form-group">
    								<label class="control-label col-sm-4">Vecchia Password:</label>
    								<div class="col-sm-4">
										<input class="form-control" type='password' name='old_pass' placeholder="Password Attuale" required/></td>
    								</div>
 		 						</div>
                                <div class="form-group">
    								<label class="control-label col-sm-4">Nuova Password:</label>
    								<div class="col-sm-4">
										<input class="form-control" type='password' name='new_pass' placeholder="Nuova Password" required/></td>
    								</div>
 		 						</div>
                                <div class="form-group">
    								<label class="control-label col-sm-4">Conferma Password:</label>
    								<div class="col-sm-4">
										<input class="form-control" type='password' name='conf_pass' placeholder="Conferma Password" required/></td>
    								</div>
 		 						</div>
         						<div class="form-group"> 
    								<div class="col-sm-offset-2 col-sm-10">
      									<button type="submit" class="btn btn-default">Modifica</button>
                                        <input type='hidden' name='_exec' value='1'/>
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