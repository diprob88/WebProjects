<!doctype html>
<html lang="it">
<head>
<meta charset="utf-8">
<title>In Evidenza</title>
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
			
            <?php
			}
			?>
                     <h4 class="titoloparagrafo">In Evidenza</h4>

       	<div id="Sezione">
       
        			          
         
         
         <h4 id="paragrafoSezione">Descrizione</h4><br/>
         <img src="img/inevidenza/emc2.png">

         <p>Tutto l'articolo ha come tema centrale il moto dei corpi celesti, spaziando dall'analisi dei semplici moti della fisica classica, terminando con la teoria della relativitià di Einstain.
Viene presentato il concetto di relatività mettendolo in antitesi con il termine di "relatività" quotidianamente usato, spiegando che per come era inteso da Einstein era quasi l'opposto.
Infatti nell'introduzione a partire da una famosa barzelletta su Einstein, si finisce a chiarire bene il concetto di relatività di per se. In seguito viene fatto un excursus della storia della relatività, per com'era stata fatta a partire dalla cosmologia Aristotelica, passando poi per Copernico, Brahe e infine Galileo, dove viene analizzata la loro scienza inerente a quest'argomento e viene dato maggiore attenzione alla scienza Galileiana. Viene spiegato come un moto non può seguire una sola dinamica, per esempio un sasso lanciato in aria da una nave in movimento, ma è affetto da altri piccoli moti di cui ci è difficile accorgere. Per questo poi si parla di moto dei gravi e, in condizioni ideali, di ciò che Galileo chiamò "Principio di indipendenza dei moti". Viene fatto riferimento a come Galileo si rapportò con le leggi di Keplero, seguendo la linea di Aristotele e Copernico. Successivamente si identifica negli scritti di Newton, i Principia, l'epoca d'oro della fisica classica, in quanto vengono analizzati per bene tutti i moti che erano stati studiati precedentemente dai personaggi già citati, evidenziando come si evolve il concetto di relatività tra Newton, Maxwell ed infine ritornando ad Einstein. In un primo momento vengono riportati due dei 26 articoli più famosi pubblicati da Einstein riguardanti: il primo, uno studio euristico dell'emissione e della trasformazione della luce, dove viene introdotto il concetto di fotoni o quant di luce; il secondo, riprende un ipotesi avanzata tempo prima da Clausius sul movimento di piccole particelle sospese in un liquido stazionario, il cui fenomeno viene esaustivamente spiegato da un analisi Einsteiniana.
Infine l'articolo si conclude con l'introduzione della famosa formula E=mc^2 e con una sintetica spiegazione di come lo spazio e il tempo siano strettamente correlati tra di loro, portando come prova dell'ipotesi della curvatura dello spazio delle lastre fotografiche impresse durante un eclissi totale di Sole.
</p>
         </div>
         
         
         
         
        
        
</main>
	<footer class="bordof">
    	<p>&copy Copyright 2014 Roberto Di Perna</p>
	</footer>
	</body>
</html>