<header class="header">
    <div class="header__wrapper u-div-center">
        <div class="header__upper-half">
            <div class="header__row">
                <a href="<?php echo URLROOT; ?>">
                    <img class="header__logo" src="<?php echo URLROOT; ?>/images/logo-536x84.png" alt="Logo of Oildiscovery website" class="header__img" />
                </a>

                <!-- Login/Logout  -->
                <div class="header__row-container">
                    <div class="header__login-out">
                        <?php if (isset($_SESSION['login_user_id'])): ?>
                        <a class="button  button--login" href="<?php echo URLROOT; ?>/users/logout">Logout</a>
                        <?php else: ?>
                        <a class="button  button--login" href="<?php echo URLROOT; ?>/users/login">Login</a>
                        <?php endif; ?>
                    </div>
                    <!-- If user has enough privilege show link to admin area -->
                    <?php if (
                        isset($_SESSION['login_user_priv']) &&
                        $_SESSION['login_user_priv'] > 0
                    ): ?>

                    <div><a class="button  button--login" href="<?php echo URLROOT; ?>/admins">Go to Admin area</a></div>
                    <?php endif; ?>
                    <nav class="header__nav-social">
                        <ul>
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
                                        <use href="<?php echo URLROOT; ?>/images/sprite.svg#icon-instagram"></use>
                                    </svg>
                                </a>
                            </li>

                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <nav class="header__nav-site">
            <ul>
                <?php $_SESSION['pages'] ?? redirectTo(''); ?>
                <?php foreach ($_SESSION['pages'] as $page): ?>
                <li><a href="<?php echo URLROOT . $page->link; ?>">
                        <?php echo $page->navbar_title; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </div>
</header> 