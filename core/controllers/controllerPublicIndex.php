<?php
	namespace controllers;
	use base\baseController;

	class controllerPublicIndex extends baseController {

		public function actionIndex() {	
			if ( $this->_user->isGuest() ) {
				header("Location: /account?action=login");
			}
		}



	}
?>