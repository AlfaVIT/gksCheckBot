<?php
	$errorFlag = false;
	$loginErrorClass = '';
	$passwordErrorClass = '';
	$errorClass = 'border-danger';
	if ( !empty($data['errors']['login']) ) {
		$errorFlag = true;
		$loginErrorClass = $errorClass;
	}
	if ( !empty($data['errors']['password']) ) {
		$errorFlag = true;
		$passwordErrorClass = $errorClass;
	}
	if ( !empty($data['errors']['login_error']) ) {
		$errorFlag = true;
	}
?>

<div class="container">
	<div class="row justify-content-md-center">
		<div class="col col-lg-4">
		
			<form class="loginform" method="post">
				<input class="form-control m-1 <?= $loginErrorClass ?>" type="text" name="login" placeholder="login" value="<?= $_POST['login']?>">
				<div class="loginform-password">
					<a class="btn btn-link loginform-password-showbtn"><i class="far fa-eye-slash"></i></a>
					<input class="form-control m-1 loginform-password-input <?= $passwordErrorClass ?>" type="password" name="password" placeholder="password" value="<?= $_POST['password'] ?>">
				</div>
				<button class="btn btn-primary m-1" type="submit">Войти</button>
				<label class="form-check-label">
				<?php
					$rememberCheck = ($_POST['remember']==true) ? "checked" : "";
				?>
					<input class="form-check-input" type="checkbox" <?= $rememberCheck?> name="remember" value="true">
					- запомнить меня на этом устройстве
				</label>
			</form>

			<?php
				if( $errorFlag ) {
					echo "<div class='alert alert-danger' role='alert'>";
					foreach ($data['errors'] as $error) {
						echo "<div>".$error."</div>";
					}
					echo "</div>";
				}
			?>


		</div>
	</div>
</div>


