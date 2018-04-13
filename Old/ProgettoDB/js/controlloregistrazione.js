

function controllo() 
{
    var errors="";
	var password=document.getElementById("password");
	var confermapwd=document.getElementById("confermapwd");
	var email=document.getElementById("email");
	var conferma_email=document.getElementById("conferma_email");
	   
	   
	   
       
       if (password != confermapwd)
           errors += "Le password non corrispondono.\n";
        if (email != conferma_email)
           errors += "Le Mail inserite non corrispondono.\n";
           
        
        if (errors == ""){
            document.forms["registra"].submit();
        }else{
            alert (errors);
        }
  }


