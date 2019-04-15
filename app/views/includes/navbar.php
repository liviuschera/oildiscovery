<header class="navigation">
    <!-- <input type="checkbox" class="navigation__checkbox" id="navi-toggle">

    <label for="navi-toggle" class="navigation__button">
        <span class="navigation__icon">&nbsp;</span>
    </label> -->
    <div class="navigation__wrapper u-div-center">
        <div class="navigation__upper-half">
            <div class="navigation__row">
                <a href="<?php echo URLROOT; ?>">
                    <img class="navigation__logo" src="<?php echo URLROOT; ?>/images/logo-536x84.png" alt="Logo of Oildiscovery website" />
                </a>

                <!-- Login/Logout  -->

                <!-- Facebook login start -->
                <div class="navigation__row-container">
                    <div class="navigation__login-fb">
                        <?php if (!isset($_SESSION['fb_access_token'])) :

                            $fb = initFacebook();
                            $helper = $fb->getRedirectLoginHelper();
                            $permissions = ['email']; // Optional permissions
                            $loginUrl = $helper->getLoginUrl(
                                FB_APP_CALLBACK_URL,
                                $permissions
                            );
                            ?>
                            <a class="button button--login" href="<?php echo htmlspecialchars(
                                                                        $loginUrl
                                                                    ); ?>">Log in with
                                <svg class="icon">
                                    <use href="<?php echo URLROOT; ?>/images/sprite.svg#icon-facebook">
                                    </use>
                                </svg>
                                acebook!</a>
                        <?php endif; ?>
                    </div>
                    <!-- Facebook login end -->

                    <div class="navigation__login-email">
                        <?php if (
                            isset($_SESSION['login_user_id']) ||
                            isset($_SESSION['fb_access_token'])
                        ) : ?>
                            <a class="button button--login" href="<?php echo URLROOT; ?>/users/logout">Logout</a>
                        <?php else : ?>
                            <a class="button  button--login" href="<?php echo URLROOT; ?>/users/login">Log
                                in
                                or Register</a>
                        <?php endif; ?>
                    </div>
                    <!-- If user has enough privilege show link to admin area -->
                    <?php if (
                        isset($_SESSION['login_user_priv']) &&
                        $_SESSION['login_user_priv'] > 0
                    ) : ?>

                        <div>
                            <a class="button button--login" href="<?php echo URLROOT; ?>/admins">Go
                                to Admin
                                area</a></div>
                    <?php endif; ?>
                    <nav class="navigation__nav-social">
                        <ul>
                            <li>
                                <a class="link" href="">
                                    <svg class="icon">
                                        <use href="<?php echo URLROOT; ?>/images/sprite.svg#icon-facebook">
                                        </use>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a class="link" href="">
                                    <svg class="icon">
                                        <use href="<?php echo URLROOT; ?>/images/sprite.svg#icon-instagram">
                                        </use>
                                    </svg>
                                </a>
                            </li>

                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <nav class="navigation__menu">

            <ul>
                <?php $_SESSION['pages'] ?? redirectTo(''); ?>
                <?php foreach ($_SESSION['pages'] as $page) : ?>
                    <li>
                        <a class="<?php echo getCurrentURL() === $page->link ? 'active-link' : ''; ?>" href="<?php echo URLROOT . $page->link; ?>">
                            <?php echo $page->navbar_title; ?></a>
                    </li>
                <?php endforeach; ?>

            </ul>

        </nav>
    </div>

</header>
<?php
// echo getCurrentURL() === $page->link ? 'active-link' : '';
