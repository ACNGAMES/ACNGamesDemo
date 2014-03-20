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
