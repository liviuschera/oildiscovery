<?php require APPROOT .
    '../views/includes/header.php'; ?> <?php require APPROOT .
     '../views/includes/navbar.php'; ?>

<!-- ~~~ EDIT FORM start ~~~ -->

<form
   action="<?php echo URLROOT; ?>/users/edit/<?php echo $data['id']; ?>"
   class="form u-div-center u-txt-align-center"
   method="post"
>
   <h3 class="h-2">Edit an username</h3>
   <p class="paragraph">Edit the necessary fields.</p>
   <pre><?php echo var_dump($data); ?></pre>
   <div class="form__row">
      <div class="form__group">
         <input
            type="text"
            class="form__input <?php echo !empty($data['firstNameError'])
                ? 'form__invalid'
                : ''; ?>"
            value="<?php echo $data['firstName']; ?>"
            placeholder="First name"
            name="firstName"
            id="firstName"

         />
         <span class="form__failed-feedback"><?php echo $data[
             'firstNameError'
         ]; ?></span>
      </div>
      <div class="form__group">
         <input
            type="text"
            class="form__input <?php echo !empty($data['lastNameError'])
                ? 'form__invalid'
                : ''; ?>"
            value="<?php echo $data['lastName']; ?>"
            placeholder="Last name"
            name="lastName"
            id="lastName"
         />
         <span class="form__failed-feedback"><?php echo $data[
             'lastNameError'
         ]; ?></span>
      </div>
   </div>
   <div class="form__row">
      <div class="form__group">
         <input
            type="email"
            class="form__input <?php echo !empty($data['emailError'])
                ? 'form__invalid'
                : ''; ?>"
            value="<?php echo $data['email']; ?>"
            placeholder="Email"
            name="email"
            id="email"
         />
         <span class="form__failed-feedback"><?php echo $data[
             'emailError'
         ]; ?></span>
      </div>
      <div class="form__group">
         <input
            type="tel"
            class="form__input <?php echo !empty($data['phoneError'])
                ? 'form__invalid'
                : ''; ?>"
            value="<?php echo $data['phone']; ?>"
            placeholder="Phone"
            name="phone"
            id="phone"
         />
         <span class="form__failed-feedback"><?php echo $data[
             'phoneError'
         ]; ?></span>
      </div>
   </div>
<!-- Set Password and Confirm Password -->
   <div class="form__row">
      <div class="form__group">
         <input
            type="password"
            class="form__input <?php echo !empty($data['passwError'])
                ? 'form__invalid'
                : ''; ?>"
            value="<?php echo $data['passw']; ?>"
            placeholder="Password"
            name="passw"
            id="passw"
         />
         <span class="form__failed-feedback"><?php echo $data[
             'passwError'
         ]; ?></span>
      </div>
      <div class="form__group">
         <input
            type="password"
            class="form__input <?php echo !empty($data['confirmPasswError'])
                ? 'form__invalid'
                : ''; ?>"
            value="<?php echo $data['confirmPassw']; ?>"
            placeholder="Confirm password"
            name="confirmPassw"
            id="confirmPassw"
         />
         <span class="form__failed-feedback"><?php echo $data[
             'confirmPasswError'
         ]; ?></span>
      </div>
   </div>
   <!-- Set PRIV and ACTIVE -->
      <div class="form__row">

   <!-- User ACTIVE -->
   <div class="form__group">
         <div class="form__checkbox">
            <input type="checkbox" name="active" id="active" value="y"
            <?php echo $data['active'] === 'y' ? 'checked' : ''; ?>/>
            <label for="active"><span></span>Active user</label>
         </div>
      </div>
      <!-- User PRIV -->
   <div class="form__group">
      <select id="priv" name="priv" class="form__select">
         <?php
         // Set an array contining user privilege levels
         $privArray = ['0' => 'User', '1' => 'Admin', '2' => 'Owner'];
         // display the values in the form
         foreach ($privArray as $key => $value) {
             echo "<option value={$key}";
             if ((string) $data['priv'] === (string) $key) {
                 echo " selected";
             }
             echo ">{$value}</option>";
         }
         ?>
      </select>
      <label for="priv">Privilege:</label>
   </div>
      
   </div>
   <div class="form__row">
      <input
         class="button"
         type="submit"
         value="Edit"
      >
     
   </div>
</form>
<!-- ~~~ EDIT FORM end ~~~ -->
