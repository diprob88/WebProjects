<?php 
include("./assets/php/check.php");
include("./assets/php/core.php");
 ?>

<!DOCTYPE html>
<html>
<head>
<title>Aziende</title>
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
  <div class="col-md-12">
             <?php
			if(isset($_POST["filtro"])) 
			{
				$filtro = strtoupper($_POST["filtro"]);
			}
			else 
			{
				$filtro = "*";
			}
			$sql="select * from utenti order by nome ";
			$result = mysql_query($sql);
			
			?>  
     <div class="col-md-6 col-md-offset-3">                  <!-- questo è la parte dove mettere tutto-->
 	<div class="panel panel-primary">	
    	<div class="panel-heading">
			<h2 class="text-center">Amministrazione - Aziende</h2>
    		</div>
    <div class="panel-body">  
    <div class="col-md-8 col-md-offset-2">
	<form class="form-horizontal" role="form" method='post' action='<?php echo $_SERVER[PHP_SELF];?>'>
    	<div class="form-group">
    		<label class="control-label col-sm-4">Filtro:</label>
    			<div class="col-sm-6">
     				<input type='text' class="form-control" name='filtro' value='*' />
    			</div>
 		 </div>
         <div class="form-group"> 
    		<div class="col-sm-offset-4 col-sm-6">
      			<button type="submit" class="btn btn-default">Filtra</button>
    		</div>
  		</div>
	</form>
    </div>
    </div>
	</div>
    
    </div>
    <div class="col-md-12">
    <p> <a href='aziende_ins.php'><span class="glyphicon glyphicon-plus" style="font-size: 20px;">&nbsp;Aggiungi Azienda</span></a>	</p>
    </div>
            <?php	
	// estrae gli utenti
	if($filtro=='*') {
		$sql="select * from aziende order by azienda ";	
		
	}
	else {
		$sql="select * from aziende where azienda like '$filtro%' order by azienda ";
		
	}	
	$result = mysql_query($sql);
	?>
    
    
	
	<table class="table">
	<tr>
	<th></th>
	<th bgcolor='#6495ED'><p class="text-center">Codice</p></th>
	<th bgcolor='#6495ED'><p class="text-center">Aziende Sanitarie</p></th>
	</tr>			
	<?php				
	while ($row = mysql_fetch_array($result)) 
	{
		
		$codazienda = $row["codazienda"];
		$azienda = $row["azienda"];
		?>					
		<tr>
		<td bgcolor='#d3d3d3'><a href='aziende_upd.php?codazienda=<?php echo $codazienda;?>'><p class="text-center"><span class="glyphicon glyphicon-pencil" style="font-size: 20px;"></span></a></p></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><p class="text-center"><?php echo $codazienda;?></p></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><p class="text-center"><?php echo $azienda;?></p></td>
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