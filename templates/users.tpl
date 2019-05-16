<H1><?php echo $title; ?></H1>
<div class="menu"><a href="/login/logout">Logout</a>&nbsp;&nbsp;&nbsp;<a href="/profile">Profile</a></div>
<br/>	


<div class="search_panel">
	<select type="list" id="search_field" >
		<option value="first_name">First name</option>
		<option value="last_name">Last name</option>
		<option value="login">Login</option>
		<option value="email">E-mail</option>
	</select>

	<input type="text" name="search_text" id="search_text" name="search_text" />
	<input type="button" name="run_search" value="search" onclick="javascript:searchByFieldname(1)"/>
	<input type="button" name="clear_search" value="clear" onclick="javascript:clearSearch();"; />
</div>
<div style="margin: 5px;">
	<form action="/users/import" method="POST" enctype="multipart/form-data">
		<input type="file" name="file">
		<button>Отправить</button>
	</form>
</div>

<div style="margin: 5px;">
	<input type="text" class="random-user">
	<button class="get-user" onclick="getRandomUser()">Выбрать</button>
</div>
<br />
<div>
	Display: 
	<select type="list" id="limit" name="limit" onchange="javascript:searchByFieldname(1)">
		<option value=10>10</option>
		<option value=20>20</option>
		<option value=50>50</option>
		<option value=100>100</option>
	</select>
	records
</div>
<script language="javascript" src="/js/ajax_search.js?v=12"></script>
