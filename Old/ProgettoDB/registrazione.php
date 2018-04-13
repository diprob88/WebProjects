<!doctype html>
<html lang="it">
<head>
<?php include ('core.php'); ?>
<meta charset="utf-8">
<title>Registrati</title>
<meta name="description" content="HomePage" />
<meta name="author" content="Roberto Di Perna"/>
<link rel="stylesheet" href="css/struttura.css">
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="css/header.css">
<link rel="stylesheet" href="css/footer.css">
<link rel="stylesheet" href="css/registrazione.css">

</head>

<body>
	<header>
    <a href="index.php"><img src="img/logo.png" alt="ScienzeMania.it" ></a>
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
			{
				echo 'Riempi tutti i campi di accesso<br/><br/><a href="javascript:history.back();">Indietro</a>';
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
		if(isset($_POST['invia']))
		{ //azioni PHP
			$nome=isset($_POST['nome']) ? clear($_POST['nome']): false;
			$cognome=isset($_POST['cognome']) ? clear($_POST['cognome']): false;
			$username=isset($_POST['username']) ? clear($_POST['username']): false;
			$password=isset($_POST['password']) ? clear($_POST['password']): false;
			$confermapwd=isset($_POST['confermapwd']) ? clear($_POST['confermapwd']): false;
			$email=isset($_POST['email']) ? clear($_POST['email']): false;
			$confermaemail=isset($_POST['confermaemail']) ? clear($_POST['confermaemail']): false;
			$url=isset($_POST['url']) ? clear($_POST['url']): false;
			$foto="img/user.png";
			
			
			if($password!=$confermapwd)
			{?>
            	<br/>
            	<img id="sposta_al_centro2" src="img/errore.png"><br/>
                <p class="scritta">
				La password scelta non corrisponde, digitare correttamente.<br/><br/><a href="javascript:history.back();">Indietro</a>
            	</p>
                <?php
			}
			elseif($email!=$confermaemail)
			{?>
            	<br/>
            	<img id="sposta_al_centro2" src="img/errore.png"><br/>
                <p class="scritta">
				I due indirizzi Email non corrispondono,digitare correttamente.<br/><br/><a href="javascript:history.back();">Indietro</a>
            	</p>
                <?php
			}
			elseif(mysql_num_rows(mysql_query("SELECT * FROM utenti WHERE username LIKE '$username'"))>0)
			{?>
            	<br/>
            	<img id="sposta_al_centro2" src="img/errore.png"><br/>
                <p class="scritta">
				Username già in uso, si prega di sceglierne un altro.<br/><br/><a href="javascript:history.back();">Indietro</a>
            	</p>
                <?php
			}
			elseif(mysql_num_rows(mysql_query("SELECT * FROM utenti WHERE email LIKE '$email'"))>0)
			{?>
            	<br/>
            	<img id="sposta_al_centro2" src="img/errore.png"><br/>
                <p class="scritta">
				Email già in uso, si prega di sceglierne un altra.<br/><br/><a href="javascript:history.back();">Indietro</a>
            	</p>
            <?php
			}
			else
			{
				$password=md5($password);
				$ip=$_SERVER['REMOTE_ADDR'];
				if(mysql_query("INSERT INTO utenti (nome,cognome,username,password,email,reg_ip,last_ip,reg_date,foto) VALUES ('$nome','$cognome','$username','$password','$email','$ip','$ip',UNIX_TIMESTAMP(),'$foto')"))
				{?>
            	<br/>
            	<img id="sposta_al_centro2" src="img/successo.png"><br/>
                <p class="scritta">
					Registrazione avvenuta con successo.Attendi verrai Reindirizzato all'area di di login
            	</p>
            <?php
					header("refresh:5;url=login.php");
				}
				else
				{
					echo 'Errore nella query: '.mysql_error();
				}
			}
			
			
			
				
		}
		else
		{
			?>
                                           
             <h4 class="titoloparagrafo">Registrazione</h4>

            <div id="Sezione">
           <form id="inserisciarticolo"action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
           <br/><br/> <label>Nome* </label><input type="text" size="50" name="nome" maxlength="20" placeholder="Inserisci il tuo Nome" required="required"/><br><br/>
            <label>Cognome* </label><input type="text" size="50" name="cognome" maxlength="20" placeholder="Inserisci il tuo Cognome" required="required"/><br><br/>
			<label>Username* </label><input type="text" size="50" name="username" maxlength="16" placeholder="Scegli un Username" required="required"/><br><br/>
			<label>Password* </label> <input type="password" size="50" name="password" maxlength="32" placeholder="Inserisci una Password" required="required"/><br/><br/>
            <label>Conferma Password*</label> <input type="password" size="50" name="confermapwd" maxlength="32" placeholder="Conferma la Password" required="required"/><br/><br/>
            <label>Email*</label><input type="email" size="50" name="email" placeholder="Inserisci la tua email" maxlength="60" required="required"/><br/>
            <label>Conferma Email*</label><input type="email" size="50" name="confermaemail" maxlength="60" placeholder="Reinserisci la tua email" required="required"/><br/><br/>
            <label>URL</label><input type="url" size="40" name="url" title="Inserire indirizzo internet preceduto da http://"  placeholder="http://" /><br/><br/><br/>
					<input class="bottone" type="submit" name="invia" value="Registrati" />
                    <input class="bottone" type="reset" name="reset" value="Azzera">
                
                
			</form>
            </div>
            <?php
		}
		?>
            
       
       				
        
        
</main>
	<footer class="bordof">
    	<p>&copy Copyright 2014 Roberto Di Perna</p>
	</footer>
	</body>
</html>
