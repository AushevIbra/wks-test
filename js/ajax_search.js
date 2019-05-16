function createObject() {
	var request_type;
	var browser = navigator.appName;

	if (browser == "Microsoft Internet Explorer") {
		request_type = new ActiveXObject("Microsoft.XMLHTTP");
	} else {
		request_type = new XMLHttpRequest();
	}
	return request_type;
}

var http = createObject();

function searchByFieldname(page) {
	var search_field = encodeURI(document.getElementById('search_field').value);
	var search_text = encodeURI(document.getElementById('search_text').value);
	var limit = encodeURI(document.getElementById('limit').value);
	var nocache = Math.random();
	http.open('get', '/users/search?field=' + search_field + '&text=' + search_text + '&page=' + page + '&limit=' + limit + '&nocache = ' + nocache);
	http.onreadystatechange = searchResults;
	http.send(null);
}

function searchResults() {
	if (http.readyState == 4) {
		var response = http.responseText;
		document.getElementById('users_list').innerHTML = response;
	}
}

function clearSearch() {
	document.getElementById('search_text').value = '';
	searchByFieldname(1);
}

function getRandomUser() {
	fetch('/users/user')
	.then(function(response) {
		return response.json();
	})
	.then(function(user) {
		document.querySelector(".random-user").value= `${user.user.first_name} ${user.user.last_name} (id=${user.user.id})`;
	})
 
}