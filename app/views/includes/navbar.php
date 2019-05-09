<header class="navigation">

   <div class="navigation__wrapper u-div-center">
      <div class="navigation__upper-half">
         <div class="navigation__row">
            <a href="<?php echo URLROOT; ?>">
               <picture class="navigation__logo">
                  <source srcset="<?php echo URLROOT; ?>/images/logo-134x42.png" media="(max-width: 750px)">
                  <img src="<?php echo URLROOT; ?>/images/logo-536x84.png" alt="Logo of Oildiscovery website" />
               </picture>
            </a>

            <!-- Login/Logout  -->

            <!-- Facebook login start -->
            <div class="navigation__row-container">

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
                  <a class="button button--login" href="<?php echo URLROOT; ?>/admins">Admin</a></div>
               <?php endif; ?>
               <nav class="navigation__nav-social">
                  <ul>
                     <li>
                        <a class="link" href="https://www.facebook.com/oildiscovery.com.au/">
                           <svg class="icon">
                              <use href="<?php echo URLROOT; ?>/images/sprite.svg#icon-facebook">
                              </use>
                           </svg>
                        </a>
                     </li>
                  </ul>
               </nav>
            </div>
         </div>
      </div>

      <div class="nav-menu">

         <input type="checkbox" class="nav-menu__checkbox" id="navi-toggle">
         <label for="navi-toggle" class="nav-menu__button">
            <span class="nav-menu__icon">&nbsp;</span>
         </label>
         <nav class="nav-menu__menu">

            <ul class="nav-menu__list">
               <?php $_SESSION['pages'] ?? redirectTo(''); ?>
               <?php foreach ($_SESSION['pages'] as $page) : ?>
               <?php if ($page->navbar_active === "y") : ?>
               <li class="nav-menu__item">
                  <a class="nav-menu__list <?php echo getCurrentURL() === $page->link ? 'active-link' : ''; ?>"
                     href="<?php echo URLROOT . $page->link; ?>">
                     <?php echo $page->navbar_title; ?></a>
               </li>
               <?php endif; ?>
               <?php endforeach; ?>

            </ul>

         </nav>
      </div>

   </div>

</header>
<?php
// echo getCurrentURL() === $page->link ? 'active-link' : '';