<?php require APPROOT . '/views/includes/header.php'; ?>
<?php require APPROOT . '/views/includes/navbar.php'; ?>
<!-- <?php var_dump($data['post']); ?> -->

<!-- ~~~ BLOG POST SECTION  start~~~ -->
<div class="blog-post">
    <main class="blog-post__main">
        <!-- ~~~ BLOG POST CARD  start -->
        <figure class="card card--full-width-blogpost">
            <?php flash('post_message'); ?>
            <div class="card__content card__content--for-3col-blog">
                <div class="card__img-wrapper card__img-wrapper--full-width-blogpost">
                    <a href="">
                        <img src="<?php echo URLROOT .
                            BLOG_IMG_DIR .
                            $data['post']
                                ->imgName; ?>" alt="" class="card__img card__img--full-width-blogpost" />
                    </a>
                </div>

                <a href="" class="card__heading-link card__heading-link--full-width-blogpost">
                    <h6 class="h-6 u-txt-uppercase u-color-primary">
                        <?php echo $data['post']->title; ?>
                    </h6>
                </a>
                <div class="card__details-wrapper card__details-wrapper--full-width-blogpost">
                    <span class="card__author">
                        <svg class="card__icon-post">
                            <use href="<?php echo URLROOT; ?>/images/sprite.svg#icon-user"></use>
                        </svg>
                        By:
                        <a class="card__link" href="">
                            <?php echo $data['post']->fName .
                                ' ' .
                                $data['post']->lName; ?> </a>
                    </span>
                    <span class="card__date">
                        <svg class="card__icon-post">
                            <use href="<?php echo URLROOT; ?>/images/sprite.svg#icon-calendar"></use>
                        </svg>
                        <?php echo formatDate(
                            $data['post']->postCreatedAt
                        ); ?></span>
                    <p class="paragraph u-txt-align-left">
                        <svg class="card__icon-post">
                            <use href="<?php echo URLROOT; ?>/images/sprite.svg#icon-chat"></use>
                        </svg>
                        <span class="card__comments"> Comments: </span>
                        <a class="card__link u-txt-bold" href="">3 </a>
                    </p>
                </div>
            </div>

            <?php echo $data['post']->content; ?>

        </figure>
        <!-- ~~~ BLOG POST CARD end -->
        <!-- <?php echo $data['post']->content; ?> -->

        <!-- ~~~ Display Edit and Delete buttons START -->

        <?php if ($data['post']->userID === $_SESSION['login_user_id']): ?>
        <div class="buttons-wrapper">
            <a href="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['post']
    ->postID; ?>" class="button button--success">Edit</a>

            <form action="<?php echo URLROOT; ?>/posts/delete/<?php echo $data[
    'post'
]->postID; ?>" method="POST">
                <input type="submit" value="Delete" class="button button--danger">
            </form>
        </div>

        <?php endif; ?>

        <!-- ~~~ Display Edit and Delete buttons END -->

        <!-- ~~~ BLOG POST NAV SOCIAL start -->

        <section class="social-media-buttons">
            <div class="social-media-buttons__wrapper">
                <h6 class="h-6 u-txt-bold">Share this post:</h6>
                <nav class="social-buttons">
                    <ul>
                        <li>
                            <a class="link" href="">
                                <svg class="icon">
                                    <use href="<?php echo URLROOT; ?>/images/sprite.svg#icon-youtube"></use>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a class="link" href="">
                                <svg class="icon">
                                    <use href="<?php echo URLROOT; ?>/images/sprite.svg#icon-facebook"></use>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a class="link" href="">
                                <svg class="icon">
                                    <use href="<?php echo URLROOT; ?>/images/sprite.svg#icon-envelope"></use>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a class="link" href="">
                                <svg class="icon">
                                    <use href="<?php echo URLROOT; ?>/images/sprite.svg#icon-paw"></use>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </section>

        <!-- ~~~ BLOG POST NAV SOCIAL end -->

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
                <?php endforeach; ?>
            </ul>
        </section>
        <!-- ~~~ BLOG POST SHOW USER COMMENTS  end -->

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

<?php require APPROOT . '/views/includes/footer.php'; ?> 