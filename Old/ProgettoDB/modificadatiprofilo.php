<!doctype html>
<html lang="it">
<head>
<meta charset="utf-8">
<title>ModificaDatiProfilo</title>
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
       	
        <?php
		
		if(isset($_POST['invia']))
		{ 
		

			$username=$_SESSION['username'];
			$chiave_utente=mysql_result(mysql_query("SELECT id FROM utenti WHERE username LIKE '$username'"),0);

			//azioni PHP
			$nome=isset($_POST['nome']) ? clear($_POST['nome']): false;
			$cognome=isset($_POST['cognome']) ? clear($_POST['cognome']): false;
			$email=isset($_POST['email']) ? clear($_POST['email']): false;
			$confermaemail=isset($_POST['confermaemail']) ? clear($_POST['confermaemail']): false;
			$url=isset($_POST['url']) ? clear($_POST['url']): false;
			$indirizzo=isset($_POST['indirizzo']) ? clear($_POST['indirizzo']): false;
			$foto="img/user.png";
			$gg=isset($_POST['giorno_nascita']) ? clear($_POST['giorno_nascita']): false;
			$mm=isset($_POST['mese_nascita']) ? clear($_POST['mese_nascita']): false;
			$aa=isset($_POST['anno_nascita']) ? clear($_POST['anno_nascita']): false;
			$data="";


			//controllo mail
			if($email!=$confermaemail)
			{?>
            	<br/>
            	<img id="sposta_al_centro2" src="img/errore.png"><br/>
                <p class="scritta">
				I due indirizzi Email non corrispondono,digitare correttamente.<br/><br/><a href="javascript:history.back();">Indietro</a>
            	</p>
                <?php
			}elseif(($mm=="Febbraio")&&($gg>29))
			{?>
            	<br/>
            	<img id="sposta_al_centro2" src="img/errore.png"><br/>
                <p class="scritta">
				Data di Nascita inserita non valida.<br/><br/><a href="javascript:history.back();">Indietro</a>
            	</p>
                <?php
			}elseif((($mm=="Novembre")||($mm=="Aprile")||($mm=="Giugno")||($mm=="Settembre"))&&($gg>30))
			{
				?>
            	<br/>
            	<img id="sposta_al_centro2" src="img/errore.png"><br/>
                <p class="scritta">
				Data di Nascita inserita non valida.<br/><br/><a href="javascript:history.back();">Indietro</a>
            	</p>
                <?php
			}
			else
			{
				$data=$gg." ".$mm." ".$aa;
				//controllo errori upload foto
				if($_FILES['foto']['error']==0)
				{
					//controllo che il file sia in formato pdf
					if(($_FILES['foto']['type'] != "image/jpeg")&&($_FILES['foto']['type'] != "image/png"))
					{ 
			 echo 'Errore Aggiornamento Foto<br/Il formato selezionato non è valido è permesso il formato JPEG o PNG.<br/><br/><a href="javascript:history.back();">Indietro</a>';	
				}elseif($_FILES['foto']['size']>1048576)//controllo che il file non sia superiore a 1mb
			{
				echo 'Errore Aggiornamento Foto<br/Il File inserito è troppo grande, dimensione massima consentita 1MB.<br/><br/><a href="javascript:history.back();">Indietro</a>';
			}else
			{
				$immagine=$_FILES['foto']['tmp_name'];
				$dimensioni= getimagesize($immagine);
				$larghezza=$dimensioni['0'];
				$altezza=$dimensioni['1'];
			
				if($larghezza>140||$altezza>146)
				{
		       	echo 'Errore Aggiornamento Foto<br/>Il File inserito deve avere dimensioni 140x146.<br/><br/><a href="javascript:history.back();">Indietro</a>';	
				}
				else
				{
				$foto="upload_utenti/immagini/".$_FILES['foto']['name'];
				copy($_FILES['foto']['tmp_name'],"upload_utenti/immagini/".$_FILES['foto']['name']) or die ("Impossibile caricare il file");	
				}
			}
				//aggionamento
			$query="UPDATE utenti SET nome='$nome',cognome='$cognome',email='$email',indirizzo='$indirizzo',url='$url',data_di_nascita='$data',foto='$foto' WHERE id='$chiave_utente'";
				$risultato=mysql_query($query);
				if (!$risultato) {
					die("Errore nella query $query: " . mysql_error());
					}?>
            	<br/>
            	<img id="sposta_al_centro2" src="img/successo2.png"><br/>
                <p class="scritta">
					Aggiornamento Avvenuto con successo.Attendi verrai Reindirizzato al tuo profilo
            	</p>
            <?php
					header("refresh:5;url=ilmioprofilo.php");
		
			}
		}	
				
		}
		else
		{
			?>
                                     <h4 class="titoloparagrafo">Modifica dati Profilo</h4>

            <div id="Sezione">
            <br/>
           <form id="inserisciarticolo" action="<?php echo $_SERVER['PHP_SELF']; ?>"  enctype="multipart/form-data" method="POST">
            <br/><label>Nome* </label><input type="text" size="50" name="nome" maxlength="20" placeholder="Inserisci il tuo Nome" required="required"/><br>
            <br/><label>Cognome* </label><input type="text" size="50" name="cognome" maxlength="20" placeholder="Inserisci il tuo Cognome" required="required"/><br>
            <br/><label>Email*</label><input type="email" size="50" name="email" placeholder="Inserisci la tua email" maxlength="60" required="required"/><br/>
           <br/> <label>Conferma Email*</label><input type="email" size="50" name="confermaemail" maxlength="60" placeholder="Reinserisci la tua email" required="required"/><br/>
        	<br/><label>Indirizzo</label><input type="text" size="50" name="indirizzo" placeholder="Indirizzo Abitazione" /><br/>
          <br/>  <label> Data di Nascita*</label>
            Giorno<select name="giorno_nascita" required>
   							<?php
								for($i=1;$i<=31;$i++) 
								{
									echo '<option value="'.$i.'">'.$i.'</option>';
								}
								?>
 						 </select>
				Mese<select name="mese_nascita" required>
   							<option value="Gennaio" selected="selected">Gennaio </option>
   							<option value="Febbraio">Febbraio </option>
   							<option value="Marzo">Marzo </option>
                            <option value="Aprile">Aprile </option>
   							<option value="Maggio">Maggio </option>
                            <option value="Giugno">Giugno </option>
   							<option value="Luglio">Luglio </option>
                            <option value="Agosto">Agosto</option>
                            <option value="Settembre">Settembre </option>
   							<option value="Ottobre">Ottobre</option>
                            <option value="Novembre">Novembre</option>
                            <option value="Dicembre">Dicembre</option>
 						 </select>	
                Anno<select name="anno_nascita" required>
   							<?php
								for($i=1950;$i<=date('Y');$i++) 
								{
									echo '<option value="'.$i.'">'.$i.'</option>';
								}
								?>
 						 </select><br/>
              <br/>   <label>Foto profilo </label><input type="file" name="foto" /><br/>
 			<br/>	<label>URL</label><input type="url" size="40" name="url" value="http://" /><br/>
                        <br/><br/> <input class="bottone" type="submit" name="invia" value="Aggiorna Profilo" />
                    <input class="bottone" type="reset" name="reset" value="Reset">
                
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