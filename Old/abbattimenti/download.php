<?php include("./assets/php/check.php"); ?>
<?php
// variabili di sessione
$_nome = $_SESSION["_nome"];
$_ruolo = $_SESSION["_ruolo"];
$_codazienda = $_SESSION["_codazienda"];
?>
<!DOCTYPE html>
<html>
<head>
<title>Download</title>
<link rel="shortcut icon" href="./assets/img/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap-theme.css">
<script type="text/javascript" src="./assets/js/jquery-1.11.3.js"></script>
<script type="text/javascript" src="./assets/js/bootstrap.js"></script>
<link href="./assets/css/simple-sidebar.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="./assets/css/mycss.css" />
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
                    <div class="col-md-6 col-md-offset-3">
                       <!-- questo è la parte dove mettere tutto-->
                       
                   
		
        <div class="panel panel-primary">
  				<div class="panel-heading">
                	<p class="text-center">Download</p>
                </div>
                <div class="panel-body">
                	<ul class="list-group">
                	<li class="list-group-item"><a href=".download/Allegato_1_DA_923_tariffe_DRG.xls" target="_blank" download>Allegato 1 DA 923 Tariffe DRG</a></li>
                	<li class="list-group-item"><a href="./download/Allegato_A_Day_Service_2014.xls" target="_blank" download>Allegato A Day Service 2014</a></li>
                </ul>
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


</body>
</html>