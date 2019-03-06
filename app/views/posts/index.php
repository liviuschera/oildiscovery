<?php require APPROOT . '/views/includes/header.php'; ?>
<?php require APPROOT . '/views/includes/navbar.php'; ?>

<!-- ~~~ BLOG ARTICLES SECTION  start~~~ -->
<section class="full-width-section">
    <section class="full-width-section__content">
        <section class="full-width-section__wrapper">
            <?php flash('post_message'); ?>
            <div class="full-width-section__row full-width-section__row--for-3col-blog">
                <?php foreach ($data['posts'] as $post): ?>
                <!-- ~~~ CARD start -->
                <figure class="card card--for-3col-blog">
                    <div class="card__content card__content--for-3col-blog">
                        <div class="card__img-wrapper">
                            <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->postID; ?>">
                                <img src="<?php echo URLROOT .
                                    BLOG_IMG_DIR .
                                    $post->imgName; ?>" alt="" class="card__img card__img--for-3col-blog" />
                            </a>
                        </div>

                        <div class="card__icon-round">
                            <svg>
                                <use href="images/sprite.svg#icon-pencil2"></use>
                            </svg>
                        </div>

                        <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->postID; ?>" class="card__heading-link">
                            <h6 class="h-6 u-txt-bold u-txt-uppercase  u-color-primary">
                                <?php echo $post->title; ?>
                            </h6>
                        </a>

                        <div class="card__details-wrapper">
                            <span class="card__author">
                                <svg class="card__icon-post">
                                    <use href="<?php echo URLROOT; ?>/images/sprite.svg#icon-user"></use>
                                </svg>
                                By:
                                <a class="card__link" href="">
                                    <?php echo "$post->firstName $post->lastName"; ?> </a>
                            </span>
                            <span class="card__date">
                                <svg class="card__icon-post">
                                    <use href="<?php echo URLROOT; ?>/images/sprite.svg#icon-calendar"></use>
                                </svg>
                                <?php echo formatDate(
                                    $post->createdAt
                                ); ?></span>
                            <p class="paragraph u-txt-align-left">
                                <svg class="card__icon-post">
                                    <use href="<?php echo URLROOT; ?>/images/sprite.svg#icon-chat"></use>
                                </svg>
                                <span class="card__comments"> Comments: </span>
                                <a class="card__link u-txt-bold" href=""><?php echo $post->commentCount; ?></a>
                            </p>
                        </div>

                        <figcaption class="card__info card__info--for-3col-blog">
                            <p class="paragraph">
                                <?php echo strlen($post->content) > 270
                                    ? substr($post->content, 0, 280) . "..."
                                    : $post->content; ?>
                            </p>
                        </figcaption>

                        <div class="card__row">
                            <button class="button button--tag">
                                Permission
                            </button>
                            <button class="button button--tag">Health</button>
                            <button class="button button--tag">Coach</button>
                        </div>
                </figure>
                <!-- ~~~ CARD end -->
                <?php endforeach; ?>

            </div>
            <?php echo paginate($_SESSION['row_count_posts']); ?>

        </section>
    </section>
</section>
<!-- ~~~ BLOG ARTICLES SECTION  end~~~ -->

<?php require APPROOT . '/views/includes/footer.php'; ?> 