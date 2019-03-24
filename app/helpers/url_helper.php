<?php
// Page redirect
function redirectTo($page)
{
    header('location: ' . URLROOT . '/' . $page);
}

function getCurrentURL()
{
    $url = $_SERVER['REQUEST_URI'];
    $current_url = str_replace('/oildiscovery', '', $url);
    return $current_url === '/' ? '/pages': $current_url;
}
