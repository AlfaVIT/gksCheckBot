<?php
	namespace models;
	use base\baseModel;

	class modelLogin extends baseModel {

		public function userAuth($id, $remember) {
			$last_ip = $this->_user->getUserIP();
			$this->_db->exec("UPDATE user SET online_marker=1, login_attempts=0, login_block_to=0, last_ip='".$last_ip."' WHERE id='".$id."'");
			if ( $remember ) {
				// * ставим куку на 15 суток
				$login_cookie = $this->_db->randomString();
				if ( setcookie("alfavitLoginCookie", $login_cookie, time()+3600*24*15) ) {
					$this->_db->exec("UPDATE user SET login_cookie='".$login_cookie."' WHERE id='".$id."'");
				}
			}
			$sql = "SELECT id, login, first_name, last_name, email, phone, role, last_ip FROM user WHERE id='".$id."'";
			$result = $this->_db->query($sql);
			$this->_user->login($result[0]);
		}

		public function cookieLogin() {
			if ( !empty($_COOKIE['alfavitLoginCookie']) ) {
				$sql = "SELECT id FROM user WHERE login_cookie='".$_COOKIE['alfavitLoginCookie']."'";
				$result = $this->_db->query($sql);
				if ( !empty($result[0]['id']) ) {
					$this->userAuth($result[0]['id'], false);
					return true;
				}
			}
			return false;
		}

		public function login( $login, $password, $remember=false ) { 
			//* приводим логин и пароль в порядок 
			$login = $this->_db->escape($login);
			$password = $this->_db->escape($password);
			$password = $this->_db->hash($password);

			$return = [];

			//* выбираем пользователя по логину и паролю 
			$sql = "SELECT id, login_attempts, login_block_to FROM user WHERE login='$login' AND password='$password'";
			$result = $this->_db->query($sql);

			if ( LOGIN_ATTEMPTS ) {
				if ( !empty($result[0]['id']) ) {
					// * пользователь найдей
					if ( $result[0]['login_attempts']==LOGIN_MAX_ATTEMPTS and $result[0]['login_block_to']>time()*1000 ) {
						$return['login_error'] = LOGIN_ERROR_2;
						$this->_user->logout();
					} else {
						$this->userAuth($result[0]['id'], $remember);
					}
				} else {
					// * пользователь не найден
					$this->_user->logout();
					$sql = "SELECT id, login_attempts FROM user WHERE login='$login'";
					$result = $this->_db->query($sql);
					if ( !empty($result[0]['id']) ) {
						if ( $result[0]['login_attempts']<LOGIN_MAX_ATTEMPTS ) {
							$login_attempts = ++$result[0]['login_attempts'];
							$this->_db->exec("UPDATE user SET login_attempts='".$login_attempts."', login_block_to='".(time()+60*60*24)."' WHERE id='".$result[0]['id']."'");
							$return['login_error'] = LOGIN_ERROR_1;
						} else {
							$return['login_error'] = LOGIN_ERROR_2;
						}
					} else {
						$return['login_error'] = LOGIN_ERROR_1;
					}
				}
			} else {
				if ( !empty($result[0]['id']) ) {
					// * пользователь найдей
					$this->userAuth($result[0]['id'], $remember);
				} else {
					// * пользователь не найден
					$this->_user->logout();
					$return['login_error'] = LOGIN_ERROR_1;
				}
			}
			return $return;
		}

	}
?>