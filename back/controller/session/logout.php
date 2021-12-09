<?php
require("../../config/config.php");
require("../../config/arrays.php");
require("../../config/functions/validator.php");
require("../../config/functions/sql.php");

$_SESSION = array();

return header('Location: ../../../index.php?section=home');