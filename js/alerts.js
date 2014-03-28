function viewAlerts(){
	$('#pagina_central').html($.View("views/alertView.ejs"));	
};

function getNewAlerts(){
	$.ajax({
            url: 'serverCall/getAlertHeaderF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token},
            success: function(data) {
            	if(data.status=="ok"){
					// aca tengo que llaamr al view q	uw dibuje las alertas
					$('#alertas').html($.View("views/alertHeader.ejs",data.alerts));
					            		
            	}else if(data.status=="exp"){
            		expire();
            	}else{
            		alert('ocurrio un error');
            	}
            },error: function(error){
            	console.log(error);
            } 

	});
	
};