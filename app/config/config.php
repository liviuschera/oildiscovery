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

// Site root
define('PUBLICROOT', $_SERVER['DOCUMENT_ROOT'] . '/oildiscovery/public/');
// Vendor dir
define('VENDORROOT', $_SERVER['DOCUMENT_ROOT'] . '/oildiscovery/vendor/');

// Path for uploaded images
define('BLOG_IMG_DIR', 'images/blog/');
define('USER_IMG_DIR', 'images/users/');
