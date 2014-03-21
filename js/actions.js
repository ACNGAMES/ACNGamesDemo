//function esta funcion se encarga de hacer todos los load ciclicos
 function reloadStructs(){
 		//Aca recarago los creditos
    		if(act!=null){
    			reloadCredit();
    			
    		}
 };

//Esta funcion se encarga de refrescar los creditos cada 30 segundos
setInterval(reloadStructs,30000);