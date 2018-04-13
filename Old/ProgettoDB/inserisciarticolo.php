<!doctype html>
<html lang="it">
<head>
<?php include ('core.php'); ?>
<meta charset="utf-8">
<title>InserimentoArticolo</title>
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
			$username=$_SESSION['username'];
		
		//azioni PHP
			$titolo_articolo=isset($_POST['titolo_articolo']) ? clear($_POST['titolo_articolo']): false;
			$tipo_articolo=isset($_POST['tipo_articolo']) ? clear($_POST['tipo_articolo']): false;
			$pdf_articolo=isset($_POST['pdf_articolo']) ? clear($_POST['pdf_articolo']): false;
			$sommario_articolo=isset($_POST['sommario_articolo']) ? clear($_POST['sommario_articolo']): false;
			$descrizione_articolo=isset($_POST['descrizione_articolo']) ? clear($_POST['descrizione_articolo']): false;
			$numero_rivista=isset($_POST['numero_rivista']) ? clear($_POST['numero_rivista']): false;
			$anno_rivista=isset($_POST['anno_rivista']) ? clear($_POST['anno_rivista']): false;
			$nome_rivista=isset($_POST['nome_rivista']) ? clear($_POST['nome_rivista']): false;
			$nome_autore=isset($_POST['nome_autore']) ? clear($_POST['nome_autore']): false;
			$cognome_autore=isset($_POST['cognome_autore']) ? clear($_POST['cognome_autore']): false;
			$email_autore=isset($_POST['email_autore']) ? clear($_POST['email_autore']): false;
			$nome_autore2=isset($_POST['nome_autore2']) ? clear($_POST['nome_autore2']): false;
			$cognome_autore2=isset($_POST['cognome_autore2']) ? clear($_POST['cognome_autore2']): false;
			$email_autore2=isset($_POST['email_autore2']) ? clear($_POST['email_autore2']): false;
			$nome_autore3=isset($_POST['nome_autore3']) ? clear($_POST['nome_autore3']): false;
			$cognome_autore3=isset($_POST['cognome_autore3']) ? clear($_POST['cognome_autore3']): false;
			$email_autore3=isset($_POST['email_autore3']) ? clear($_POST['email_autore3']): false;
			
			//variabili per chiavi
			$chiave_articolo="";
			$chiave_autore="";
			$chiave_tipologia="";
			$chiave_utente=mysql_result(mysql_query("SELECT id FROM utenti WHERE username LIKE '$username'"),0);
			$chiave_rivista="";
			//controlli per l'inserimento dei dati nell'articolo
			if(mysql_num_rows(mysql_query("SELECT * FROM articolo WHERE titolo LIKE '$titolo_articolo'"))>0)
			{
				?>
            	<br/>
            	<img id="sposta_al_centro2" src="img/errore.png"><br/>
                <p class="scritta">
				Titolo dell'articolo già in uso si prega di sceglierne un altro.<br/><br/><a href="javascript:history.back();">Indietro</a>
            	</p>
            <?php
				
			}
			else
			{
				
				//controllo che non ci sono errori nell'upload del file
				if($_FILES['pdf_articolo']['error']==0)
				{
				//controllo che il file sia in formato pdf
				if($_FILES['pdf_articolo']['type'] != "application/pdf") die ("il formato selezionato non è valido");
				//controllo che il file non abbia dimensione maggiore a 2MB
				if($_FILES['pdf_articolo']['size']>2097152)die ("Il File inserito è troppo grande, dimensione massima consentita 2MB");
				copy($_FILES['pdf_articolo']['tmp_name'],"upload_utenti/articoli/".$_FILES['pdf_articolo']['name']) or die ("Impossibile caricare il file");	
				}
		
		
				
				
		$percorso="upload_utenti/articoli/".$_FILES['pdf_articolo']['name'];
				$query="INSERT INTO articolo (titolo,sommario,descrizione,PDF) VALUES ('$titolo_articolo','$sommario_articolo','$descrizione_articolo','$percorso')";
				$risultato=mysql_query($query);
				if (!$risultato) {
					die("Errore nella query $query: " . mysql_error());
					}
				
				
		//Inserimento in tipologia
		
		
		$sql=mysql_query("SELECT * FROM tipologia WHERE genere LIKE '$tipo_articolo'")or die(mysql_error());
			if(mysql_num_rows($sql)==0)
			{ 
			$query="INSERT INTO tipologia (genere) VALUES ('$tipo_articolo')";
				$risultato=mysql_query($query);
				if (!$risultato) {
					die("Errore nella query $query: " . mysql_error());
					}
			}
		
				
				
			
		
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
				
			//Inserimento in rivista
			
			$sql=mysql_query("SELECT * FROM rivista WHERE nome LIKE '$nome_rivista' AND numero=$numero_rivista")or die(mysql_error());
			if(mysql_num_rows($sql)==0)
			{ 
			$query="INSERT INTO rivista (nome,numero,AnnoPubblicazione) VALUES ('$nome_rivista','$numero_rivista','$anno_rivista')";
				$risultato=mysql_query($query);
				if (!$risultato) {
					die("Errore nella query $query: " . mysql_error());
					}	
			}
			
			//ottenimento chiavi
			$chiave_articolo=mysql_result(mysql_query("SELECT id FROM articolo WHERE titolo LIKE '$titolo_articolo'"),0);
			$chiave_autore=mysql_result(mysql_query("SELECT id FROM autore WHERE nome LIKE '$nome_autore' AND cognome LIKE '$cognome_autore'"),0);
			$chiave_tipologia=mysql_result(mysql_query("SELECT id FROM tipologia WHERE genere LIKE '$tipo_articolo'"),0);
			$chiave_rivista=mysql_result(mysql_query("SELECT id FROM rivista WHERE nome LIKE '$nome_rivista' AND numero='$numero_rivista'"),0);
				
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
			
			
			
			//inserimento chiavi in articolo
			$query="UPDATE articolo SET id_utente='$chiave_utente',id_tipologia='$chiave_tipologia',id_rivista='$chiave_rivista' WHERE id='$chiave_articolo'";
				$risultato=mysql_query($query);
				if (!$risultato) {
					die("Errore nella query $query: " . mysql_error());
					}
					?>
            	<br/>
            	<img id="sposta_al_centro2" src="img/successo2.png"><br/>
                <p class="scritta">
				Dati Inseriti con successo<br/><br/><a href="javascript:history.back();">Inserisci un nuovo articolo</a>
            	</p>
            <?php
			}
			
		}
		else
		{
			?>
            
    		<h4 class="titoloparagrafo">Inserimento Articolo</h4>

            <div id="Sezione">
           <form id="inserisciarticolo" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="POST">
           	
            <h4 id="paragrafoSezione">Articolo</h4><br/>
            <label>Titolo*: </label><input type="text" size="50" name="titolo_articolo" maxlength="20" placeholder="Titolo Articolo" required="required"/><br>
            <label>Tipo*:</label> <select name="tipo_articolo" required>
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
			<label>Inserisci* </label><input type="file" name="pdf_articolo"  required="required"/><br/>
            <label>Sommario*:</label><textarea name="sommario_articolo" required placeholder="Inserisci qui il sommario dell'articolo"/></textarea><br/>
            <label>Descrizione*:</label><textarea name="descrizione_articolo"  required="required" placeholder="Descrizione Articolo"/></textarea><br/>

			<br/><h4 id="paragrafoSezione">Autore (Massimo 3 Autori)</h4><br/>
            
           
            <label>Nome*:</label> <input type="text" size="50" pattern="[A-Z a-z]{3,20}" name="nome_autore" maxlength="32" placeholder="Nome Autore Articolo" required="required"/><br/>
            <label>Cognome*:</label> <input type="text" size="50" pattern="[A-Z a-z]{3,20}" name="cognome_autore" maxlength="32" placeholder="Cognome Autore Articolo" required="required"/><br/>
            <label>Email: </label><input type="email" size="50" name="email_autore"  pattern="[^@]+@[^@]+\.[a-zA-Z]{2,4}" placeholder="Email Autore" maxlength="60"/><br/>
           <br/> <h4 id="paragrafoSezione">Autore 2</h4><br/>
            <label>Nome:</label> <input type="text" size="50" pattern="[A-Z a-z]{3,20}" name="nome_autore2" maxlength="32" placeholder="Nome Autore Articolo" /><br/>
            <label>Cognome:</label> <input type="text" size="50" pattern="[A-Z a-z]{3,20}" name="cognome_autore2" maxlength="32" placeholder="Cognome Autore Articolo"/><br/>
            <label>Email:</label><input type="email" size="50" name="email_autore2"  pattern="[^@]+@[^@]+\.[a-zA-Z]{2,4}" placeholder="Email Autore" maxlength="60"/><br/>
          <br/>  <h4 id="paragrafoSezione">Autore 3</h4><br/>
            <label>Nome:</label> <input type="text" size="50" pattern="[A-Z a-z]{3,20}" name="nome_autore3" maxlength="32" placeholder="Nome Autore Articolo" /><br/>
            <label>Cognome:</label> <input type="text" size="50" pattern="[A-Z a-z]{3,20}"  name="cognome_autore3" maxlength="32" placeholder="Cognome Autore Articolo"/><br/>
            <label>Email:</label><input type="email"  pattern="[^@]+@[^@]+\.[a-zA-Z]{2,4}" size="50" name="email_autore3" placeholder="Email Autore" maxlength="60"/><br/>
            
           
         <br/>   <h4 id="paragrafoSezione">Rivista</h4><br/>
            <label>Nome*:</label><input type="text" size="50"pattern="[A-Z a-z]{3,20}"  name="nome_rivista" maxlength="60" placeholder="None della rivista in cui è presente l'articolo" required="required"/><br/>
            <label>Numero*:</label><input type="number" size="50"pattern="[0-9]{1,20}" name="numero_rivista" placeholder="Numero della rivista in cui è presente l'articolo" required="required"/><br/>
            <label>Anno*:</label><select name="anno_rivista" required>
   							<?php
								for($i=1990;$i<=date('Y');$i++) 
								{
									echo '<option value="'.$i.'">'.$i.'</option>';
								}
								?>
 						 </select><br/><br/>

            
					<input class="bottone" id="sposta_al_centro" type="submit" name="invia" value="Aggiungi" />
                    <input  class="bottone"type="reset" name="reset" value="Azzera">
                
                
			</form>
            
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