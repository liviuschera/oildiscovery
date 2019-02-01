<header class="header">
   <div class="header__wrapper u-div-center">
      <div class="header__upper-half">
         <div class="header__row">
            <img
               class="header__logo"
               src="<?php echo URLROOT; ?>/images/logo-536x84.png"
               alt="Logo of Oildiscovery website"
               class="header__img"
            />
            <span>Hello,
            <?php echo $_SESSION['login_user_name'] ?? 'User'; ?>
            </span>
            <?php if (isset($_SESSION['login_user_priv'])): ?>

            <span>Go to <a href="<?php echo URLROOT; ?>/admins">Admin area</a></span>
            <?php endif; ?>
            <nav class="header__nav-social">
               <ul>
                  <li>
                     <a class="link" href="">
                        <svg class="icon">
                           <use
                              href="<?php echo URLROOT; ?>/images/sprite.svg#icon-youtube"
                           ></use>
                        </svg>
                     </a>
                  </li>
                  <li>
                     <a class="link" href="">
                        <svg class="icon">
                           <use
                              href="<?php echo URLROOT; ?>/images/sprite.svg#icon-facebook"
                           ></use>
                        </svg>
                     </a>
                  </li>
                  <li>
                     <a class="link" href="">
                        <svg class="icon">
                           <use
                              href="<?php echo URLROOT; ?>/images/sprite.svg#icon-envelope"
                           ></use>
                        </svg>
                     </a>
                  </li>
                  <li>
                     <a class="link" href="">
                        <svg class="icon">
                           <use
                              href="<?php echo URLROOT; ?>/images/sprite.svg#icon-paw"
                           ></use>
                        </svg>
                     </a>
                  </li>
               </ul>
            </nav>
         </div>
      </div>
      
      <nav class="header__nav-site">
         <ul>
            <li><a href="<?php echo URLROOT; ?>">Home</a></li>
            <li><a href="">About</a></li>
            <li><a href="">Join My Team</a></li>
            <li><a href="#">doTERRA Oils as a Business</a></li>
            <li><a href="<?php echo URLROOT; ?>/posts">Blog</a></li>
            <li><a href="">Shop</a></li>
            <li><a href="">Contact me</a></li>
            <?php if (isset($_SESSION['login_user_id'])): ?>
            <li><a href="<?php echo URLROOT; ?>/users/logout">Logout</a></li>
            <?php else: ?>
            <li><a href="<?php echo URLROOT; ?>/users/login">Login</a></li>
            <?php endif; ?>
         </ul>
      </nav>
   </div>
</header>
