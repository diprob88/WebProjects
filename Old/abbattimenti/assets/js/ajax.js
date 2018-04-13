function nascondiradio()
{
    var giorni=$("#giorni_app").val();
    if(giorni>1)
    {
        $( "#radioro01" ).toggle(false);
        $( "#radiods" ).toggle(false);
    }
    else
    {
        $( "#radioro01" ).toggle();
        $( "#radiods" ).toggle();
    }
}




function resetta()
{
    //reset primo campo
    $("#operativa").val("");
    $("#numero_cartella").val(0);
    $("#giorni_app").val(1);
    $("#giorni_non_app").val(0);
    $("#punteggio").val(0);
    $("#unita_drg").val("");
    //reset secondo campo
    $("#ro1").val(0);
    $("#ro01").val(0);
    $("#dh").val(0);
    $("#ds").val(0);
    $("#descrizione").val("");
    //reset terzo campo
    $("#rimborso").val(0);
    $("#abbattimento").val(0);
    $("#punteggio_abbattimento").val(0);
}





//serve per cambiare i valori in abse al drg
function showUser(cambia) 
{
    if (cambia == "") {
        document.getElementById("cambia_div").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) 
        {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else
         {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("cambia_div").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","./assets/php/elaborazioni/elabora_drg.php?drg="+cambia,true);
        xmlhttp.send();
    }
}



//viene richiamata nelle funzioni abbatti, visualizza i risultati dei calcoli
function visualizza_abbattimento(cambia,punteggio_abbattimento,abbattimento,rimborso) 
{
    if (cambia == "") {
        document.getElementById("dati_abbattimento").innerHTML = "";
        return;
    } else 
	{ 
        if (window.XMLHttpRequest) 
        {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else
         {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
		 {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
			{
                document.getElementById("dati_abbattimento").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","./assets/php/elaborazioni/elabora_calcolo.php?punteggio="+punteggio_abbattimento+"&abb="+abbattimento+"&rimb="+rimborso,true);
        xmlhttp.send();
    }
}



function aggiorna_tabella() 
{ 
	var anno=$("#anno_calcolo").val();
	
   $("#calcolo_effettuati").load("./assets/php/elaborazioni/elabora_tabella.php?anno="+anno);
    
}

function nascondicheck()
{
	var check=$('#checkbox').is(':checked');
	if(check==false)
	{
		$('#radior1').show();
		$('#radioro01').show();
	}
	else
	{
		$('#radior1').hide();
		$('#radioro01').hide();
	}
}




// funziona che richiama il calcolo
function calcola(cambia) 
{
//cambia indica se è r0>1, r01,dh o ds
var prova=cambia;

//preleva e controlla i valori del form
var giorni_app=$("#giorni_app").val();
if(giorni_app<1)
{
    giorni_app=1
}
else if(giorni_app>365)
{
    giorni_app=365;
}
var giorni_non_app=$("#giorni_non_app").val();
if(giorni_non_app<0)
{
    giorni_app=0;
}
else if(giorni_non_app>365)
{
    giorni_non_app=365;
}
var punteggio=$("#punteggio").val();
if(punteggio<0)
{
    punteggio=0;
}
else if(punteggio>100)
{
    punteggio=100;
}

//imposta la tariffa in base ai valori del drg
var valore="";
var check=$('#checkbox').is(':checked');
if(check==false)
{
	
if(cambia=="ro>1")
{
    valore=$("#ro1").val(); 
    abbatti1(cambia,valore,punteggio,giorni_app,giorni_non_app);

}
else if(cambia=="ro0-1")
{
    valore=$("#ro01").val();   
    abbatti2(cambia,valore,punteggio,giorni_app,giorni_non_app);
}
else if(cambia=="dh0-1")
{
    valore=$("#dh").val(); 
		var tipo=$("#tipo").val();
		if(tipo=='M')
		{
			abbattimedico(cambia,valore,punteggio,giorni_app,giorni_non_app);
		}
		else
		{
			abbatti1(cambia,valore,punteggio,giorni_app,giorni_non_app);
		}
}
else if(cambia=="ds")
{
    valore=$("#ds").val();
    abbatti2(cambia,valore,punteggio,giorni_app,giorni_non_app);
}

}
else
{
	
	valore=$("#ds").val();
    abbatti2(cambia,valore,punteggio,giorni_app,giorni_non_app);
}

}



//calcolo per ro>1 e dh
function abbatti1(cambia,tariffa,punteggio,giorni_app,giorni_non_app)
{
//abbattimento  ro>1 
// nessuna giornata non appropriata

    var percentuale=70/100;
    if(punteggio>30)
        percentuale=(100-punteggio)/100

    var punteggio_abbattimento=percentuale*100;

    if(giorni_non_app<=0)
    {
        var abbattimento=tariffa*percentuale;
        var rimborso=tariffa-abbattimento;
    }
    else
    {
        /*
        PercAbb.Value = PercPart - punteggio
        Tariffagg = SottomTariffario!rom1 / ggAppropriare
        TotggAppropriati = Tariffagg * ggAppropriati
        TotggNonAppropriati = Tariffagg * ggNonAppropriati
        AbbNonAppropriati = (TotggNonAppropriati * 70) / 100
        RibNonAppropriati = (TotggNonAppropriati * 30) / 100
        TotAbbProp = TotggAppropriati + RibNonAppropriati
        abb = AbbNonAppropriati + (TotAbbProp * PercAbb) / 100
        credito = SottomTariffario!rom1 - abb
        */
        var tariffagiornaliera=tariffa/giorni_app;
        var giorni_da_app=giorni_app-giorni_non_app;
        var tot_giorni_da_appropriare=tariffagiornaliera*giorni_da_app;
        var tot_giorni_non_app=tariffagiornaliera*giorni_non_app;
        var AbbNonAppropriati = (tot_giorni_non_app * 70) / 100;
        var RibNonAppropriati = (tot_giorni_non_app * 30) / 100;
        var TotAbbProp = tot_giorni_da_appropriare + RibNonAppropriati;
        var abbattimento=AbbNonAppropriati+TotAbbProp*percentuale;
        var rimborso=tariffa-abbattimento;

    }


    visualizza_abbattimento(cambia,punteggio_abbattimento,abbattimento,rimborso);
}





//calcolo per ro01 e ds

function abbatti2(cambia,tariffa,punteggio,giorni_app,giorni_non_app)
{
//abbattimento  ro>1 
// nessuna giornata non appropriata

    var percentuale=70/100;
    if(punteggio>30)
        percentuale=(100-punteggio)/100

    
    var punteggio_abbattimento=percentuale*100;
    var abbattimento=tariffa*percentuale;
    var rimborso=tariffa-abbattimento;
    
   
    visualizza_abbattimento(cambia,punteggio_abbattimento,abbattimento,rimborso);
}


function abbattimedico(cambia,tariffa,punteggio,giorni_app,giorni_non_app)
{
//abbattimento  ro>1 
// nessuna giornata non appropriata

    var percentuale=70/100;
    if(punteggio>30)
        percentuale=(100-punteggio)/100

    var punteggio_abbattimento=percentuale*100;

    if(giorni_non_app<=0)
    {
        var abbattimento=tariffa*percentuale;
        var rimborso=tariffa-abbattimento;
    }
    else
    {
        /*
        TariffaM = SottomTariffario!dh1 * ggAppropriare
		TotggAppropriati = SottomTariffario!dh1 * ggAppropriati
		TotggNonAppropriati = SottomTariffario!dh1 * ggNonAppropriati
		AbbNonAppropriati = (TotggNonAppropriati * 70) / 100
		RibNonAppropriati = (TotggNonAppropriati * 30) / 100
		TotAbbProp = TotggAppropriati + RibNonAppropriati
		abb = AbbNonAppropriati + (TotAbbProp * PercAbb) / 100
        */
		var TariffaM=tariffa*giorni_app;
		var giorni_da_app=giorni_app-giorni_non_app;
		var TotggAppropriati = tariffa*giorni_da_app;
		var TotggNonAppropriati=tariffa*giorni_non_app;
		var AbbNonAppropriati = (TotggNonAppropriati * 70)/100;
		var RibNonAppropriati = (TotggNonAppropriati * 30)/100;
		var TotAbbProp = TotggAppropriati + RibNonAppropriati;
        var abbattimento = AbbNonAppropriati+TotAbbProp*percentuale;
        var rimborso=TariffaM-abbattimento;
		

    }


    visualizza_abbattimento(cambia,punteggio_abbattimento,abbattimento,rimborso);
}




function inserisci_dati()
{
	
	var data_calcolo=$("#data_calcolo").val();
	var anno_calcolo=$("#anno_calcolo").val();
	var unita_operativa=$("#operativa").val();
	if(unita_operativa=="")
	{
		alert("Selezionare Unita Operativa");
		return;
	}
	var numero_cartella=$("#numero_cartella").val();
	var giorni_app=$("#giorni_app").val();
	var giorni_non_app=$("#giorni_non_app").val();
	var punteggio_ottenuto=$("#punteggio").val();
	var drg=$("#unita_drg").val();
	if(drg=="")
	{
		alert("Selezionare DRG");
		return;
	}
	var descrizione=$("#descrizione").val();
	var selezione=$('input[name="selezione_calcolo"]:checked').val();
	if(selezione=="")
	{
		alert("Selezionare un valore del Drg");
		return;
	}
	var valore="";
	if(selezione=="ro>1")
	{
    	valore=$("#ro1").val(); 
	}
	else if(selezione=="ro0-1")
	{
    	valore=$("#ro01").val();   
	}
	else if(selezione=="dh0-1")
	{
    	valore=$("#dh").val(); 
	}
	else if(selezione=="ds")
	{
    	valore=$("#ds").val();
	}
	var rimborso=$("#rimborso").val();
	var abbattimento=$("#abbattimento").val();
	var punteggio_abbattimento=$("#punteggio_abbattimento").val();
	
	
	var riempi="";
	riempi+="Data: "+data_calcolo;
	riempi+="\nAnno: "+anno_calcolo;
	riempi+="\nUnita Operativa: "+unita_operativa;
	riempi+="\nNumero cartella: "+numero_cartella;
	riempi+="\nGiorni Approrpriati: "+giorni_app;
	riempi+="\nGiorni non Approrpriati: "+giorni_non_app;
	riempi+="\nPunteggio Ottenuto: "+punteggio_ottenuto;
	riempi+="\nDRG: "+drg;
	riempi+="\nDescrizione: "+descrizione;
	riempi+="\nSelezione: "+selezione;
	riempi+="\nValore: "+valore;
	riempi+="\nRimborso: "+rimborso;
	riempi+="\nAbbattimento: "+abbattimento;
	riempi+="\nPunteggio Abbattimento: "+punteggio_abbattimento;
	
	var domanda = confirm("Verranno inseriti i seguenti Dati\n"+riempi);
	if (domanda === true) 
	{
  		$.post("./assets/php/elaborazioni/inserisci_calcolo_db.php",
    {
        data: data_calcolo,
		anno: anno_calcolo,
		unita: unita_operativa,
		numero_cartella: numero_cartella,
		giorni_app: giorni_app,
		giorni_non_app: giorni_non_app,
		punteggio_ottenuto: punteggio_ottenuto,
		drg: drg,
		descrizione: descrizione,
		selezione: selezione,
		valore: valore,
		rimborso: rimborso,
		abbattimento: abbattimento,
		punteggio_abbattimento: punteggio_abbattimento
    },
    function(x)
	{
        alert(x);
		aggiorna_tabella();
    });
	}else
	{
  		alert("Operazione Annullata");
	}
	
	
	
}





