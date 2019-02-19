<?php
// DB Params
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'd');
define('DB_NAME', 'oildiscovery');

// App root
define('APPROOT', dirname(dirname(__FILE__)));

// URL root
define('URLROOT', 'http://localhost/oildiscovery/');
// define('URLROOT', rtrim('http://localhost/oildiscovery/', '/'));

// Website Name

define('SITENAME', 'Oil Discovery with Michelle');
define('ADMIN_DASHBOARD_NAME', 'Oil Discovery Admin Dashboard');

// Pagination
define('ROWS_PER_PAGE_USERS', 2);
define('ROWS_PER_PAGE_POSTS', 6);

// Path for uploaded images
$target_dir = URLROOT . '/images/blog/';
define('IMG_DIR', 'images/blog/');
?>
