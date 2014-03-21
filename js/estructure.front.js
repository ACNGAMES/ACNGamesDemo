function loadPageEstruct(){
	getCoins();
	$('#container').html($.View("views/page.ejs",act));
	getCategories();
	getNext3Events();
};


