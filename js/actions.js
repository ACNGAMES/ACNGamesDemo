//function esta funcion se encarga de hacer todos los load ciclicos
 function reloadStructs(){
 		//Aca recarago los creditos
    		if(act!=null){
    			reloadCredit();
    			getUnreadMsg();
    			getNewAlerts();
    		}
 };

//Esta funcion se encarga de refrescar los creditos cada 60 segundos
setInterval(reloadStructs,60000);