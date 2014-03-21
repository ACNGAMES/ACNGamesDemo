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
	$('#pagina_central').html($.View("views/eventsCat.ejs"));
	
};


function getNext3Events(){
		$.ajax({
            url: 'serverCall/next3EventsF.php',
            dataType: "json",
            success: function(data) {
            	if(data.status=="ok"){
					$('#next3Events').html($.View("views/next3Events.ejs",data.events));					            		
            	}else{
            		alert('ocurrio un error');
            	}
            },error: function(error){
            	console.log(error);
            } 
	});
	
	
};