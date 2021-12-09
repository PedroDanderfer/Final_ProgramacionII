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
	<link rel="stylesheet" href="./site/css/index.css">
	<link rel="stylesheet" href="./site/css/header/header.css">
	<link rel="stylesheet" href="./site/css/header/navMenu.css">
	<link rel="stylesheet" href="./site/css/header/subMenuProducts.css">
	<link rel="stylesheet" href="./site/css/header/subMenuUser.css">
	<link rel="stylesheet" href="./site/css/views/register.css">
	<link rel="stylesheet" href="./site/css/views/login.css">
	<link rel="stylesheet" href="./site/css/components/input.css">
</head>
<body>
	<?php
		require_once("./site/components/header/header.php");
	?>
	<main>
		<?php 
		if (in_array($section, $views))
			require_once("./site/views/$section.php");
		else
			require_once("./site/views/error.php");
		?>
	</main>
</body>
<script src="./site/js/display/menu.js"></script>
<script src="./site/js/display/submenus.js"></script>
<script src="./site/js/index.js"></script>
</html>