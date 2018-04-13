<!doctype html>
<html lang="it">
<head>
<meta charset="utf-8">
<title>Chi Siamo</title>
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
				echo 'Riempi tutti i campi di accesso<br/><br/><a href="javascript:history.back();">Indietro</a>';
			}
			elseif(mysql_num_rows(mysql_query("SELECT * FROM utenti WHERE username LIKE '$username'"))==0)
			{
				echo 'Utente non trovato.<br/><br/><a href="javascript:history.back();">Indietro</a>';
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
        
       	<div id="Sezione">
        
        
        <h4 id="paragrafoSezione">Chi Siamo</h4>
        	<img src="img/chisiamo.png">
            <br/>
            <p>
             
            Siamo un gruppo di autori, editori, studiosi, critici e non solo, che ha a cuore le sorti della cultura.Per questo abbiamo scelto una forma associativa no profit e fondato il portale web ScienzeMania, una struttura trasparente e semplificata e al tempo stesso aperta all’adesione di chi condivide le sue idee e il suo programma. Una scelta netta a favore di un’idea di lavoro culturale come costruzione di una comunità, le cui conoscenze sono messe al servizio dello sviluppo collettivo e sistematicamente reinvestite nella produzione dei contenuti e nella diffusione di articoli scientifici dedicati ad ogni settore.
            </p>
            <h4 id="paragrafoSezione">Perchè</h4>
            <p>
            Perché non si perda la memoria del passato mentre si transita verso il futuro; per contribuire al cambiamento culturale e sociale del nostro paese; per amore della scienza; per aprire spazi a nuove scoperte e conoscenze; per amore del dialogo; per difendere e allargare la democrazia del sapere.
            </p>
             <h4 id="paragrafoSezione">Obiettivi</h4>
             <p>
SienzeMania si presenta ai suoi utenti con un sito web dove si condividono articoli scientifici, si dà spazio ai singoli autori e si progettano opere collettive; un’interfaccia dove è possibile scambiare conoscenze: un luogo di confronto e di dibattito che propone dossier dedicati a temi attuali; ScienzeMania è una comunity che privilegia il supporto elettronico come mezzo di propaganza scientifica.
       </p>
         </div>
        
        
</main>
	<footer class="bordof">
    	<p>&copy Copyright 2014 Roberto Di Perna</p>
	</footer>
	</body>
</html>