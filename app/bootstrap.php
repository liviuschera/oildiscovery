<?php

// Load config
require_once "config/config.php";

// Load helpers
require_once "helpers/date_helper.php";
require_once "helpers/display_table_helper.php";
require_once "helpers/pagination_helper.php";
require_once "helpers/session_helper.php";
require_once "helpers/url_helper.php";

// Autoload core libraries
spl_autoload_register(function ($className) {
    require_once "libraries/{$className}.php";
});
?>
