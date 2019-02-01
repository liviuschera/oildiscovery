<?php require APPROOT . '/views/includes/header.php'; ?> 
<?php require APPROOT . '/views/includes/navbar.php'; ?>
      <!-- <?php var_dump($data['post']); ?> -->

      <!-- ~~~ BLOG POST SECTION  start~~~ -->
      <div class="blog-post">
         <main class="blog-post__main">
            <!-- ~~~ BLOG POST CARD  start -->
            <!-- <figure class="card card--full-width-blogpost">
               <div class="card__content card__content--for-3col-blog">
                  <div
                     class="card__img-wrapper card__img-wrapper--full-width-blogpost"
                  >
                     <a href="">
                        <img
                           src="<?php echo URLROOT; ?>/images/blog/post-06-770x480.jpg"
                           alt=""
                           class="card__img card__img--full-width-blogpost"
                        />
                     </a>
                  </div>

                  <a href="" class="card__heading-link">
                     <h6 class="heading6 u-txt-uppercase u-color-primary">
                        <?php echo $data['post']->title; ?>
                     </h6>
                  </a>
                  <div class="card__details-wrapper">
                        <span class="card__author">
                           <svg class="card__icon-post">
                              <use
                                 href="<?php echo URLROOT; ?>/images/sprite.svg#icon-user"
                              ></use>
                           </svg>
                           By:
                           <a class="card__link" href=""> <?php echo "{$data['post']->fName} {$data['post']->lName}"; ?> </a>
                        </span>
                        <span class="card__date">
                           <svg class="card__icon-post">
                              <use
                                 href="<?php echo URLROOT; ?>/images/sprite.svg#icon-calendar"
                              ></use>
                           </svg>
                           <?php echo formatDate(
                               $data['post']->postCreatedAt
                           ); ?></span
                        >
                        <p class="paragraph u-txt-align-left">
                           <svg class="card__icon-post">
                              <use
                                 href="<?php echo URLROOT; ?>/images/sprite.svg#icon-chat"
                              ></use>
                           </svg>
                           <span class="card__comments"> Comments: </span>
                           <a class="card__link u-txt-bold" href="">3 </a>
                        </p>
                     </div>
                 
                  <p class="paragraph">
                  <?php echo $data['post']->content; ?>
                  </p>
                  <p class="paragraph">
                     In recognition of this, the World Health Organisation (WHO)
                     recommends adults and children limit their intake of “free
                     sugars” to less than 10% of their total energy intake.
                     Below 5% is even better and carries additional health
                     benefits.
                  </p>
                  <div
                     class="card__img-wrapper card__img-wrapper--full-width-blogpost"
                  >
                     <a href="">
                        <img
                           src="<?php echo URLROOT; ?>/images/blog/post-06-770x480.jpg"
                           alt=""
                           class="card__img card__img--full-width-blogpost"
                        />
                     </a>
                  </div>
                  <p class="paragraph">
                     Lorem ipsum dolor sit amet consectetur adipisicing elit.
                     Hic est ad eum aut maiores dolorem, expedita id tenetur
                     explicabo mollitia magni ea cupiditate. Iste, laborum
                     eligendi! Reprehenderit aut corporis voluptates? Lorem
                     ipsum dolor sit amet consectetur adipisicing elit. Sunt
                     corrupti debitis quod? Sunt non magni fuga, quia facere
                     similique cumque asperiores qui excepturi odio corporis ex
                     dolor, dicta ullam atque?
                  </p>
               </div>
            </figure> -->
            <!-- ~~~ BLOG POST CARD end -->
            <?php echo $data['post']->content; ?>
            <!-- ~~~ Display Edit and Delete buttons START -->

<?php if ($data['post']->userID === $_SESSION['login_user_id']): ?>

