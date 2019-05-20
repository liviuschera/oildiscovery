<?php require APPROOT . '/views/includes/header.php'; ?>
<?php require APPROOT . '/views/includes/navbar.php'; ?>

<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v3.0&appId=<?php echo FB_APP_ID; ?>&autoLogAppEvents=1">
   (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s);
      js.id = id;
      js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
      fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
<!-- ~~~ BLOG POST SECTION  start~~~ -->
<div class="blog-post">
   <main class="blog-post__main">
      <!-- ~~~ BLOG POST CARD  start -->
      <figure class="card card--full-width-blogpost">
         <?php flash('post_message'); ?>
         <div class="card__content card__content--for-3col-blog u-mb-medium">
            <div class="card__img-wrapper card__img-wrapper--full-width-blogpost">
               <a href="#">
                  <img src="<?php echo URLROOT .
                                 BLOG_IMG_DIR .
                                 $data['post']->imgName; ?>" alt="" class="card__img card__img--full-width-blogpost" />
               </a>
            </div>

            <a href="#" class="card__heading-link card__heading-link--full-width-blogpost">
               <h6 class="h-6 u-txt-uppercase u-color-primary u-mt-medium">
                  <?php echo $data['post']->title; ?>
               </h6>
            </a>

         </div>

         <?php echo $data['post']->content; ?>

      </figure>
      <!-- ~~~ BLOG POST CARD end -->
      <!-- <?php echo $data['post']->content; ?>
        -->

      <!-- ~~~ Display Edit and Delete buttons START -->

      <?php if (
         isset($_SESSION['login_user_id']) &&
         $data['post']->userID === $_SESSION['login_user_id']
      ) : ?>
         <div class="buttons-wrapper">
            <a href="<?php echo URLROOT; ?>/pages/edit/<?php echo $data['post']
                                                            ->postID; ?>" class="button button--success">Edit</a>

            <form action="<?php echo URLROOT; ?>/posts/delete/<?php echo $data['post']->postID; ?>" method="POST">
               <input type="submit" value="Delete" class="button button--danger">
            </form>
         </div>

      <?php endif; ?>

      <!-- ~~~ Display Edit and Delete buttons END -->


      <!-- Your share button code start-->

      <div class="fb-share-button" data-href="<?php echo URLROOT; ?>/posts/show/<?php echo $data['post']->postID; ?>/" data-layout="button_count" data-size="large">
         <a target="_blank" href="<?php echo URLROOT; ?>/posts/show/<?php echo $data['post']->postID; ?>" class="fb-xfbml-parse-ignore">Share
         </a>
      </div>
      <!-- Your share button code end-->

      <!-- <?php var_dump($_SESSION['fb_user_name']); ?>
        <?php var_dump($_SESSION['fb_user_email']); ?>
        -->


      <?php require APPROOT . '/views/includes/footer.php';
