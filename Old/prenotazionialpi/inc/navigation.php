<ul id="menu">
<?php 
if($_ruolo=="A") {
?>
	<li id="<?php echo ($_selected=='home'?'selected':'enabled');?>" ><a href="home.php">Home</a></li>
	<i><li id="label"><a href="#">Funzioni</a></li></i>	
	<li id="<?php echo ($_selected=='calendariopren'?'selected':'enabled');?>" ><a href="calendariopren.php">Calendario Pren.</a></li>
	<li id="<?php echo ($_selected=='prenotazioni'?'selected':'enabled');?>" ><a href="prenotazioni.php">Prenotazioni</a></li>
	<!--<li id="<?php //echo ($_selected=='calendario'?'selected':'enabled');?>" ><a href="calendario.php">Calendario Pre-Ric.</a></li> -->
	<!--<li id="<?php //echo ($_selected=='esamipazienti'?'selected':'enabled');?>" ><a href="esamipazienti.php">Pre-Ricovero</a></li> -->
	<li id="<?php echo ($_selected=='pazienti'?'selected':'enabled');?>" ><a href="pazienti.php">Pazienti</a></li>
	<li id="<?php echo ($_selected=='download'?'selected':'enabled');?>" ><a href="download.php">Download</a></li>
	<li id="<?php echo ($_selected=='change_pswd'?'selected':'enabled');?>" ><a href="change_pswd.php">Cambio Password</a></li>
	<i><li id="label"><a href="#">Configurazione</a></li></i>
	<!--<li id="<?php //echo ($_selected=='diagnosi'?'selected':'enabled');?>" ><a href="diagnosi.php">Diagnosi</a></li> -->
	<!--<li id="<?php //echo ($_selected=='interventi'?'selected':'enabled');?>" ><a href="interventi.php">Interventi Chir.</a></li> -->
	<li id="<?php echo ($_selected=='prestazioni'?'selected':'enabled');?>" ><a href="prestazioni.php">Prestazioni San.</a></li>
	<!--<li id="<?php //echo ($_selected=='esami'?'selected':'enabled');?>" ><a href="esami.php">Esami</a></li>-->
    <!--<li id="<?php //echo ($_selected=='unitaoperativa'?'selected':'enabled');?>" ><a href="unitaoperativa.php">Unit&agrave; Operative</a></li> -->
    <!--<li id="<?php //echo ($_selected=='asa'?'selected':'enabled');?>" ><a href="asa.php">Classificazione ASA</a></li> -->
	<li id="<?php echo ($_selected=='medici'?'selected':'enabled');?>" ><a href="medici.php">Medici</a></li>
	<!--<li id="<?php //echo ($_selected=='medician'?'selected':'enabled');?>" ><a href="medician.php">Medici Anestesisti</a></li> -->
    <!--<li id="<?php //echo ($_selected=='medicica'?'selected':'enabled');?>" ><a href="medicica.php">Medici Cardiologi</a></li> -->
    <li id="<?php echo ($_selected=='user'?'selected':'enabled');?>" ><a href="user.php">Utenti</a></li>
	<li id="enabled"><a href="chiudi.php">Esci</a></li>	
<?php 
}
elseif($_ruolo=="P") {
?>
	<li id="<?php echo ($_selected=='home'?'selected':'enabled');?>" ><a href="home.php">Home</a></li>
	<i><li id="label"><a href="#">Funzioni</a></li></i>	
	<li id="<?php echo ($_selected=='calendariopren'?'selected':'enabled');?>" ><a href="calendariopren.php">Calendario Pren.</a></li>
	<li id="<?php echo ($_selected=='prenotazioni'?'selected':'enabled');?>" ><a href="prenotazioni.php">Prenotazioni</a></li>
	<!--<li id="<?php //echo ($_selected=='calendario'?'selected':'enabled');?>" ><a href="calendario.php">Calendario Pre-Ric.</a></li> -->
	<!--<li id="<?php //echo ($_selected=='esamipazienti'?'selected':'enabled');?>" ><a href="esamipazienti.php">Pre-Ricovero</a></li> -->
    <li id="<?php echo ($_selected=='pazienti'?'selected':'enabled');?>" ><a href="pazienti.php">Pazienti</a></li>
	<li id="<?php echo ($_selected=='download'?'selected':'enabled');?>" ><a href="download.php">Download</a></li>
	<li id="<?php echo ($_selected=='change_pswd'?'selected':'enabled');?>" ><a href="change_pswd.php">Cambio Password</a></li>
	<i><li id="label"><a href="#">Configurazione</a></li></i>
    <!--<li id="<?php //echo ($_selected=='diagnosi'?'selected':'enabled');?>" ><a href="diagnosi.php">Diagnosi</a></li> -->
	<!-- <li id="<?php //echo ($_selected=='interventi'?'selected':'enabled');?>" ><a href="interventi.php">Interventi Chir.</a></li> -->
	<!--<li id="<?php //echo ($_selected=='prestazioni'?'selected':'enabled');?>" ><a href="prestazioni.php">Prestazioni San.</a></li> -->
	<li id="disabled"><a href="#">Prestazioni San.</a></li>
    <!--<li id="disabled"><a href="#">Esami</a></li><-->
	 <!-- <li id="<?php //echo ($_selected=='unitaoperativa'?'selected':'enabled');?>" ><a href="unitaoperativa.php">Unit&agrave; Operative</a></li> -->
   <!--<li id="disabled"><a href="#">Classificazione ASA</a></li><-->
    <!--<li id="<?php //echo ($_selected=='medici'?'selected':'enabled');?>" ><a href="medici.php">Medici</a></li> -->
	<li id="disabled"><a href="#">Medici</a></li>
    <!--<li id="<?php //echo ($_selected=='medician'?'selected':'enabled');?>" ><a href="medician.php">Medici Anestesisti</a></li> -->
    <!--<li id="<?php //echo ($_selected=='medicica'?'selected':'enabled');?>" ><a href="medicica.php">Medici Cardiologi</a></li> -->
    <!--<li id="<?php //echo ($_selected=='user'?'selected':'enabled');?>" ><a href="user.php">Utenti</a></li> -->
	<li id="disabled"><a href="#">Utenti</a></li>
	<li id="enabled"><a href="chiudi.php">Esci</a></li>	
	
<?php 
}
elseif($_ruolo=="U") {
?>
	<li id="<?php echo ($_selected=='home'?'selected':'enabled');?>" ><a href="home.php">Home</a></li>
	<i><li id="label"><a href="#">Funzioni</a></li></i>	
	<li id="<?php echo ($_selected=='calendariopren'?'selected':'enabled');?>" ><a href="calendariopren.php">Calendario Pren.</a></li>
	<li id="<?php echo ($_selected=='prenotazioni'?'selected':'enabled');?>" ><a href="prenotazioni.php">Prenotazioni</a></li>
	<!--<li id="<?php //echo ($_selected=='calendario'?'selected':'enabled');?>" ><a href="calendario.php">Calendario Pre-Ric.</a></li> -->
	<!--<li id="<?php //echo ($_selected=='esamipazienti'?'selected':'enabled');?>" ><a href="esamipazienti.php">Pre-Ricovero</a></li> -->
    <!--<li id="<?php echo ($_selected=='pazienti'?'selected':'enabled');?>" ><a href="pazienti.php">Pazienti</a></li> -->
	<li id="<?php echo ($_selected=='download'?'selected':'enabled');?>" ><a href="download.php">Download</a></li>
	<li id="<?php echo ($_selected=='change_pswd'?'selected':'enabled');?>" ><a href="change_pswd.php">Cambio Password</a></li>
	<!--<i><li id="label"><a href="#">Configurazione</a></li></i> -->
    <!--<li id="<?php //echo ($_selected=='diagnosi'?'selected':'enabled');?>" ><a href="diagnosi.php">Diagnosi</a></li>-->
	<!--<li id="<?php //echo ($_selected=='interventi'?'selected':'enabled');?>" ><a href="interventi.php">Interventi Chir.</a></li>-->
	<!--<li id="<?php //echo ($_selected=='prestazioni'?'selected':'enabled');?>" ><a href="prestazioni.php">Prestazioni San.</a></li> -->  
    <!--<li id="disabled"><a href="#">Prestazioni San.</a></li> -->
	<!--<li id="disabled"><a href="#">Esami</a></li> -->
    <!--<li id="<?php //echo ($_selected=='unitaoperativa'?'selected':'enabled');?>" ><a href="unitaoperativa.php">Unit&agrave; Operative</a></li> -->	
    <!--<li id="disabled"><a href="#">Classificazione ASA</a></li><-->
    <!--<li id="disabled"><a href="#">Medici</a></li> -->
	<!--<li id="<?php //echo ($_selected=='medici'?'selected':'enabled');?>" ><a href="medici.php">Medici</a></li> -->
    <!--<li id="disabled"><a href="#">Medici Anestesisti</a></li><-->
    <!--<li id="disabled"><a href="#">Medici Cardiologi</a></li><-->
    <!--<li id="disabled"><a href="#">Utenti</a></li> -->
	<li id="enabled"><a href="chiudi.php">Esci</a></li>
<?php 
}
?>
</ul>
