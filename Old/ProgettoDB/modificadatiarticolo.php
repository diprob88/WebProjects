<!doctype html>
<html lang="it">
<head>
<?php include ('core.php'); ?>
<meta charset="utf-8">
<title>ModificaArticolo</title>
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
       	<div id="articolo">
        <?php
		
		
		
		
		
		if(isset($_POST['invia']))
		{ 
		
		
			$username=$_SESSION['username'];
		
		//azioni PHP
			$chiave_articolo=isset($_POST['chiave_articolo']) ? clear($_POST['chiave_articolo']): false;
			$titolo_articolo=isset($_POST['titolo_articolo']) ? clear($_POST['titolo_articolo']): false;
			$tipo_articolo=isset($_POST['tipo_articolo']) ? clear($_POST['tipo_articolo']): false;
			$sommario_articolo=isset($_POST['sommario_articolo']) ? clear($_POST['sommario_articolo']): false;
			$descrizione_articolo=isset($_POST['descrizione_articolo']) ? clear($_POST['descrizione_articolo']): false;
			$numero_rivista=isset($_POST['numero_rivista']) ? clear($_POST['numero_rivista']): false;
			$anno_rivista=isset($_POST['anno_rivista']) ? clear($_POST['anno_rivista']): false;
			$nome_rivista=isset($_POST['nome_rivista']) ? clear($_POST['nome_rivista']): false;
			
			
			
			//variabili per chiavi
			
			
			$chiave_tipologia="";
			$chiave_utente=mysql_result(mysql_query("SELECT id FROM utenti WHERE username LIKE '$username'"),0);
			$chiave_rivista="";
			
			
			//Controllo ed eventuale Inserimento in  rivista
			$sql=mysql_query("SELECT * FROM rivista WHERE nome LIKE '$nome_rivista' AND numero=$numero_rivista")or die(mysql_error());
			if(mysql_num_rows($sql)==0)
			{ 
			$query="INSERT INTO rivista (nome,numero,AnnoPubblicazione) VALUES ('$nome_rivista','$numero_rivista','$anno_rivista')";
				$risultato=mysql_query($query);
				if (!$risultato) {
					die("Errore nella query $query: " . mysql_error());
					}	
			}
						
			
			//Controllo ed eventuale Inserimento in  tipologia
			
			$sql=mysql_query("SELECT * FROM tipologia WHERE genere LIKE '$tipo_articolo'")or die(mysql_error());
			if(mysql_num_rows($sql)==0)
			{ 
			$query="INSERT INTO tipologia (genere) VALUES ('$tipo_articolo')";
				$risultato=mysql_query($query);
				if (!$risultato) {
					die("Errore nella query $query: " . mysql_error());
					}
			}
			
			
			
			//ottenimento chiavi
			$chiave_tipologia=mysql_result(mysql_query("SELECT id FROM tipologia WHERE genere LIKE '$tipo_articolo'"),0);
			$chiave_rivista=mysql_result(mysql_query("SELECT id FROM rivista WHERE nome LIKE '$nome_rivista' AND numero='$numero_rivista'"),0);
			
			
			
			
			//aggionamento
			$query="UPDATE articolo SET titolo='$titolo_articolo',sommario='$sommario_articolo',descrizione='$descrizione_articolo',id_tipologia='$chiave_tipologia',id_rivista='$chiave_rivista' WHERE id='$chiave_articolo'";
				$risultato=mysql_query($query);
				if (!$risultato) {
					die("Errore nella query $query: " . mysql_error());
					}
		?>
            	<br/>
            	<img id="sposta_al_centro2" src="img/successo2.png"><br/>
                <p class="scritta">
				Aggiornamento Avvenuto con successo.<br/>Attendi Verrai reinderizzato alal scheda dell'articolo.
            	</p>
                <?php
			
			header("refresh:5;url=scheda_articolo.php?ia=$chiave_articolo");

			
		

			
			
			}
			
			
			
			
			
		
		else
		{
			?>
            <h4 class="titoloparagrafo">Modifica Articolo</h4>

           <form id="inserisciarticolo" action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="POST">
           	<div id="Sezione">
                  <h4 id="paragrafoSezione">Articolo</h4><br/>

            <label>Titolo* </label><input type="text" size="60" name="titolo_articolo" pattern="[A-Z a-z]{3,20}" maxlength="20" placeholder="Titolo Articolo" required="required"/><br>
            <label>Tipo*</label> <select name="tipo_articolo" required>
   							<option value="Informatica" selected="selected">Informatica </option>
   							<option value="Biologia">Biologia </option>
   							<option value="Storia">Storia </option>
                            <option value="Medicina">Medicina </option>
   							<option value="Fisica">Fisica </option>
                            <option value="Astronomia">Astronomia </option>
   							<option value="Archeologia">Archeologia </option>
                            <option value="Chimica">Chimica</option>
                            <option value="Robotica">Robotica </option>
   							<option value="Matematica">Matematica</option>
                            <option value="Altro">Altro</option>
 						 </select><br/>
            <label>Sommario*</label><textarea name="sommario_articolo" required placeholder="Inserisci qui il sommario dell'articolo"/></textarea><br/>
            <label>Descrizione*</label><textarea name="descrizione_articolo"  required="required" placeholder="Descrizione Articolo"/></textarea><br/>

			
            
                  <br/>  <h4 id="paragrafoSezione">Rivista</h4><br/>

            <label>Nome*</label><input type="text" size="60" name="nome_rivista" pattern="[A-Z a-z]{3,20}" maxlength="60" placeholder="None della rivista in cui è presente l'articolo" required="required"/><br/>
            <label>Numero</label><input type="number" size="20" pattern="[0-9]{0,20}" name="numero_rivista" placeholder="Numero della rivista in cui è presente l'articolo" required="required"/><br/>
            <label>Anno</label><select name="anno_rivista" required>
   							<?php
								for($i=1990;$i<=date('Y');$i++) 
								{
									echo '<option value="'.$i.'">'.$i.'</option>';
								}
								?>
 						 </select><br/>
                         
                         <input type="hidden" value="<?php echo $chiave_articolo=$_REQUEST['x'];?>" name="chiave_articolo"><br/><br/>

           
					<input class="bottone" type="submit" name="invia" value="Aggiorna" />
                    <input class="bottone" type="reset" name="reset" value="Reset">
                
                
			</form>
            </div>
            <?php
		}
		?>
            
        </div>
        
        
</main>
	<footer class="bordof">
    	<p>&copy Copyright 2014 Roberto Di Perna</p>
	</footer>
	</body>
</html>