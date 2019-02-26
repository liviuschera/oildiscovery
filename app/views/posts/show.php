<?php require APPROOT . '/views/includes/header.php'; ?>
<?php require APPROOT . '/views/includes/navbar.php'; ?>
<!-- <?php var_dump($data['post']); ?> -->

<!-- ~~~ BLOG POST SECTION  start~~~ -->
<div class="blog-post">
    <main class="blog-post__main">
        <!-- ~~~ BLOG POST CARD  start -->
        <figure class="card card--full-width-blogpost">
            <div class="card__content card__content--for-3col-blog">
                <div class="card__img-wrapper card__img-wrapper--full-width-blogpost">
                    <a href="">
                        <img src="<?php echo URLROOT .
                            IMG_DIR .
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
            <h3 class="heading-tertiary">3 Comments</h3>
            <ul class="user-comments__comments">
                <li class="user-comments__comment">
                    <div class="user-comments__avatar">
                        <img src="<?php echo URLROOT; ?>/images/users/user-alan-smith-70x71.jpg" alt="" />
                    </div>
                    <div class="user-comments__content">
                        <header>
                            <p class="paragraph">
                                <a href="" class="user-comments__user-link">John</a>
                                <span class="user-comments__like">
                                    <a href=""> Like </a>
                                    <svg>
                                        <use href="images/sprite.svg#icon-thumbs-up"></use>
                                    </svg>
                                </span>
                                <span class="user-comments__reply">
                                    <a href=""> Reply </a>
                                    <svg>
                                        <use href="images/sprite.svg#icon-chat"></use>
                                    </svg>
                                </span>
                                <span class="user-comments__published-date">Feb 16, 7:42 PM
                                    <svg>
                                        <use href="images/sprite.svg#icon-clock"></use>
                                    </svg>
                                </span>
                            </p>
                        </header>
                        <p class="paragraph">
                            Lorem ipsum dolor, sit amet consectetur adipisicing
                            elit. Iusto a quam reiciendis, temporibus earum
                            dolorum sunt blanditiis possimus, dolor deleniti
                            adipisci veritatis praesentium voluptatum. Illo
                            nostrum nihil obcaecati fugiat tempora.
                        </p>
                        <p class="paragraph">
                            Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Vero sint maiores animi maxime possimus
                            nesciunt et incidunt temporibus vel accusantium
                            quisquam omnis, dolorem, aliquid explicabo sed facere
                            earum, ab velit?
                        </p>
                    </div>

                    <ul class="user-comments__reply">
                        <li class="user-comments__comment">
                            <div class="user-comments__avatar">
                                <img src="<?php echo URLROOT; ?>/images/users/user-jessica-priston-151x151.jpg" alt="" />
                            </div>
                            <div class="user-comments__content">
                                <header>
                                    <p class="paragraph">
                                        <a href="" class="user-comments__user-link">John</a>
                                        <span class="user-comments__like">
                                            <a href=""> Like </a>
                                            <svg>
                                                <use href="images/sprite.svg#icon-thumbs-up"></use>
                                            </svg>
                                        </span>
                                        <span class="user-comments__reply">
                                            <a href=""> Reply </a>
                                            <svg>
                                                <use href="images/sprite.svg#icon-chat"></use>
                                            </svg>
                                        </span>
                                        <span class="user-comments__published-date">Feb 16, 7:42 PM
                                            <svg>
                                                <use href="images/sprite.svg#icon-clock"></use>
                                            </svg>
                                        </span>
                                    </p>
                                </header>
                                <p class="paragraph">
                                    Lorem ipsum dolor, sit amet consectetur
                                    adipisicing elit. Iusto a quam reiciendis,
                                    temporibus earum dolorum sunt blanditiis
                                    possimus, dolor deleniti adipisci veritatis
                                    praesentium voluptatum. Illo nostrum nihil
                                    obcaecati fugiat tempora.
                                </p>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="user-comments__comment">
                    <div class="user-comments__avatar">
                        <img src="<?php echo URLROOT; ?>/images/users/user-mila-moa-70x71.jpg" alt="" />
                    </div>
                    <div class="user-comments__content">
                        <header>
                            <p class="paragraph">
                                <a href="" class="user-comments__user-link">John</a>
                                <span class="user-comments__like">
                                    <a href=""> Like </a>
                                    <svg>
                                        <use href="images/sprite.svg#icon-thumbs-up"></use>
                                    </svg>
                                </span>
                                <span class="user-comments__reply">
                                    <a href=""> Reply </a>
                                    <svg>
                                        <use href="images/sprite.svg#icon-chat"></use>
                                    </svg>
                                </span>
                                <span class="user-comments__published-date">Feb 16, 7:42 PM
                                    <svg>
                                        <use href="images/sprite.svg#icon-clock"></use>
                                    </svg>
                                </span>
                            </p>
                        </header>
                        <p class="paragraph">
                            Lorem ipsum dolor, sit amet consectetur adipisicing
                            elit. Iusto a quam reiciendis, temporibus earum
                            dolorum sunt blanditiis possimus, dolor deleniti
                            adipisci veritatis praesentium voluptatum. Illo
                            nostrum nihil obcaecati fugiat tempora.
                        </p>
                    </div>
                </li>
            </ul>
        </section>
        <!-- ~~~ BLOG POST SHOW USER COMMENTS  end -->

        <!-- ~~~ BLOG POST ADD USER COMMENTS  start -->

        <form class="form u-div-center u-mt-big u-mb-big" action="<?php echo URLROOT; ?>/users/show/<?php echo $_SESSION[
    'login_user_id'
]; ?>" method="post">
            <h3 class="h-3 u-txt-align-center u-mb-big">Leave a Comment</h3>
            <div class="form__group">
                <textarea rows="3" class="form__textarea  <?php echo !empty(
                    $data['commentError']
                )
                    ? 'form__invalid'
                    : ''; ?>" placeholder="Leave a comment" name="comment" id="comment"></textarea>
                <span class="form__failed-feedback">
                    <?php echo $data['commentError'] ?? ''; ?></span>
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
            <h3 class="heading-tertiary">About</h3>
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