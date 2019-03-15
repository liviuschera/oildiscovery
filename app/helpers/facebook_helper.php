<?php

function initFacebook()
{
    if (!session_id()) {
        session_start();
    }
    require_once VENDORROOT . 'autoload.php';
    $fb = new Facebook\Facebook([
        'app_id' => FB_APP_ID,
        'app_secret' => FB_APP_SECRET,
        'default_graph_version' => FB_APP_GRAPH_VERSION
    ]);
    return $fb;
}
