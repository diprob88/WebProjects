<!doctype html>
<html lang="it">
<head>
<meta charset="utf-8">
<title>SchedaArticolo</title>
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
       
                          <h4 class="titoloparagrafo">Scheda Articolo</h4>

       	 <div id="Sezione">
        <?php
		$chiave_articolo=$_REQUEST['ia'];
		//estrarre dai dall'articolo
		$query="SELECT * FROM articolo WHERE id='$chiave_articolo'";
		$risultato=mysql_query($query)or die(mysql_error());;
		$titolo=mysql_result($risultato,0,"titolo");
		$sommario=mysql_result($risultato,0,"sommario");
	 	$descrizione=mysql_result($risultato,0,"descrizione");
		$pdf=mysql_result($risultato,0,"PDF");
		$chiave_rivista=mysql_result($risultato,0,"id_rivista");
		$chiave_utente= mysql_result($risultato,0,"id_utente");
		//estraiamo dati da rivista
		$queryr="SELECT * FROM rivista WHERE id='$chiave_rivista'";
		$ris=mysql_query($queryr)or die(mysql_error());;
		$nome_rivista=mysql_result($ris,0,"nome");
		$numero_rivista=mysql_result($ris,0,"numero");
		$anno_rivista=mysql_result($ris,0,"AnnoPubblicazione");
		//estraiamo dati da autore
		$querya="SELECT a.nome,a.cognome,a.email FROM autore a,pubblicazione p,articolo r WHERE p.id_articolo=r.id AND p.id_autore=a.id AND titolo LIKE '$titolo'";
		$autore=mysql_query($querya)or die(mysql_error());
		$rowsautore=mysql_num_rows($autore);
		?>
        <h1 class="scritta"><?php echo $titolo?></h1>
        <b class="scritta2">Scritto da:</b><br/><h4><?php for($j=0;$j<$rowsautore;$j++)
			{
				$nome_autore=mysql_result($autore,$j,"nome");
				echo $nome_autore." ";
				$cognome_autore=mysql_result($autore,$j,"cognome");
				echo $cognome_autore."<br/>";
			}?>
                </h4>
            <b class="scritta2">Pubblicato nella rivista: </b><h4><?php echo "".$nome_rivista." n° ".$numero_rivista." dell'anno ".$anno_rivista ?></h4>
        <h4 id="paragrafoSezione">Descrizione Articolo</h4>
        <b class="scritta3"><?php echo $descrizione ?></b>
      <h4 id="paragrafoSezione">Sommario</h4>
            <b class="scritta3"> <?php echo $sommario ?><b><br/><br/>
             <p><a href="<?php echo $pdf?>">Scarica Articolo in PDF</a></p>
             <?php
			 if($userid==$chiave_utente)
			 {
				?>
                <br/><br/>
                      <h4 id="paragrafoSezione">Gestione Articolo</h4><br/><br/>

				 	<button class="bottone" id="sposta_al_centro2" name="modifica" onClick="location.href='modificadatiarticolo.php?x=<?php echo $chiave_articolo?>'">Modifica Articolo</button>
         			<button class="bottone" name="elimmina"onClick="location.href='cancella_articolo.php?x=<?php echo $chiave_articolo?>'">Elimina Articolo</button>
                    <br/><br/> <h4 id="paragrafoSezione">Gestione Autori Articolo</h4><br/><br/>
                    <button class="bottone" id="sposta_al_centro3" name="modifica_autore" onClick="location.href='modifica_autore_articolo.php?x=<?php echo $chiave_articolo?>'">Modifica Autore</button>
         			<button class="bottone" name="elimmina_autore"onClick="location.href='cancella_autore_articolo.php?x=<?php echo $chiave_articolo?>'">Elimina Autore</button>
                    <button class="bottone" name="inserisci_autore" onClick="location.href='nuovo_autore_articolo.php?x=<?php echo $chiave_articolo?>'">Inserisci Autore</button>
			<?php }
			 ?>

         </div>
        
        
</main>
	<footer class="bordof">
    	<p>&copy Copyright 2014 Roberto Di Perna</p>
	</footer>
	</body>
</html>