function getCategories(){
		$.ajax({
            url: 'serverCall/getCategoriesF.php',
            dataType: "json",
            success: function(data) {
            	if(data.status=="ok"){
					$('#categories').html($.View("views/categories.ejs",data.categories));					            		
            	}else{
            		alert('ocurrio un error');
            	}
            },error: function(error){
            	console.log(error);
            } 
	});
	
	
};

function getEventsByCat(id){
	$.ajax({
            url: 'serverCall/getEventsByCatF.php',
            dataType: "json",
            data: {userId:act.user_id, auth_token:act.auth_token, category_id:id},
            success: function(data) {
            	console.log(data);
            	if(data.status=="ok"){
					$('#pagina_central').html($.View("views/eventsCat.ejs", data));					            		
            	}else{
            		alert('ocurrio un error');
            	}
            },error: function(error){
            	console.log(error);
            } 
	});
	
	
};


function getNext3Events(){
		$.ajax({
            url: 'serverCall/next3EventsF.php',
            dataType: "json",
            success: function(data) {
            	if(data.status=="ok"){
					
					$('#next3Events').html($.View("views/next3Events.ejs",data.next_events));					            		
            	}else{
            		alert('ocurrio un error');
            	}
            },error: function(error){
            	console.log(error);
            } 
	});
	
	
};

function getResults(){
		$.ajax({
            url: 'serverCall/getResultsF.php',
            dataType: "json",
            success: function(data) {
            	if(data.status=="ok"){
            		
					$('#myCarousel2').html($.View("views/results.ejs",data.results));					            		
            	}else{
            		alert('ocurrio un error');
            	}
            },error: function(error){
            	console.log(error);
            } 
	});
	
};

function viewResults(){
	
};


function viewNextEvents(){
	
	$.ajax({
            url: 'serverCall/nextEventsF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token},
            
            success: function(data) {
            	
            	if(data.status=="ok"){
					$('#pagina_central').html($.View("views/nextEvents.ejs", data.next_events));
				
				}else if(data.status=="exp"){
            		expire();
            		
            	}else{
            		
					console.log("error");
            	}
            },error: function(error){
            	
            } 

	});
};	