<a href="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['post']
    ->postID; ?>" class="button button--success">Edit</a>

    <form action="<?php echo URLROOT; ?>/posts/delete/<?php echo $data['post']
    ->postID; ?>" method="POST">
    <input type="submit" value="Delete" class="button button--danger">
    </form>
                        <?php endif; ?>

            <!-- ~~~ Display Edit and Delete buttons END -->

            <!-- ~~~ BLOG POST NAV SOCIAL start -->

            <section class="social-media-buttons">
               <div class="social-media-buttons__wrapper">
                  <h6 class="heading6">Share this post:</h6>
                  <nav class="social-buttons">
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
                                 <use href="<?php echo URLROOT; ?>/images/sprite.svg#icon-paw"></use>
                              </svg>
                           </a>
                        </li>
                     </ul>
                  </nav>
               </div>
            </section>

            <!-- ~~~ BLOG POST NAV SOCIAL end -->

            <!-- ~~~ BLOG POST USER COMMENTS  start -->
            <section class="user-comments">
               <h3 class="heading-tertiary">3 Comments</h3>
               <ul class="user-comments__comments">
                  <li class="user-comments__comment">
                     <div class="user-comments__avatar">
                        <img
                           src="<?php echo URLROOT; ?>/images/users/user-alan-smith-70x71.jpg"
                           alt=""
                        />
                     </div>
                     <div class="user-comments__content">
                        <header>
                           <p class="paragraph">
                              <a href="" class="user-comments__user-link"
                                 >John</a
                              >
                              <span class="user-comments__like">
                                 <a href=""> Like </a>
                                 <svg>
                                    <use
                                       href="images/sprite.svg#icon-thumbs-up"
                                    ></use>
                                 </svg>
                              </span>
                              <span class="user-comments__reply">
                                 <a href=""> Reply </a>
                                 <svg>
                                    <use
                                       href="images/sprite.svg#icon-chat"
                                    ></use>
                                 </svg>
                              </span>
                              <span class="user-comments__published-date"
                                 >Feb 16, 7:42 PM
                                 <svg>
                                    <use
                                       href="images/sprite.svg#icon-clock"
                                    ></use>
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
                              <img
                                 src="<?php echo URLROOT; ?>/images/users/user-jessica-priston-151x151.jpg"
                                 alt=""
                              />
                           </div>
                           <div class="user-comments__content">
                              <header>
                                 <p class="paragraph">
                                    <a href="" class="user-comments__user-link"
                                       >John</a
                                    >
                                    <span class="user-comments__like">
                                       <a href=""> Like </a>
                                       <svg>
                                          <use
                                             href="images/sprite.svg#icon-thumbs-up"
                                          ></use>
                                       </svg>
                                    </span>
                                    <span class="user-comments__reply">
                                       <a href=""> Reply </a>
                                       <svg>
                                          <use
                                             href="images/sprite.svg#icon-chat"
                                          ></use>
                                       </svg>
                                    </span>
                                    <span class="user-comments__published-date"
                                       >Feb 16, 7:42 PM
                                       <svg>
                                          <use
                                             href="images/sprite.svg#icon-clock"
                                          ></use>
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
                        <img
                           src="<?php echo URLROOT; ?>/images/users/user-mila-moa-70x71.jpg"
                           alt=""
                        />
                     </div>
                     <div class="user-comments__content">
                        <header>
                           <p class="paragraph">
                              <a href="" class="user-comments__user-link"
                                 >John</a
                              >
                              <span class="user-comments__like">
                                 <a href=""> Like </a>
                                 <svg>
                                    <use
                                       href="images/sprite.svg#icon-thumbs-up"
                                    ></use>
                                 </svg>
                              </span>
                              <span class="user-comments__reply">
                                 <a href=""> Reply </a>
                                 <svg>
                                    <use
                                       href="images/sprite.svg#icon-chat"
                                    ></use>
                                 </svg>
                              </span>
                              <span class="user-comments__published-date"
                                 >Feb 16, 7:42 PM
                                 <svg>
                                    <use
                                       href="images/sprite.svg#icon-clock"
                                    ></use>
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
            <!-- ~~~ BLOG POST USER COMMENTS  end -->

            <!-- ~~~ BLOG POST CARD  end -->
         </main>
         <aside class="blog-post__aside">
            <form action="" class="form form--search">
               <input
                  type="text"
                  class="form__input"
                  placeholder="First name"
                  id="first-name"
                  required
               />
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