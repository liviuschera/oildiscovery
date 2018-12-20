<?php require APPROOT .
    '../views/includes/header.php'; ?> <?php require APPROOT .
     '../views/includes/navbar.php'; ?>

<!-- ~~~ REGISTRATION FORM start ~~~ -->

<form
   action="<?php echo URLROOT; ?>/users/register"
   class="form u-div-center"
   method="post"
>
   <h3 class="heading-tertiary">Create an account</h3>
   <p class="paragraph">Please fill out this form to register.</p>
   <!-- <pre><?php echo var_dump($data); ?></pre> -->
   <div class="form__row">
      <div class="form__group">
         <input
            type="text"
            class="form__input <?php echo !empty($data['first_name_error'])
                ? 'form__invalid'
                : ''; ?>"
            value="<?php echo $data['first_name']; ?>"
            placeholder="First name"
            name="first_name"
            id="first_name"

         />
         <span class="form__invalid-feedback"><?php echo $data[
             'first_name_error'
         ]; ?></span>
      </div>
      <div class="form__group">
         <input
            type="text"
            class="form__input <?php echo !empty($data['last_name_error'])
                ? 'form__invalid'
                : ''; ?>"
            value="<?php echo $data['last_name']; ?>"
            placeholder="Last name"
            name="last_name"
            id="last_name"
         />
         <span class="form__invalid-feedback"><?php echo $data[
             'last_name_error'
         ]; ?></span>
      </div>
   </div>
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
            id="email"
         />
         <span class="form__invalid-feedback"><?php echo $data[
             'email_error'
         ]; ?></span>
      </div>
      <div class="form__group">
         <input
            type="tel"
            class="form__input <?php echo !empty($data['phone_error'])
                ? 'form__invalid'
                : ''; ?>"
            value="<?php echo $data['phone']; ?>"
            placeholder="Phone"
            name="phone"
            id="phone"
         />
         <span class="form__invalid-feedback"><?php echo $data[
             'phone_error'
         ]; ?></span>
      </div>
   </div>

   <div class="form__row">
      <div class="form__group">
         <input
            type="password"
            class="form__input <?php echo !empty($data['passw_error'])
                ? 'form__invalid'
                : ''; ?>"
            value="<?php echo $data['passw']; ?>"
            placeholder="Password"
            name="passw"
            id="passw"
         />
         <span class="form__invalid-feedback"><?php echo $data[
             'passw_error'
         ]; ?></span>
      </div>
      <div class="form__group">
         <input
            type="password"
            class="form__input <?php echo !empty($data['confirm_passw_error'])
                ? 'form__invalid'
                : ''; ?>"
            value="<?php echo $data['confirm_passw']; ?>"
            placeholder="Confirm password"
            name="confirm_passw"
            id="confirm_passw"
         />
         <span class="form__invalid-feedback"><?php echo $data[
             'confirm_passw_error'
         ]; ?></span>
      </div>
   </div>
   <div class="form__row">
      <a
         class="button"
         href="<?php echo URLROOT; ?>/users/login"
         type="submit"
      >
         Have an account? Login
      </a>
      <input
         class="button"
         type="submit"
         value="Register"
      >
      <!-- <button
         class="button"
         formaction="<?php echo URLROOT; ?>/users/login"
         type="submit"
      >
         Have an account? Login
      </button>
      <button
         class="button"
         formaction="<?php echo URLROOT; ?>/users/register"
         type="submit"
      >
         Register
      </button> -->
   </div>
</form>
<!-- ~~~ REGISTRATION FORM end ~~~ -->
