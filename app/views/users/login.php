<?php require APPROOT .
    '../views/includes/header.php'; ?> <?php require APPROOT .
     '../views/includes/navbar.php'; ?>

<!-- ~~~ LOGIN FORM start ~~~ -->

<form
   action="<?php echo URLROOT; ?>/users/login"
   class="form u-div-center"
   method="post"
>
   <?php flash('register_success'); ?>
   <h3 class="heading-tertiary">Login</h3>
   <code><?php echo var_dump($data); ?></code>

   <div class="form__row">
      <div class="form__group">
         <input
            type="email"
            class="form__input <?php echo !empty($data['email_error'])
                ? 'form__invalid'
                : ''; ?>"
            value="<?php echo $data['email']; ?>"
            placeholder="Email"
            name="email"
         />
         <span class="form__invalid-feedback"
            ><?php echo $data['email_error']; ?></span
         >
      </div>
      <div class="form__group">
         <input
            type="password"
            class="form__input <?php echo !empty($data['passw_error'])
                ? 'form__invalid'
                : ''; ?>"
            value="<?php echo $data['passw']; ?>"
            placeholder="passw"
            name="passw"
         />
         <span class="form__invalid-feedback"
            ><?php echo $data['passw_error']; ?></span
         >
      </div>
   </div>

   <div class="form__row">
      <!-- <a
         class="button"
         href="<?php echo URLROOT; ?>/users/register"
         type="submit"
      >
         No account? Register
      </a>
      <input
         class="button"
         type="submit"
         value="Login"
      >
   </div> -->
   <button
         class="button"
         formaction="<?php echo URLROOT; ?>/users/register"
         type="submit"
      >
      No account? Register
      </button>
      <button
         class="button"
         formaction="<?php echo URLROOT; ?>/users/login"
         type="submit"
      >
         Login
      </button>
</form>
<!-- ~~~ LOGIN FORM end ~~~ -->
