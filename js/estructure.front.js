function loadPageEstruct(){
	getCoins();
	$('#container').html($.View("views/page.ejs",act));
	getCategories();
	getUnreadMsg();
	getNext3Events();
	getResults();
};


