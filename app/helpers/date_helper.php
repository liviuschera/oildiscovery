<?php
function formatDate($date, $format = 'd M, Y')
{
    $fdate = new DateTime($date);
    return $fdate->format($format);
}
?>
