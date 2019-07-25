<?php
// DB Params
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'r');
define('DB_NAME', 'oildisco_db');

// App root
define('APPROOT', dirname(dirname(__FILE__)));

// URL root
define('URLROOT', 'http://localhost/oildiscovery');

// Website Name

define('SITENAME', 'Oil Discovery with Michelle');
define('ADMIN_DASHBOARD_NAME', 'Oil Discovery Admin Dashboard');

// Pagination
define('ROWS_PER_PAGE_USERS', 10);
define('ROWS_PER_PAGE_POSTS', 6);

// Site root
define('PUBLICROOT', $_SERVER['DOCUMENT_ROOT'] . '/oildiscovery/public');
// Vendor dir
define('VENDORROOT', $_SERVER['DOCUMENT_ROOT'] . '/oildiscovery/vendor/');

// Path for uploaded images
define('BLOG_IMG_DIR', '/images/blog/');
define('USER_IMG_DIR', '/images/users/');

// Facebook initialization
define('FB_APP_ID', '548221059031502');
define('FB_APP_SECRET', '78649a9365addd45aa8cf0f7c90efbf6');
define('FB_APP_GRAPH_VERSION', 'v3.2');
define('FB_APP_CALLBACK_URL', 'http://localhost/oildiscovery/users/index.php');
