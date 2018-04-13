<?php 
include("./assets/php/check.php");
include("./assets/php/core.php");
 ?>

<!DOCTYPE html>
<html>
<head>
<title>Calcolo Abbattimenti</title>
<link rel="shortcut icon" href="./assets/img/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap-theme.css">
<link rel="stylesheet"  href="./assets/css/jquery-ui.css">
<script type="text/javascript" src="./assets/js/jquery-1.11.3.js"></script>
<script type="text/javascript" src="./assets/js/jquery-ui.js"></script>
<script>
    $(function() {
        $( "#datepicker" ).datepicker();
    });
</script>
<script type="text/javascript" src="./assets/js/bootstrap.js"></script>
<script type="text/javascript" src="./assets/js/ui.datepicker-it.js" ></script>    
<script type="text/javascript">    
    $(function() {
	$.datepicker.setDefaults($.datepicker.regional['it']);
	$(".data:input").datepicker();
});
</script>   
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
                      	<div class="panel panel-primary">
                        	<div class="panel-heading">
                            	<h3 class="text-center"><span>Calcolo Abbattimento</span></h3>								
                                <big><span>Utente:&nbsp;</big></span> 
                                <big><b><?php echo $_nome;?></big></b>
                            </div>
                            <div class="panel-body">
                            <form class="form-horizontal" role="form" method='post' action="inserimento_calcolo.php">
    							<div class="form-group">
    								<label class="control-label col-sm-4">Seleziona Data:</label>
    								<div class="col-sm-4">
										<input type="text" id="datepicker" class="form-control" name="data" required/>
    								</div>
 		 						</div>
                                <div class="form-group">
    								<label class="control-label col-sm-4">Seleziona Anno:</label>
    								<div class="col-sm-4">
										<select class="form-control" name="anno" required>
   										<?php
										for($i=date('Y')-1;$i<=date('Y')+30;$i++) 
										{
											echo '<option value="'.$i.'">'.$i.'</option>';
										}
										?>
 						 				</select>
    								</div>
 		 						</div>
                               
         						<div class="form-group"> 
    								<div class="col-sm-offset-2 col-sm-10">
      									<button type="submit" class="btn btn-default">Avanti</button>
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


</body>
</html>