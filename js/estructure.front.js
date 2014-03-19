function loadPageEstruct(value){
	$('#container').html($.View("views/page.ejs",value));
	getCategories();
};
