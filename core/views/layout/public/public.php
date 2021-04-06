<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<?php
		//SEO
		$keywords = "ключевые, слова";
		$this->setSeo('keywords', $keywords);
		$description = "Описание сайта";
		$this->setSeo('description', $description);

		// JQuery
		$this->setJs("https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js");
		// bootStrup
		$this->setJs("https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js");
		$this->setCss("https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css");
		// fontAwsome
		$this->setJs("assets/fontawesome-free-5.15.2-web/js/all.min.js");
		$this->setCss("assets/fontawesome-free-5.15.2-web/css/all.min.css");

		foreach ( $this->getJs() as $js ) {
			echo "<script src='".$js."' type='text/javascript' charset='UTF-8'></script>\n	";
		}
		foreach ( $this->getCss() as $css ) {
			echo "<link rel='stylesheet' type='text/css' href='".$css."'>\n	";
		}
	?>

	<meta name="keywords" content="<?php echo $this->getSeo('keywords'); ?>">
	<meta name="description" content="<?php echo $this->getSeo('description'); ?>">
	<title><?= $this->_title ?></title>
</head>
<body>
	<?php include $this->_template; ?>
</body>
</html>