<?php

ob_start();

session_start();

defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR); //DEFINIR EL SERPARADOR DE SLASH PARA MAC Y WINDOWS

defined("TEMPLATE_FRONT") ? null : define("TEMPLATE_FRONT", __DIR__.DS."templates/front");
defined("TEMPLATE_BACK") ? null : define("TEMPLATE_BACK", __DIR__.DS."templates/back");

// defined("DB_HOST") ? null : define("DB_HOST", "sql125.main-hosting.eu");
// defined("DB_USER") ? null : define("DB_USER", "u153131945_ecom");
// defined("DB_PASS") ? null : define("DB_PASS","4JNAthx0rW9y");
// defined("DB_NAME") ? null : define("DB_NAME", "u153131945_ecom");

defined("DB_HOST") ? null : define("DB_HOST", "localhost");
defined("DB_USER") ? null : define("DB_USER", "root");
defined("DB_PASS") ? null : define("DB_PASS","");
defined("DB_NAME") ? null : define("DB_NAME", "u153131945_ecom");

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

require_once("functions.php");





?>