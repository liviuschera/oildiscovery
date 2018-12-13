<?php require APPROOT .
    '../views/includes/header.php'; ?> <?php require APPROOT .
     '../views/includes/navbar.php'; ?>

<!-- ~~~ LOGIN FORM start ~~~ -->

<form
   action="<?php echo URLROOT; ?>/users/login"
   class="form u-div-center"
   method="post"
>
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
            id="email"
         />
         <span class="form__invalid-feedback"
            ><?php echo $data['email_error']; ?></span
         >
      </div>
      <div class="form__group">
         <input
            type="password"
            class="form__input <?php echo !empty($data['password_error'])
                ? 'form__invalid'
                : ''; ?>"
            value="<?php echo $data['password']; ?>"
            placeholder="Password"
         />
         <span class="form__invalid-feedback"
            ><?php echo $data['password_error']; ?></span
         >
      </div>
   </div>

   <div class="form__row">
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
   </div>
</form>
<!-- ~~~ LOGIN FORM end ~~~ -->
