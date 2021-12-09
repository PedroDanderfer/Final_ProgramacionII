<?php
session_start();

// mostrar todos los errores
error_reporting(E_ALL);
ini_set("display_errors", true);

//Nombre del sitio
define("Site_Name", "Venturi");

define("DB_HOST", "localhost");
define("DB_USUARIO", "root");
define("DB_PASSWORD", "");
define("DB_NAME", "ecommerce");

$cnx = @mysqli_connect(DB_HOST, DB_USUARIO, DB_PASSWORD,DB_NAME);

mysqli_set_charset($cnx, "UTF8");

date_default_timezone_set("America/Argentina/Buenos_Aires");