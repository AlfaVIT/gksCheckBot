<?php
	namespace controllers;
	use base\baseController;

	class controllerPublicAccount extends baseController {

		public function actionIndex() {	
			if ( $this->_user->isGuest() ) {
				$modelLogin = $this->loadModel('modelLogin');
				if ( !$modelLogin->cookieLogin() ) {
					header("Location: /account?action=login");
				}
			}
			$this->_view->setTitle('Личный кабинет');
			$this->_view->render();
		}

		public function actionLogout() {
			$this->_db->exec("UPDATE user SET online_marker=0, login_cookie='' WHERE id='".$_SESSION['user']['id']."'");
			$this->_user->logout();
			header("Location: /account?action=login");
		}

		public function actionLogin() {	
			if ( $_SERVER['REQUEST_METHOD']=='POST' ) {
				$modelLogin = $this->loadModel('modelLogin');

				$login = $this->trim($_POST['login']);
				$password = $this->trim($_POST['password']);
				$remember = $_POST['remember']==true ? true : false;

				$data = [
					'login'=>$login, 
					'password'=>$password
				];

				$rules = [
					'login' => ['required'],
					'password' => ['required', 'min::5']
				];				

				if ( $this->_validator->validate($data, $rules)!==false ) {
					$login_res = $modelLogin->login($login, $password, $remember);
					if ( !empty($login_res['login_error']) ) {
						$view_data['errors']['login_error'] = $login_res['login_error'];
					} else {
						header("Location: /account");
					}
				} else {
					$view_data['errors'] = $this->_validator->_errors;
				}
				
			}
			
			$this->_view->setTitle('Вход');
			$this->_view->render($view_data);

			
		}



	}
?>