<!doctype html>
<html lang="it">
<head>
<?php include ('core.php'); ?>
<meta charset="utf-8">
<title>Modifica Autore Articolo</title>
<meta name="description" content="HomePage" />
<meta name="author" content="Roberto Di Perna"/>
<link rel="stylesheet" href="css/struttura.css">
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="css/header.css">
<link rel="stylesheet" href="css/footer.css">
<link rel="stylesheet" href="css/registrazione.css">

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
            <li><a href="#">Chi siamo</a></li>
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
       	
        <?php
		
		
		
		
		if(isset($_POST['invia']))
		{
			$chiave_articolo=isset($_POST['chiave_articolo']) ? clear($_POST['chiave_articolo']): false;
			$nome_autore=isset($_POST['nome_autore']) ? clear($_POST['nome_autore']): false;
			$cognome_autore=isset($_POST['cognome_autore']) ? clear($_POST['cognome_autore']): false;
			$nome_autore2=isset($_POST['nome_autore2']) ? clear($_POST['nome_autore2']): false;
			$cognome_autore2=isset($_POST['cognome_autore2']) ? clear($_POST['cognome_autore2']): false;
			$email_autore2=isset($_POST['email_autore2']) ? clear($_POST['email_autore2']): false;
			
			
			
			//estraggo la chiave dell'autore che devo cancellare
			$risultato=mysql_query("SELECT id FROM autore WHERE nome LIKE '$nome_autore' AND cognome LIKE '$cognome_autore'")or die(mysql_error());
			if(mysql_num_rows($risultato)==0)
			{?>
            	<br/>
            	<img id="sposta_al_centro2" src="img/errore.png"><br/>
                <p class="scritta">
				Autore Inesistente.<br/><br/><a href="javascript:history.back();">Indietro</a>
            	</p>
                <?php
			}
			else{
			$chiave_autore=mysql_result(mysql_query("SELECT id FROM autore WHERE nome LIKE '$nome_autore' AND cognome LIKE '$cognome_autore'"),0);

			$sql=mysql_query("SELECT * FROM pubblicazione WHERE id_autore='$chiave_autore' AND id_articolo='$chiave_articolo'")or die(mysql_error());
			$sql2=mysql_query("SELECT id_autore FROM pubblicazione WHERE id_articolo='$chiave_articolo'")or die(mysql_error());
			if(mysql_num_rows($sql)==0)
			{ 
			?>
            	<br/>
            	<img id="sposta_al_centro2" src="img/errore.png"><br/>
                <p class="scritta">
				Autore non eliminabile in quando non ha scritto l'articolo.<br/><br/><a href="javascript:history.back();">Indietro</a>
            	</p>
                <?php
			}elseif(mysql_num_rows($sql2)==1)
			{ ?>
            	<br/>
            	<img id="sposta_al_centro2" src="img/errore.png"><br/>
                <p class="scritta">
				Autore non eliminabile in quanto è l'unico esistente.<br/><br/><a href="javascript:history.back();">Indietro</a>
            	</p>
                <?php
			}
			else{
			
			
			$query="DELETE FROM pubblicazione WHERE id_articolo='$chiave_articolo' AND id_autore=$chiave_autore";
				$risultato=mysql_query($query);
				if (!$risultato) {
					die("Errore nella query $query: " . mysql_error());
					}
		?>
            	<br/>
            	<img id="sposta_al_centro2" src="img/successo2.png"><br/>
                <p class="scritta">
				Autore Eliminato.<br/>Attendi Verrai reinderizzato alal scheda dell'articolo.
            	</p>
                <?php
			header("refresh:5;url=scheda_articolo.php?ia=$chiave_articolo");

			
			}
			
			}
				
		}
		else
		{
			?>
                         <h4 class="titoloparagrafo">Elimina Autore Articolo</h4>

            <div id="Sezione">
           <form id="inserisciarticolo" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="POST">
           
			
            			<h4 id="paragrafoSezione">Autore da Cancellare</h4><br/>

            
            <label>Nome*</label> <input type="text" size="60" name="nome_autore" maxlength="32" placeholder="Nome Autore Articolo" required="required"/><br/>
          <label>Cognome*</label> <input type="text" size="60" name="cognome_autore" maxlength="32" placeholder="Cognome Autore Articolo" required="required"/><br/>                        
             <input type="hidden" value="<?php echo $chiave_articolo=$_REQUEST['x'];?>" name="chiave_articolo">

			
           <br/><br/>
					<input class="bottone" type="submit" name="invia" value="Elimina Autore" />
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