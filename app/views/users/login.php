<?php require APPROOT . '../views/includes/header.php'; ?>
<?php require APPROOT . '../views/includes/navbar.php'; ?>

<!-- ~~~ LOGIN FORM start ~~~ -->

<form action="<?php echo URLROOT; ?>/users/login" class="form u-div-center">
   <h3 class="heading-tertiary">Login</h3>
   
   <div class="form__row">
      <input
         type="email"
         class="form__input"
         placeholder="Email"
         id="email"
         required
      />
      <input
         type="password"
         class="form__input"
         placeholder="Password"
         id='password'
         required
      />
   </div>

   <div class="form__row">
      <button class="button" formaction="<?php echo URLROOT; ?>/users/register" type="submit">No account? Register</button>
      <button class="button" formaction="<?php echo URLROOT; ?>/users/login" type="submit">Login</button>
   </div>
</form>
<!-- ~~~ LOGIN FORM end ~~~ -->


