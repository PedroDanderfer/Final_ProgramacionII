<?php
require("./back/config/config.php");
require("./back/config/arrays.php");
require("./back/config/functions/sql.php");
require("./back/config/functions/session.php");

$section = $_GET["section"] ?? "home";
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title><?= Site_Name; ?></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="./site/css/index.css">
	<link rel="stylesheet" href="./site/css/header/header.css">
	<link rel="stylesheet" href="./site/css/header/navMenu.css">
	<link rel="stylesheet" href="./site/css/header/subMenuProducts.css">
	<link rel="stylesheet" href="./site/css/header/subMenuUser.css">
	<link rel="stylesheet" href="./site/css/views/register.css">
	<link rel="stylesheet" href="./site/css/views/login.css">
	<link rel="stylesheet" href="./site/css/views/panel/panel.css">
	<link rel="stylesheet" href="./site/css/views/panel/categories.css">
	<link rel="stylesheet" href="./site/css/views/panel/users.css">
	<link rel="stylesheet" href="./site/css/views/panel/products.css">
	<link rel="stylesheet" href="./site/css/views/panel/productEdit.css">
	<link rel="stylesheet" href="./site/css/views/panel/productCreate.css">
	<link rel="stylesheet" href="./site/css/components/input.css">
	<link rel="stylesheet" href="./site/css/components/editPhotosInput.css">
</head>
<body>
	<?php
		require_once("./site/components/header/header.php");
	?>
	<main>
		<?php 
		if (in_array($section, $views) && $section !== 'panel'){
			require_once("./site/views/$section.php");
		}else if($section === 'panel'){
			require_once("./site/views/panel/index.php");
		}else{
			require_once("./site/views/error.php");
		}
		?>
	</main>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="./site/js/display/menu.js"></script>
<script src="./site/js/display/submenus.js"></script>
<script src="./site/js/index.js"></script>
</html>