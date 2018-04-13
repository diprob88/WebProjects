<!doctype html>
<html lang="it">
<head>
<meta charset="utf-8">
<title>IlMioProfilo</title>
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
                  <h4 class="titoloparagrafo">i Miei Dati</h4>

        <div id="Sezione">
       	
          <?php
		  $username=$_SESSION['username'];
		  $query="SELECT * FROM utenti WHERE username='$username'";
		  $risultato=mysql_query($query)or die(mysql_error());;
		  $nome=mysql_result($risultato,0,"nome");
		  $cognome=mysql_result($risultato,0,"cognome");
		  $data_di_nascita=mysql_result($risultato,0,"data_di_nascita");
		  $indirizzo=mysql_result($risultato,0,"indirizzo");
		  $email=mysql_result($risultato,0,"email");
		  $foto=mysql_result($risultato,0,"foto");
		  $url=mysql_result($risultato,0,"url");
		  ?>
          
          <p><b class="scritta">Nome:</b> <b class="scritta2"><?php echo $nome ?></b></p>
          <p><b class="scritta">Cognome:</b><b class="scritta2"> <?php echo $cognome ?></b></p>
          <p><b class="scritta">Data di Nascita:</b><b class="scritta2"><?php echo $data_di_nascita ?></b></p>
          <p><b class="scritta">Indirizzo: </b><b class="scritta2"><?php echo $indirizzo ?></b></p>
		  <p><b class="scritta">Email:</b> <b class="scritta2"><?php echo $email ?></p>
          <p><b class="scritta">Sito Internet:</b> <b class="scritta2"><?php echo $url ?></b></p><br/><br/>


         
         <button class="bottone" id="sposta_al_centro2" name="modifica" onClick="location.href='modificadatiprofilo.php'">Modifica dati Account</button>
         <button class="bottone" name="elimmina" onClick="location.href='cancella_utente.php'">Elimina Account</button><br/><br/>
         
                <h4 id="paragrafoSezione">I Miei Articoli</h4>

         <div class="tabella">
          <table>
          <tr>
          		<td>Titolo</td>
                <td>Autore</td>
                <td>Scarica</td>
                <td>Scheda Articolo</td>
          </tr>
			<?php
			
			$chiave_utente=mysql_result(mysql_query("SELECT id FROM utenti WHERE username LIKE '$username'"),0);
			$query="SELECT * FROM articolo WHERE id_utente='$chiave_utente'";
			$articolo=mysql_query($query)or die(mysql_error());
			$num= mysql_num_rows($articolo);
			for($i=0;$i<$num;$i++)
			{
			$titolo=mysql_result($articolo,$i,"titolo");
			$chiave_articolo=mysql_result($articolo,$i,"id");
			$scarica=mysql_result($articolo,$i,"PDF");
			$query="SELECT a.nome,a.cognome FROM autore a,pubblicazione p,articolo r WHERE p.id_articolo=r.id AND p.id_autore=a.id AND titolo LIKE '$titolo'";
			$autore=mysql_query($query)or die(mysql_error());
			$rowsautore=mysql_num_rows($autore);
			?>
            <tr>
            	<td><?php echo $titolo ?>
                <td>
            <?php
			//echo $titolo." ";
			for($j=0;$j<$rowsautore;$j++)
			{
				$nome_autore=mysql_result($autore,$j,"nome");
				echo $nome_autore." ";
				$cognome_autore=mysql_result($autore,$j,"cognome");
				echo $cognome_autore."<br/>";
				
			}
			?></td>
                <td><a href="<?php echo $scarica?>">download</a></td>
                <td>
				<?php
			echo '<a href="scheda_articolo.php?ia='.$chiave_articolo.'">scheda articolo</a>'; ?></td>
            </tr>

			<?php
			}

			?>
            </table>
         </div>
        </div>
        
</main>
	<footer class="bordof">
    	<p>&copy Copyright 2014 Roberto Di Perna</p>
	</footer>
	</body>
</html>