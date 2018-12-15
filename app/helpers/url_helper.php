<?php
// Page redirect
function redirectTo($page)
{
    header('location: ' . URLROOT . '/' . $page);
}
?>
