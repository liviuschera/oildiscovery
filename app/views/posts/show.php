<?php require APPROOT . '/views/includes/header.php';?>
<?php require APPROOT . '/views/includes/navbar.php';?>
<?php require APPROOT . '/views/includes/breadcrumbs.php';?>

<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script async defer crossorigin="anonymous"
    src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v3.0&appId=<?php echo FB_APP_ID; ?>&autoLogAppEvents=1">
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
            <?php flash('post_message');?>
            <div class="card__content card__content--for-3col-blog">
                <div class="card__img-wrapper card__img-wrapper--full-width-blogpost">
                    <a href="#">
                        <img src="<?php echo URLROOT .
BLOG_IMG_DIR .
$data['post']->imgName; ?>" alt=""
                            class="card__img card__img--full-width-blogpost" />
                    </a>
                </div>

                <a href="#" class="card__heading-link card__heading-link--full-width-blogpost">
                    <h6 class="h-6 u-txt-uppercase u-color-primary">
                        <?php echo $data['post']->title; ?>
                    </h6>
                </a>
                <div class="card__details-wrapper card__details-wrapper--full-width-blogpost">
                    <span class="card__author">
                        <svg class="card__icon-post">
                            <use
                                href="<?php echo URLROOT; ?>/images/sprite.svg#icon-user">
                            </use>
                        </svg>
                        By:
                        <a class="card__link" href="">
                            <?php echo $data['post']->fName .
' ' .
$data['post']->lName; ?> </a>
                    </span>
                    <span class="card__date">
                        <svg class="card__icon-post">
                            <use
                                href="<?php echo URLROOT; ?>/images/sprite.svg#icon-calendar">
                            </use>
                        </svg>
                        <?php echo formatDate(
    $data['post']->postCreatedAt
); ?></span>
                    <p class="paragraph u-txt-align-left">
                        <svg class="card__icon-post">
                            <use
                                href="<?php echo URLROOT; ?>/images/sprite.svg#icon-chat">
                            </use>
                        </svg>
                        <span class="card__comments"> Comments: </span>
                        <a class="card__link u-txt-bold" href=""><?php echo !empty(
    $data['comments']
)
? count($data['comments'])
: 0; ?></a>
                    </p>
                </div>
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
): ?>
        <div class="buttons-wrapper">
            <a href="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['post']
    ->postID; ?>" class="button button--success">Edit</a>

            <form action="<?php echo URLROOT; ?>/posts/delete/<?php echo $data[
    'post'
]->postID; ?>" method="POST">
                <input type="submit" value="Delete" class="button button--danger">
            </form>
        </div>

        <?php endif;?>

        <!-- ~~~ Display Edit and Delete buttons END -->


        <!-- Your share button code start-->

        <div class="fb-share-button"
            data-href="<?php echo URLROOT; ?>/posts/show/<?php echo $data['post']->postID; ?>/"
            data-layout="button_count" data-size="large">
            <a target="_blank"
                href="<?php echo URLROOT; ?>/posts/show/<?php echo $data['post']->postID; ?>"
                class="fb-xfbml-parse-ignore">Share
            </a>
        </div>
        <!-- Your share button code end-->

        <!-- <?php var_dump($_SESSION['fb_user_name']); ?>
        <?php var_dump($_SESSION['fb_user_email']); ?>
        -->
        <!-- ~~~ BLOG POST SHOW USER COMMENTS  start -->
        <section class="user-comments">
            <h3 class="h-3 u-mb-big u-txt-align-center">
                <?php echo !empty($data['comments'])
? count($data['comments'])
: 0; ?> Comments</h3>
            <ul class="user-comments__comments">
                <?php foreach ($data['comments'] as $commenter): ?>
                <li class="user-comments__comment">
                    <div class="avatar">
                        <img src="<?php echo URLROOT .
USER_IMG_DIR .
$commenter->userImgName; ?>" alt="" />
                    </div>
                    <div class="user-comments__content">
                        <header>
                            <p class="paragraph">
                                <a href="" class="user-comments__user-link">
                                    <?php echo $commenter->firstName .
" " .
$commenter->lastName; ?></a>

                                <span class="user-comments__published-date">
                                    <?php echo formatDate(
    $commenter->createdAt,
    'd-M-Y, H:i'
); ?>
                                    <svg>
                                        <use href="images/sprite.svg#icon-clock"></use>
                                    </svg>
                                </span>
                            </p>
                        </header>
                        <p class="paragraph">
                            <?php echo $commenter->comment; ?>
                        </p>
                    </div>
                </li>
                <?php endforeach;?>
            </ul>
        </section>
        <!-- ~~~ BLOG POST SHOW USER COMMENTS  end -->

        <?php if (isLoggedIn()): ?>

        <!-- ~~~ BLOG POST ADD USER COMMENTS  start -->

        <form class="form u-div-center u-mt-big u-mb-big" action="<?php echo URLROOT; ?>/posts/show/<?php echo $data[
    'post'
]->postID; ?>" method="post">
            <h3 class="h-3 u-txt-align-center u-mb-big">Leave a Comment</h3>
            <div class="form__group">
                <textarea rows="3" class="form__textarea  <?php echo !empty(
    $data['post']->commentError
)
? 'form__invalid'
: ''; ?>" placeholder="Leave a comment" name="comment" id="comment"></textarea>
                <span class="form__failed-feedback">
                    <?php echo $data['post']->commentError ?? ''; ?></span>
            </div>
            <input class="button" type="submit" value="Send comment">
        </form>

        <!-- ~~~ BLOG POST ADD USER COMMENTS  end -->
        <?php else: ?>

        <div class="form__alert-info">
            In order to post comments you need to be logged in.
        </div>

        <?php endif;?>
        <!-- ~~~ BLOG POST CARD  end -->
    </main>
    <aside class="blog-post__aside">
        <form action="" class="form form--search">
            <input type="text" class="form__input" placeholder="First name" id="first-name" required />
        </form>

        <div class="blog-post__about">
            <h3 class="h-3">About</h3>
            <p class="paragraph">
                I am a Certified Health Coach, focused on women's health,
                bringing you super-practical support to help you feel great,
                take care of your body, and actually enjoy the process. I
                don’t tell my clients what to do, I teach them what to do.
            </p>
            <button class="button">Read more</button>
        </div>
    </aside>
</div>

<!-- ~~~ BLOG POST SECTION  end~~~ -->

<?php require APPROOT . '/views/includes/footer.php';
