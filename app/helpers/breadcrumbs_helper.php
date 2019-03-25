<?php
function breadcrumbs($separator = ' / ', $home = 'Home', $post_title = '')
{
    // This gets the REQUEST_URI (/path/to/file.php), splits the string (using '/') into an array, and then filters out any empty values
    $path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
    //  This one removes 'oildiscovery' from the path in development environment
    $path = array_diff($path, ['oildiscovery']);

    // This the base URL
    $base = URLROOT;
    

    // Initialize a temporary array with our breadcrumbs. (starting with our home page, which will be the base URL)
    $breadcrumbs = array("<a class='breadcrumbs__link' href=\"$base\">$home</a>");

    // Find out the index for the last value in our path array
    $pathkeys = array_keys($path);
    $last = end($pathkeys);
    // Build the rest of the breadcrumbs
    foreach ($path as $key => $crumb) {
        // Our "title" is the text that will be displayed (strip out .php and turn '_' into a space)
        $title = ucwords(str_replace(array('.php', '_'), array('', ' '), $crumb));

        // If we are not on the last index, then display an <a> tag
        if ($key != $last) {
            $breadcrumbs[] = "<a class='breadcrumbs__link' href=\"$base\\$crumb\">$title</a>";
        }
        // Otherwise, just display the title (minus)
        if ($key === $last) {
            //   If the last index is an integer then replace the post id with post title
            if (is_numeric($crumb)) {
                $breadcrumbs[] = $post_title;
            } else {
                $breadcrumbs[] = $title;
            }
        }
    }

    // Build our temporary array (pieces of bread) into one big string :)
    return implode($separator, $breadcrumbs);
}
