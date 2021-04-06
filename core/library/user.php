<?php
	namespace library;

	class user {
		public static function isGuest() {
			if ( empty($_SESSION['user']) ) {
				return true;
			}
			return false;
		}

		public static function userAccess($role) {
			if ( $_SESSION['user']['role'] == $role ) {
				return true;
			}
			return false;
		}
		
		public static function login($data) {
			$_SESSION['user'] = $data;
		}

		public static function logout() {
			setcookie("alfavitLoginCookie", "", time() - 3600);
			session_unset();
			session_destroy();
		}

		public static function getUserIP() {
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			return $ip;
		}

	}
?>