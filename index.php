<?php
require("config/config.php");
require("config/arrays.php");
require("config/functions.php");

$section = $_GET["section"] ?? "home";
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title><?= Site_Name; ?></title>
</head>
<body>
	<?php
		require_once("components/header.php");
	?>
	<main>
		<?php 
		if (in_array($section, $views))
			require_once("views/$section.php");
		else
			require_once("views/error.php");
		?>
	</main>
</body>
</html>