<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo SITENAME; ?>
    </title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="description" content="<?php echo SITENAME; ?>" />
    <meta name="keywords" content="oil, michelle" />
    <meta name="author" content="Liviu Schera" />


    <!-- Open Graph tags to customize link previews -->
    <?php
   $fb_graph_url = '';
   $fb_graph_title = '';
   $fb_graph_description = '';
   $fb_graph_image = '';
   
   if (isset($data['post'])) {
       $fb_graph_url = trim(URLROOT . "/posts/show/" . $data['post']->postID);
       $fb_graph_title = $data['post']->title;
       $fb_graph_description = strip_tags(substr($data['post']->content, 0, 280));
       $fb_graph_image = URLROOT . BLOG_IMG_DIR . $data['post']->imgName;
   }
   ?>
    <meta property="og:url" content="<?php echo $fb_graph_url; ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:title"
        content="<?php echo $fb_graph_title; ?>" />
    <meta property="og:description"
        content="<?php echo $fb_graph_description; ?>" />
    <meta property="og:image"
        content="<?php echo $fb_graph_image; ?>" />

    <link rel="stylesheet"
        href="<?php echo URLROOT; ?>/css/styles.css" />
</head>


<body>