 <script type="text/javascript">
                    $(document).ready(function(){
                        $('#menu a').each(function() {  // ('#menu a') si riferisce all'id del vostro tag <ul id="menu"> che a sua volta deve contenere i vari <li><a href="linkpagina">Home</a></li> e poi essere chiuso </ul>
                            if(this.href.trim() == window.location)
                                $(this).addClass("evidenzia");
                        });
                    });
                </script>


<ul id="menu" class="sidebar-nav ">

<?php 
if($_ruolo=="A") 
{?>
    <li class="sidebar-brand"><p class="text-center">Men&Ugrave;</p></li>
	<li><a href="home.php"><span class="glyphicon glyphicon-align-justify">&nbsp</span>Home</a></li>
	<li><a href="#"><span class="glyphicon glyphicon-certificate">&nbsp</span>Funzioni</a></li>	
	<li><a href="calcolo.php"><span class="glyphicon glyphicon-briefcase">&nbsp</span>Calcolo</a></li>
    <li><a href="esporta.php"><span class="glyphicon glyphicon-hdd">&nbsp</span>Esporta Abbattimenti</a></li>
	<li><a href="download.php"><span class="glyphicon glyphicon-download-alt">&nbsp</span>Download</a></li>
	<li><a href="change_pswd.php"><span class="glyphicon glyphicon-transfer">&nbsp</span>Cambio Password</a></li>
	<li><a href="#"><span class="glyphicon glyphicon-wrench">&nbsp</span>Configurazione</a></li>
	<li><a href="aziende.php"><span class="glyphicon glyphicon-align-left">&nbsp</span>Aziende Sanitarie</a></li>
	<li><a href="presidi.php"><span class="glyphicon glyphicon-align-left">&nbsp</span>Presidi Ospedalieri</a></li>
	<li><a href="unitaoperativa.php"><span class="glyphicon glyphicon-align-left">&nbsp</span>Unit&agrave; Operative</a></li>
	<!-- <li><a href="#"><span class="glyphicon glyphicon-phone-alt">&nbsp</span>Medici di Reparto</a></li>
    <li><a href="#"><span class="glyphicon glyphicon-phone-alt">&nbsp</span>Medici Anestesisti</a></li>
    <li><a href="#"><span class="glyphicon glyphicon-phone-alt">&nbsp</span>Medici Cardiologi</a></li> -->
    <li><a href="user.php"><span class="glyphicon glyphicon-user">&nbsp</span>Utenti</a></li>
	<li><a href="chiudi.php"><span class="glyphicon glyphicon-off">&nbsp</span>Esci</a></li>
<?php 
}
elseif($_ruolo=="P")
 {?>
   	<li class="sidebar-brand"><p class="text-center">Men&Ugrave;</p></li>
	<li><a href="home.php"><span class="glyphicon glyphicon-align-justify">&nbsp</span>Home</a></li>
	<li><a href="#"><span class="glyphicon glyphicon-certificate">&nbsp</span>Funzioni</a></li>
	<li><a href="calcolo.php"><span class="glyphicon glyphicon-briefcase">&nbsp</span>Calcolo</a></li>
    <li><a href="esporta.php"><span class="glyphicon glyphicon-hdd">&nbsp</span>Esporta Abbattimenti</a></li>
	<li><a href="download.php"><span class="glyphicon glyphicon-download-alt">&nbsp</span>Download</a></li>
	<li><a href="change_pswd.php"><span class="glyphicon glyphicon-transfer">&nbsp</span>Cambio Password</a></li>
	<li><a href="#"><span class="glyphicon glyphicon-wrench">&nbsp</span>Configurazione</a></li>
	<li><a href="#"><span class="glyphicon glyphicon-align-left">&nbsp</span>Aziende Sanitarie</a></li>
	<li><a href="presidi.php"><span class="glyphicon glyphicon-align-left">&nbsp</span>Presidi Ospedalieri</a></li>
	<li><a href="unitaoperativa.php"><span class="glyphicon glyphicon-align-left">&nbsp</span>Unit&agrave; Operative</a></li>
	<li><a href="user.php"><span class="glyphicon glyphicon-user">&nbsp</span>Utenti</a></li>
	<li><a href="chiudi.php"><span class="glyphicon glyphicon-off">&nbsp</span>Esci</a></li>
	
<?php 
}

elseif($_ruolo=="U") 
{?>
    <li class="sidebar-brand"><p class="text-center">Men&Ugrave;</p></li>
	<li><a href="home.php"><span class="glyphicon glyphicon-align-justify">&nbsp</span>Home</a></li>
	<li><a href="#"><span class="glyphicon glyphicon-certificate">&nbsp</span>Funzioni</a></li>
	<li><a href="calcolo.php"><span class="glyphicon glyphicon-briefcase">&nbsp</span>Calcolo</a></li>
    <li><a href="esporta.php"><span class="glyphicon glyphicon-hdd">&nbsp</span>Esporta Abbattimenti</a></li>
	<li><a href="download.php"><span class="glyphicon glyphicon-download-alt">&nbsp</span>Download</a></li>
	<li><a href="change_pswd.php"><span class="glyphicon glyphicon-transfer">&nbsp</span>Cambio Password</a></li>
	<li><a href="#"><span class="glyphicon glyphicon-wrench">&nbsp</span>Configurazione</a></li>
	<li><a href="#"><span class="glyphicon glyphicon-align-left">&nbsp</span>Aziende Sanitarie</a></li>
	<li><a href="#"><span class="glyphicon glyphicon-align-left">&nbsp</span>Presidi Ospedalieri</a></li>
	<li><a href="unitaoperativa.php"><span class="glyphicon glyphicon-align-left">&nbsp</span>Unit&agrave; Operative</a></li>
	<li><a href="#"><span class="glyphicon glyphicon-user">&nbsp</span>Utenti</a></li>
	<li><a href="chiudi.php"><span class="glyphicon glyphicon-off">&nbsp</span>Esci</a></li>
<?php 
}
?>

</ul>