<?php

require("../../config/config.php");
require("../../config/arrays.php");
require("../../config/functions/validator.php");
require("../../config/functions/sql.php");
require("../../config/functions/session.php");

session(array(
    "status" => true
));

return header('Location: ../../index.php?section=register');