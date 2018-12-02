<?php require APPROOT . '../views/includes/header.php'; ?>
<?php require APPROOT . '../views/includes/navbar.php'; ?>


<!-- ~~~ REGISTRATION FORM start ~~~ -->

<form action="<?php echo URLROOT; ?>/users/register" class="form u-div-center">
<h3 class="heading-tertiary">Register</h3>
   <div class="form__row">
      <input
         type="text"
         class="form__input"
         placeholder="First name"
         id="first-name"
         required
      />

      <input
         type="text"
         class="form__input"
         placeholder="Last name"
         id="last-name"
         required
      />
   </div>
   <div class="form__row">
      <input
         type="email"
         class="form__input"
         placeholder="Email"
         id="email"
         required
      />

      <input
         type="tel"
         class="form__input"
         placeholder="Phone"
         id="phone"
         required
      />
   </div>

   <div class="form__row">
      <input type="password" class="form__input" placeholder="Password" />
      <input
         type="password"
         class="form__input"
         placeholder="Confirm Password"
      />
   </div>
   <div class="form__row">
      <button class="button" formaction="<?php echo URLROOT; ?>/users/login" type="submit">Have an account? Login</button>
      <button class="button" formaction="<?php echo URLROOT; ?>/users/register" type="submit">Register</button>
   </div>
</form>
<!-- ~~~ REGISTRATION FORM end ~~~ -->


