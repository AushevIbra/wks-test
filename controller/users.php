<?php

class Controller_users extends Controller {

	function __construct() {
		if ($_SESSION['role'] != 1) {
			header("Location: /profile");
			exit();
		}
	}

	public function search() {
		$user_model = Controller::loadModel("user");
		$page = isset($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
		$limit = isset($_REQUEST['limit']) ? (int) $_REQUEST['limit'] : 10;
		$search_field = isset($_REQUEST['field']) ? $_REQUEST['field'] : '';
		$search_text = isset($_REQUEST['text']) ? $_REQUEST['text'] : '';
		$user_model->setFilter($search_field, $search_text);
		$pagin = new Paginator($user_model->countUsers(), $limit);
		$pagin->selectPage($page);
		$users = $user_model->selectFilteredUsers($limit, $pagin->getOffset());

		$data['error'] = $this->error;
		$data['users'] = $users;
		$data['delete'] = 'users/delete?id=';
		$data['pagin'] = $pagin->getData();
		$data['pages'] = $pagin->getPages();
		$data['search_field'] = $search_field;
		$data['search_text'] = $search_text;

		$users_table_view = new View("users_table");

		$users_table_view->setData($data);

		$users_table_view->display();
	}

	public function delete() {
		$user_model = Controller::loadModel("user");

		$data['result_text'] = "Fail to delete user.";

		if (isset($_REQUEST["id"])) {
			if ($_REQUEST["id"] == $_SESSION['id']) {
				$data['result_text'] = 'Can\'t to delete himself';
				$result_view = new View("fail");
			} else {
				if ($user_model->deleteUser($_REQUEST["id"])) {
					$result_view = new View("success");
					$data['result_text'] = "User was succesfully deleted.";
				} else {
					$result_view = new View("fail");
				}
			}
		} else {
			$result_view = new View("fail");
			$data['result_text'] = "Can't delete this user.";
		}

		$header_view = new View("header");
		$footer_view = new View("footer");

		$header['title'] = "Profile info";
		$data['link_url'] = "/users";
		$data['link_text'] = "View users";

		$header_view->setData($header);
		$result_view->setData($data);

		$header_view->display();
		$result_view->display();
		$footer_view->display();
	}

	public function index() {
		
		if (isset($_REQUEST['limit'])) {
			$limit = $_REQUEST['limit'];
		}

		$header['title'] = "Profile info";
		$users['title'] = "View users";

		$header_view = new View("header");
		$users_view = new View("users");
		$footer_view = new View("footer");

		$header_view->setData($header);
		$users_view->setData($users);

		$header_view->display();
		$users_view->display();
		$this->search();
		$footer_view->display();
	}

	public function import()
	{
		include  $_SERVER['DOCUMENT_ROOT'] ."/lib/Csv.php";
		$user_model = Controller::loadModel("user");
		if($_FILES['file']) {
			$file = $_FILES["file"];
			$name = basename($file["name"]);
			$uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/files/" . $name;
			move_uploaded_file($file['tmp_name'], $uploadDir);
			
			$csv = new Csv($uploadDir);
			$count = 0;
			$ignoreUser = [];
			foreach($csv->returnUsers() as $user) {
				if($user_model->addNewUser($user) == true) {
					$count++;
				} else {
					$ignoreUser[] = $user;
				}
			}

			echo "Добавлено пользователей: <span style='color: green'>". $count . "</span> <br>";
			if(count($ignoreUser) > 0){
				echo "Проигнарированое пользователей: <span style='color: red'>". count($ignoreUser) . "</span> <br>";
				echo "<pre>";
					print_r($ignoreUser);
				echo "</pre>";
			}
			


		}
	}

	public function user()
	{
		$user_model = Controller::loadModel("user");
		$user = $user_model->getRandomUser();
		echo json_encode(['user' => $user[0]]);
	}


}
