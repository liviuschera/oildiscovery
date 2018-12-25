<?php require APPROOT . '../views/includes/header.php'; ?> 
<?php require APPROOT . '../views/includes/navbar.php'; ?>


<!-- ~~~ BLOG ARTICLES SECTION  start~~~ -->
<section class="full-width-section">
   <section class="full-width-section__content">
      <section class="full-width-section__wrapper">
         <div
         class="full-width-section__row full-width-section__row--for-3col-blog"
         >
         <?php foreach ($data['posts'] as $post): ?>
                  <!-- ~~~ CARD start -->
                  <figure class="card card--for-3col-blog">
                     <div class="card__content card__content--for-3col-blog">
                        <div class="card__img-wrapper">
                           <a href="">
                              <img
                                 src="images/pages/events-01-390x289.jpg"
                                 alt=""
                                 class="card__img card__img--for-3col-blog"
                              />
                           </a>
                        </div>

                        <div class="card__icon-round">
                           <svg>
                              <use href="images/sprite.svg#icon-pencil2"></use>
                           </svg>
                        </div>
                        <a href="" class="card__heading-link">
                           <h6
                              class="heading6 u-txt-uppercase u-txt-align-center u-color-primary"
                           >
                              <?php echo $post->title; ?>
                           </h6>
                        </a>

                        <div class="card__details-wrapper">
                           <a class="card__link bold" href=""
                              >Street Workout
                              <svg class="card__icon-post">
                                 <use
                                    href="images/sprite.svg#icon-camera"
                                 ></use>
                              </svg>
                           </a>
                           <span class="card__date">September, 12, 2016</span>
                           <p class="paragraph u-txt-align-left">
                              <svg class="card__icon-post">
                                 <use href="images/sprite.svg#icon-chat"></use>
                              </svg>
                              Comments:
                              <a class="card__link bold" href="">3 </a>
                           </p>
                        </div>
                     </div>

                     <figcaption class="card__info card__info--for-3col-blog">
                        <p class="paragraph">
                           Consuming too much energy – whether from fat or
                           carbohydrates, including sugar – will make you gain
                           weight. If left unchecked, this excess weight
                           increases your risk of lifestyle-related diseases
                           such as diabetes, heart disease and some cancers...
                        </p>
                     </figcaption>

                     <div class="card__row">
                        <button class="button button--tag">Permission</button>
                        <button class="button button--tag">Health</button>
                        <button class="button button--tag">Coach</button>
                     </div>
                  </figure>
                  <!-- ~~~ CARD end -->
                  <?php endforeach; ?>

               </div>
               <div class="full-width-section__row u-margin-top-big">
                  <a href="" class="button button--pagination">Prev</a>
                  <a href="" class="button button--pagination">1</a>
                  <a href="" class="button button--pagination">2</a>
                  <a href="" class="button button--pagination">3</a>
                  <a href="" class="button button--pagination">Next</a>
               </div>
            </section>
         </section>
      </section>
      <!-- ~~~ BLOG ARTICLES SECTION  end~~~ -->

<?php require APPROOT . '../views/includes/footer.php'; ?> 
