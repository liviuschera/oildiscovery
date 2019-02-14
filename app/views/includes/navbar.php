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
            <!-- Greet user -->
            <span>Hello,
            <?php echo $_SESSION['login_user_name'] ?? 'User'; ?>
            </span>
            <!-- Login/Logout  -->
            <span>
            <?php if (isset($_SESSION['login_user_id'])): ?>
               <a href="<?php echo URLROOT; ?>/users/logout">Logout</a>
               <?php else: ?>
               <a href="<?php echo URLROOT; ?>/users/login">Login</a>
                           <?php endif; ?>
            </span>
            <!-- If user has enough privilege show link to admin area -->
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
            <?php foreach ($_SESSION['pages'] as $page): ?>
               <li><a href="<?php echo URLROOT .
                   $page->link; ?>"><?php echo $page->navbar_title; ?></a></li>
            <?php endforeach; ?>
         </ul>
      </nav>
   </div>
</header>
