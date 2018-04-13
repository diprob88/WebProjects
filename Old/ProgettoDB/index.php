<!doctype html>
<html lang="it">
<head>
<meta charset="utf-8">
<title>ScienzaMania</title>
<meta name="description" content="HomePage" />
<meta name="author" content="Roberto Di Perna"/>
<link rel="stylesheet" href="css/struttura.css">
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="css/header.css">
<link rel="stylesheet" href="css/footer.css">
<?php include('core.php'); ?>
<script src="js/jquery.js"></script>
<link rel="stylesheet" href="css/fotorama.css">
<script src="js/fotorama.js"></script>

</head>

<body>
	<header>
    <a href="Home.php"><img src="img/logo.png" alt="ScienzeMania.it" ></a>
   <br/><br>
		
        <nav class="contorno">
        <ul>
        	  <?php
		
		if(isset($_POST['login']))
		{ ?>
        	<li><a href="login.php">Home</a></li>
		<?php }
		else
		{?>
			<li><a href="index.php">Home</a></li>
		<?php 
		}
		?>
        	<li><a href="http://scienzemania.forumfree.it/" target="_blank">Forum</a></li>
          	<li><a href="cerca.php">Articoli</a></li>
            <li><a href="chisiamo.php">Chi siamo</a></li>
            <li><a href="logout.php">Disconnetti</a></li>
        </ul>
        </nav>
        
	</header>
	<main>
    	<aside>
        
        	<img src="img/LogoSM.png" alt="ScienzeMania">
           
             <?php
			if(isset($_SESSION['username']))
			{
				$userid=$_SESSION['userid'];
				$last_login=mysql_result(mysql_query("SELECT last_login FROM utenti WHERE id='$userid'"),0);
				$fotoprofilo=mysql_result(mysql_query("SELECT foto FROM utenti WHERE id='$userid'"),0);
				?>
				<p class="scritta">Bentornato <?php echo $_SESSION['username'] ?></p>
                <img src="<?php echo $fotoprofilo ?>">
                <p class="scritta">Ultimo login
                 <?php echo 'data:<br/>'.date('d-m-Y',$last_login).'<br/>ore '.date('H:i', $last_login);?></p>
                <?php
			}
			else
			{
				header('Location: login.php');
			}
			?>
			
			<p id="paragrafoLogin">
				Menù
			</p>
            
            <button class="menulogin"  onclick="window.location='inserisciarticolo.php'" >Inserisci Articolo</button>
            <button class="menulogin"   onclick="window.location='ilmioprofilo.php'">Il mio Profilo</button>
            <button class="menulogin"  onclick="window.location='mailto:scienzemania@gmail.com'">Contattaci</button>
            
        </aside>
       	<div id="SezioneB1" class="fotorama">
          	<a href="img/Galleria/01.jpg"><img src="img/Galleria/thumbs/01.jpg"></a>
			<a href="img/Galleria//02.jpg"><img src="img/Galleria/thumbs/02.jpg"></a>
			<a href="img/Galleria/03.jpg"><img src="img/Galleria/thumbs/03.jpg"></a>
			<a href="img/Galleria/04.jpg"><img src="img/Galleria/thumbs/04.jpg"></a>
			<a href="img/Galleria/05.jpg"><img src="img/Galleria/thumbs/05.jpg"></a>
			<a href="img/Galleria/06.jpg"><img src="img/Galleria/thumbs/06.jpg"></a>
			<a href="img/Galleria/07.jpg"><img src="img/Galleria/thumbs/07.jpg"></a>
			<a href="img/Galleria/08.jpg"><img src="img/Galleria/thumbs/08.jpg"></a>
			<a href="img/Galleria/09.jpg"><img src="img/Galleria/thumbs/09.jpg"></a>
			<a href="img/Galleria/10.jpg"><img src="img/Galleria/thumbs/10.jpg"></a>
        </div>
        <div id="SezioneB2">
        			<h4 id="paragrafoSezione">
                    	in evidenza
         			</h4>
                    <a href="#"><img src="img/inevidenza/emc2.png"></a>
                    <h3>La relatività da galileo a Einstein</h3>
                    <h4>Autore: Giorgio Strano</h4>
                    <p>In una nota barzelletta Albert Einstein (1879-1955) si rimira allo specchio e dice “Che bel fisico!” La moglie lo guarda con aria scettica e commenta: “Tutto è relativo...”
                    							&nbsp;<a href="inevidenza.php">Leggi articolo completo...</a>
</p>
        </div>
         <div id="SezioneB3">
         			<h4 id="paragrafoSezione">
                    	Video della Settimana
         			</h4>
                    
        			 <iframe width="420" height="315" 
                     src="http://www.youtube.com/embed/cCp9kLWnJss" 
                     frameborder="0" allowfullscreen>
                     </iframe>
                     <h3>La Storia di Albert Einstein e della Fisica</h3>
                     <p>
                            Un documentario che ripercorre le "tappe" fondamentali che hanno portato Albert Einstein ha formulare la sua più famosa teoria. 
							&nbsp;<a href="videodellasettimana.php">Leggi articolo completo...</a>
                    </p>
                    
                    
         </div>
        
        
</main>
	<footer class="bordof">
    	<p>&copy Copyright 2014 Roberto Di Perna</p>
	</footer>
	</body>
</html>