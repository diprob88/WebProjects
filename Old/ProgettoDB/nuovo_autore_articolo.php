<!doctype html>
<html lang="it">
<head>
<?php include ('core.php'); ?>
<meta charset="utf-8">
<title>Inserimento Autore Articolo</title>
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
			$email_autore=isset($_POST['email_autore']) ? clear($_POST['email_autore']): false;
			$nome_autore2=isset($_POST['nome_autore2']) ? clear($_POST['nome_autore2']): false;
			$cognome_autore2=isset($_POST['cognome_autore2']) ? clear($_POST['cognome_autore2']): false;
			$email_autore2=isset($_POST['email_autore2']) ? clear($_POST['email_autore2']): false;
			$nome_autore3=isset($_POST['nome_autore3']) ? clear($_POST['nome_autore3']): false;
			$cognome_autore3=isset($_POST['cognome_autore3']) ? clear($_POST['cognome_autore3']): false;
			$email_autore3=isset($_POST['email_autore3']) ? clear($_POST['email_autore3']): false;
			
			
			
			
		
			//Inserimento in Autore
		if(mysql_num_rows(mysql_query("SELECT nome,cognome FROM autore WHERE nome LIKE '$nome_autore' AND cognome LIKE '$cognome_autore'"))==0)
			{ 
			$query="INSERT INTO autore (nome,cognome,email) VALUES ('$nome_autore','$cognome_autore','$email_autore')";
				$risultato=mysql_query($query);
				if (!$risultato) {
					die("Errore nella query $query: " . mysql_error());
					}
			}
				
		if(!empty($nome_autore2) && !empty($cognome_autore2))
		{
			if(mysql_num_rows(mysql_query("SELECT nome,cognome FROM autore WHERE nome LIKE '$nome_autore2' AND cognome LIKE '$cognome_autore2'"))==0)
			{ 
			$query="INSERT INTO autore (nome,cognome,email) VALUES ('$nome_autore2','$cognome_autore2','$email_autore2')";
				$risultato=mysql_query($query);
				if (!$risultato) {
					die("Errore nella query $query: " . mysql_error());
					}
			}
		}
		
		if(!empty($nome_autore3) && !empty($cognome_autore3))
		{
			if(mysql_num_rows(mysql_query("SELECT nome,cognome FROM autore WHERE nome LIKE '$nome_autore3' AND cognome LIKE '$cognome_autore3'"))==0)
			{ 
			$query="INSERT INTO autore (nome,cognome,email) VALUES ('$nome_autore3','$cognome_autore3','$email_autore3')";
				$risultato=mysql_query($query);
				if (!$risultato) {
					die("Errore nella query $query: " . mysql_error());
					}
			}
		}		
				
			
			
			//ottenimento chiavi
			$chiave_autore=mysql_result(mysql_query("SELECT id FROM autore WHERE nome LIKE '$nome_autore' AND cognome LIKE '$cognome_autore'"),0);
				
			//inserimento in pubblicazione
			$sql=mysql_query("SELECT * FROM pubblicazione WHERE id_autore='$chiave_autore' AND id_articolo='$chiave_articolo'")or die(mysql_error());
			if(mysql_num_rows($sql)==0)
			{ 
			$query="INSERT INTO pubblicazione (id_autore,id_articolo) VALUES ('$chiave_autore','$chiave_articolo')";
				$risultato=mysql_query($query);
				if (!$risultato) {
					die("Errore nella query $query: " . mysql_error());
					}	
			}
			
			if(!empty($nome_autore2) && !empty($cognome_autore2))
			{
			$chiave_autore=mysql_result(mysql_query("SELECT id FROM autore WHERE nome LIKE '$nome_autore2' AND cognome LIKE '$cognome_autore2'"),0);
			$sql=mysql_query("SELECT * FROM pubblicazione WHERE id_autore='$chiave_autore' AND id_articolo='$chiave_articolo'")or die(mysql_error());
			if(mysql_num_rows($sql)==0)
			{ 
			$query="INSERT INTO pubblicazione (id_autore,id_articolo) VALUES ('$chiave_autore','$chiave_articolo')";
				$risultato=mysql_query($query);
				if (!$risultato) {
					die("Errore nella query $query: " . mysql_error());
					}	
			}
			}
			
			if(!empty($nome_autore3) && !empty($cognome_autore3))
			{
			$chiave_autore=mysql_result(mysql_query("SELECT id FROM autore WHERE nome LIKE '$nome_autore3' AND cognome LIKE '$cognome_autore3'"),0);
			$sql=mysql_query("SELECT * FROM pubblicazione WHERE id_autore='$chiave_autore' AND id_articolo='$chiave_articolo'")or die(mysql_error());
			if(mysql_num_rows($sql)==0)
			{ 
			$query="INSERT INTO pubblicazione (id_autore,id_articolo) VALUES ('$chiave_autore','$chiave_articolo')";
				$risultato=mysql_query($query);
				if (!$risultato) {
					die("Errore nella query $query: " . mysql_error());
					}	
			}
			}
			?>
			<br/>
            	<img id="sposta_al_centro2" src="img/successo2.png"><br/>
                <p class="scritta">
				Dati inseriti con successo.<br/>Attendi Verrai reinderizzato alal scheda dell'articolo.
            	</p>
                <?php
			
			header("refresh:5;url=scheda_articolo.php?ia=$chiave_articolo");

		}
			
		
		else
		{
			?>
             <h4 class="titoloparagrafo">Inserisci Nuovo Autore Articolo</h4>

            <div id="Sezione">
           <form id="inserisciarticolo" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="POST">
           
			<h4 id="paragrafoSezione">Autore (Massimo 3 Autori)</h4><br/>

           
            
            <label>Nome*</label> <input type="text" size="60" name="nome_autore" maxlength="32" placeholder="Nome Autore Articolo" required="required"/><br/>
            <label>Cognome*</label> <input type="text" size="60" name="cognome_autore" maxlength="32" placeholder="Cognome Autore Articolo" required="required"/><br/>
            <label>Email </label><input type="email" size="60" name="email_autore" placeholder="Email Autore" maxlength="60"/><br/>
			<br/><h4 id="paragrafoSezione">Autore 2</h4><br/>
            <label>Nome</label> <input type="text" size="60" name="nome_autore2" maxlength="32" placeholder="Nome Autore Articolo" /><br/>
            <label>Cognome</label> <input type="text" size="60" name="cognome_autore2" maxlength="32" placeholder="Cognome Autore Articolo"/><br/>
            <label>Email </label><input type="email" size="60" name="email_autore2" placeholder="Email Autore" maxlength="60"/><br/>
           <br/> <h4 id="paragrafoSezione">Autore 3</h4><br/>
            <label>Nome</label> <input type="text" size="60" name="nome_autore3" maxlength="32" placeholder="Nome Autore Articolo" /><br/>
            <label>Cognome</label> <input type="text" size="60" name="cognome_autore3" maxlength="32" placeholder="Cognome Autore Articolo"/><br/>
            <label>Email </label><input type="email" size="60" name="email_autore3" placeholder="Email Autore" maxlength="60"/><br/>
            
           
               <input type="hidden" value="<?php echo $chiave_articolo=$_REQUEST['x'];?>" name="chiave_articolo">
				<br/><br/>
					<input class="bottone" type="submit" name="invia" value="Aggiungi Autore" />
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