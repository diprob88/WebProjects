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
<?php include ('core.php');?>
	<script src="js/jquery.js"></script>
	<link rel="stylesheet" href="css/fotorama.css">
	<script src="js/fotorama.js"></script>

</head>

<body>
	<header>
    <a href="Home.php"><img src="img/logo.png" alt="ScienzeMania" ></a>
   <br/><br>
		
        <nav class="contorno">
        <ul>
       
			<li><a href="login.php">Home</a></li>
			<li><a href="http://scienzemania.forumfree.it/" target="_blank">Forum</a></li>
            <li><a href="areaprivata.php">Articoli</a></li>
            <li><a href="chisiamo.php">Chi Siamo</a></li>
            <li><a href="registrazione.php">Registrati</a></li>

        </ul>
        </nav>
        
	</header>
	<main>
    	<aside>
        
        	<img src="img/LogoSM.png" alt="ScienzeMania.it">
            <p id="paragrafoLogin">
				accedi
			</p>
            <p>
         <?php
		
		
		if(isset($_POST['login']))
		{ 
			$username=isset($_POST['username']) ? clear($_POST['username']): false;
			$password=isset($_POST['password']) ? clear($_POST['password']): false;
			
		
		
			if(empty($username)||empty($password))
			{?>
				<p class="scritta">Riempi tutti i campi di accesso.<br/><br/><a href="javascript:history.back();">Indietro</a></p>
				
				<?php
			}
			elseif(mysql_num_rows(mysql_query("SELECT * FROM utenti WHERE username LIKE '$username' AND password LIKE '$password'"))==0)
			{
				?>
				<p class="scritta">Utente non trovato.<br/><br/><a href="javascript:history.back();">Indietro</a></p>
				
				<?php
			}
			else
			{
				$password=md5($password);
				$ip=$_SERVER['REMOTE_ADDR'];
				if(mysql_num_rows(mysql_query("SELECT * FROM utenti WHERE username LIKE '$username' AND password ='$password'"))==1)
				{
					$username=mysql_result(mysql_query("SELECT username FROM utenti WHERE username LIKE '$username'"),0);
					$userid=mysql_result(mysql_query("SELECT id FROM utenti WHERE username LIKE '$username'"),0);
					mysql_query("UPDATE utenti SET last_login=UNIX_TIMESTAMP(), last_ip='$ip' WHERE id='$userid'") or die(msql_error());
					$_SESSION['username']=$username;
					$_SESSION['userid']=$userid;
					header('Location: index.php');
				}
				
			}
			
			
			
				
		}
		else
		{
		?>
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
				<label>Username </label><input type="text" name="username" placeholder="Inserisci Username"/><br>
				<label>Password </label> <input type="password" name="password" placeholder="Inserisci Password"/><br/><br/>
				<input type="submit" name="login" value="Entra"/>
			</form>
	<?php
		}
	?>
			</p>
			<p id="paragrafoLogin">
				info
			</p>
            
            <p class="scritta">sito realizzato interamente in</p>
            <p><img src="img/CSS3_Logo.png"></p>
            <p><img src="img/HTML5_Logo.png" ></p>
            <br/><img src="img/PHPMySQL_logo.png">
           
            
            
            
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