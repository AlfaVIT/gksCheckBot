<?php
	namespace controllers;
	use base\baseController;

	class controllerPublicPreset extends baseController {

		public function actionIndex() {	
			$sql = [];
			// $sql[] = "CREATE TABLE IF NOT EXISTS user (
			// 	id				INTEGER PRIMARY KEY, 
			// 	login			TEXT NOT NULL UNIQUE, 
			// 	password		TEXT NOT NULL, 
			// 	first_name		TEXT, 
			// 	last_name		TEXT, 
			// 	email			TEXT, 
			// 	phone			TEXT, 
			// 	role			TEXT DEFAULT 'user', 
			// 	login_cookie	TEXT DEFAULT '', 
			// 	online_marker	INTEGER DEFAULT 0, 
			// 	login_attempts	INTEGER DEFAULT 0, 
			// 	login_block_to	INTEGER DEFAULT 0, 
			// 	last_ip			TEXT
			// )";
			// $sql[] = "INSERT INTO user (login, password, first_name, last_name, email, phone, role) VALUES ('amerinov', '".$this->_db->hash('logovazz')."', 'Алексей', 'Меринов', 'amerinov@mail.ru', '+79103185997', 'superadmin')";

			foreach ($sql as $key => $value) {
				$result = $this->_db->query($value);
				echo '<pre>';
				echo $value;
				echo '<br>';
				var_dump($result);
				echo '</pre><br>';
				
			}

			$sql = "SELECT * FROM user";
			$result = $this->_db->query($sql);
			echo '<pre>';
			var_dump($result);
			echo '</pre>';
			


//			$this->_view->setTitle('Предварительные настройки');
//			$this->_view->render();
		}


	}
?>