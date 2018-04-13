<!doctype html>
<html lang="it">
<head>
<?php include ('core.php'); ?>
<meta charset="utf-8">
<title>RicercaArticolo</title>
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
        	<li><a href="index.php">Home</a></li>
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
		{ //azioni PHP
		?>
        
          <h4 class="titoloparagrafo">Ricerca Articolo</h4>
        <div id="Sezione">
		
		<?php
			$titolo=isset($_POST['titolo']) ? clear($_POST['titolo']): false;
			$nome=isset($_POST['nome']) ? clear($_POST['nome']): false;
			$cognome=isset($_POST['cognome']) ? clear($_POST['cognome']): false;
			$rivista=isset($_POST['rivista']) ? clear($_POST['rivista']): false;
			$numero=isset($_POST['numero_rivista']) ? clear($_POST['numero_rivista']): false;
			$anno=isset($_POST['anno']) ? clear($_POST['anno']): false;
			$tipo=isset($_POST['tipo_articolo']) ? clear($_POST['tipo_articolo']): false;
			$query="SELECT x.id, x.titolo,x.PDF,a.nome,a.cognome,t.genere,r.nome,r.numero,r.AnnoPubblicazione,t.genere FROM autore a, rivista r,articolo x,pubblicazione p,tipologia t WHERE p.id_articolo=x.id AND p.id_autore=a.id AND x.id_tipologia=t.id AND x.id_rivista=r.id";
			$ordina=isset($_POST['ordina']) ? clear($_POST['ordina']): false;

			if($tipo!="Tutto")
			{
			 $query=$query." AND t.genere='$tipo'";
			}
			//controlli per preparare la query in base ai camopi inseriti
			if(!empty($titolo))
			{
				$query=$query." AND x.titolo='$titolo'";
			}
			if(!empty($nome))
			{
				$query=$query." AND a.nome='$nome'";
			}
			if(!empty($cognome))
			{
				$query=$query." AND a.cognome='$cognome'";
			}
			if(!empty($rivista))
			{
				$query=$query." AND r.nome='$rivista'";
			}
			if(!empty($numero))
			{
				$query=$query." AND r.numero='$numero'";
			}
			if(!empty($anno))
			{
				$query=$query." AND r.AnnoPubblicazione='$anno'";
			}
			$query=$query." GROUP BY x.titolo";
			
			if($ordina=="id")
			{
				$query=$query." ORDER BY x.id";
			}elseif($ordina=="titolo")
			{
				$query=$query." ORDER BY x.titolo";
			}elseif($ordina=="autore")
			{
				$query=$query." ORDER BY a.cognome";
			}elseif($ordina=="rivista")
			{
				$query=$query." ORDER BY r.nome ";
			}
			
			//avviamo la query
			
			$articolo=mysql_query($query)or die(mysql_error());
			$num= mysql_num_rows($articolo);
			if($num>0)
			{
			?>
            <div class="tabella">
			<table >
			 <tr>
          		<td>Titolo</td>
                <td>Tipologia</td>
                <td>Autore</td>
                <td>Rivista</td>
                <td>Scarica</td>
                <td>Scheda Articolo</td>
          	</tr>
			
			<?php
			for($i=0;$i<$num;$i++)
			{
			$titolo=mysql_result($articolo,$i,"titolo");
			$chiave_articolo=mysql_result($articolo,$i,"id");
			$scarica=mysql_result($articolo,$i,"PDF");
			$riv=mysql_result($articolo,$i,"titolo");
			$annopub=mysql_result($articolo,$i,"AnnoPubblicazione");
			$numeror=mysql_result($articolo,$i,"numero");
			$genere=mysql_result($articolo,$i,"genere");
			//estraiamo tutti gli autori dell'articolo
			$querya="SELECT a.nome,a.cognome FROM autore a,pubblicazione p,articolo r WHERE p.id_articolo=r.id AND p.id_autore=a.id AND titolo LIKE '$titolo'";
			$autore=mysql_query($querya)or die(mysql_error());
			$rowsautore=mysql_num_rows($autore);
			?>
            <tr>
            	<td><?php echo $titolo ?></td>
                <td><?php echo $genere ?></td>
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
          		<td><?php echo $riv." n°".$numeror." anno ".$annopub ?>
                <td><a href="<?php echo $scarica?>">download</a></td>
                <td>
				<?php
			echo '<p><a href="scheda_articolo.php?ia='.$chiave_articolo.'">scheda articolo</a></p>'; ?></td>
            </tr>

			<?php
			}
				
			?>
            </table>
            </div>
                         <br/><br/><button class="bottone" id="sposta_al_centro" onclick="window.location='cerca.php'" >Nuova Ricerca</button>

			
			</div>
			<?php
			}
			else
			{?>			
            <div id="immagine">
            			<img src="img/articolo_non_trovato.png">
                      </div>
                       <br/><br/><button class="bottone" id="sposta_al_centro" onclick="window.location='cerca.php'" >Nuova Ricerca</button>
                        </div>
			<?php
			 }
			}
			
			
			
			
			
		
		else
		{
			?>
            <h4 class="titoloparagrafo">Ricerca Articolo</h4>

            <div id="Sezione">
           
           <form id="cerca" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

            <label>Titolo Articolo </label><input type="text" size="40" pattern="[A-Z a-z]{3,20}" name="titolo" maxlength="30"/><br>
            <label>Tipo</label> <select name="tipo_articolo" required>
   							<option value="Tutto" selected="selected">Tutto </option>
    						<option value="Informatica">Informatica </option>
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
           <label>Nome Autore </label><input type="text" size="40" name="nome"  pattern="[A-Z a-z]{3,20}" maxlength="30" /><br>
			<label>Cognome Autore</label><input type="text" size="40" name="cognome" pattern="[A-Z a-z]{3,20}" maxlength="30" /><br>
			<label>Rivista </label> <input type="text" size="40" name="rivista" pattern="[A-Z a-z]{3,20}" maxlength="30"/><br/>
            <label>Numero</label> <input type="number" size="40" name="numero_rivista"  pattern="[0-9]{4}" maxlength="4"/><br/>
            <label>Anno</label><input type="number" size="40" name="anno" pattern="[0-9]{4}" /><br/>
            <label>Ordina Ricerca per:</label> <select name="ordina" required>
   							<option value="id" selected="selected"> </option>
    						<option value="titolo">Titolo Articolo </option>
   							<option value="autore">Autore </option>
   							<option value="rivista">Rivista </option>
                         
 						 </select><br/><br/><br/>
			 <input class="bottone" type="submit" name="invia" value="Cerca" />
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