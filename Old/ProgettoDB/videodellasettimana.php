<!doctype html>
<html lang="it">
<head>
<meta charset="utf-8">
<title>Video Della Settimana</title>
<meta name="description" content="HomePage" />
<meta name="author" content="Roberto Di Perna"/>
<link rel="stylesheet" href="css/struttura.css">
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="css/header.css">
<link rel="stylesheet" href="css/footer.css">
<link rel="stylesheet" href="css/registrazione.css">

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
			if(isset($_SESSION['username']))
			{
		
		     ?>
        			<li><a href="index.php">Home</a></li>
					<li><a href="http://scienzemania.forumfree.it/" target="_blank">Forum</a></li>
           			 <li><a href="cerca.php">Articoli</a></li>
           			 <li><a href="chisiamo.php">Chi Siamo</a></li>
           			 <li><a href="logout.php">Disconnetti</a></li>
           
         </ul>
        </nav>
        
	</header>
	<main>
    	<aside>
        
        	<img src="img/LogoSM.png" alt="ScienzeMania">
				
			
				<?php
				
				
				$userid=$_SESSION['userid'];
				$last_login=mysql_result(mysql_query("SELECT last_login FROM utenti WHERE id='$userid'"),0);
				$fotoprofilo=mysql_result(mysql_query("SELECT foto FROM utenti WHERE id='$userid'"),0);
				?>
				<p class="scritta">Bentornato <?php echo $_SESSION['username'] ?></p>
                <img src="<?php echo $fotoprofilo ?>">
                <p class="scritta">Ultimo login
                 <?php echo 'data:<br/>'.date('d-m-Y',$last_login).'<br/>ore '.date('H:i', $last_login);?></p>
                 <p id="paragrafoLogin">
				Menù
			</p>
            <br/>
            <button class="menulogin"  onclick="window.location='inserisciarticolo.php'" >Inserisci Articolo</button>
            <button class="menulogin"   onclick="window.location='ilmioprofilo.php'">Il mio Profilo</button>
            <button class="menulogin"  onclick="window.location='mailto:scienzemania@gmail.com'">Contattaci</button>
            
                 </aside>
              <?php
			}
			else
			{
			?>
			
        	<li><a href="index.php">Home</a></li>
           <li><a href="http://scienzemania.forumfree.it/" target="_blank">Forum</a></li>
            <li><a href="areaprivata.php">Articoli</a></li>
            <li><a href="Registrazione.php">Registrati</a></li>
            <li><a href="chisiamo.php">Chi Siamo</a></li>
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
			{
				?>
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
			
            <?php
			}
			?>
                             <h4 class="titoloparagrafo">Video della Settimana</h4>

       	<div id="Sezione">
        			 <iframe width="608" height="400" 
                     src="http://www.youtube.com/embed/cCp9kLWnJss" 
                     frameborder="0" allowfullscreen>
                     </iframe>
         
         
         
         
         <h4 id="paragrafoSezione">Descrizione</h4>
         <p>La teoria della relatività di Einstein consta, infatti, di un indiretto contributo da parte di: Michael Faraday per il concetto di energia (E), determinando il collegamento tra magnetismo ed elettricità (elettromagnetismo), e grazie alla collaborazione con il matematico Maxwell per la dimostrazione scientifica e matematica che indica la luce come un’onda elettromagnetica (c); Lavoisier, chimico ed economista, per l’importanza della massa e della sua capacità di non dispersione, ma di trasformazione (m); Émilie Du Chatelet, intellettuale francese del 1700, per la scoperta della velocità al quadrato (c2) grazie agli esperimenti di uno scienziato olandese.
Grazie alla sua scoperta Einstein si aggiudica l’appellativo di “padre della fisica moderna”. Il suo grande contributo porta a nuove sperimentazioni e alla nascita di nuovi grandi scienziati. 
Nel Novecento tra i tanti spicca la figura del fisico Lise Meitner, la quale scinderà per la prima volta l’atomo, pur non guadagnando alcun merito a causa della sua origine ebraica. 
Il documentario così si conclude con il risvolto più negativo della più grande scoperta scientifica: il progetto Manhattan del 1942 e lo sgancio della bomba atomica. 
</p>
         </div>
         
         
         
         
        
        
</main>
	<footer class="bordof">
    	<p>&copy Copyright 2014 Roberto Di Perna</p>
	</footer>
	</body>
</html>