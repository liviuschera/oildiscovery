<?php require APPROOT . '/views/includes/header.php'; ?>
<?php require APPROOT . '/views/includes/navbar.php'; ?>

<!-- ~~~ REGISTRATION FORM start ~~~ -->

<form action="<?php echo URLROOT; ?>/users/register" class="form u-div-center u-txt-align-center" method="post" enctype="multipart/form-data">
    <h3 class="h-2">Create an account</h3>
    <p class="paragraph">Please fill out this form to register.</p>
    <div class="form__row">
        <div class="form__group">
            <input type="text" class="form__input <?php echo !empty(
                $data['firstNameError']
            )
                ? 'form__invalid'
                : ''; ?>" value="<?php echo $data[
    'firstName'
]; ?>" placeholder="First name" name="firstName" id="firstName" />
            <span class="form__failed-feedback">
                <?php echo $data['firstNameError']; ?></span>
        </div>
        <div class="form__group">
            <input type="text" class="form__input <?php echo !empty(
                $data['lastNameError']
            )
                ? 'form__invalid'
                : ''; ?>" value="<?php echo $data[
    'lastName'
]; ?>" placeholder="Last name" name="lastName" id="lastName" />
            <span class="form__failed-feedback">
                <?php echo $data['lastNameError']; ?></span>
        </div>
    </div>
    <div class="form__row">
        <div class="form__group">
            <input type="email" class="form__input <?php echo !empty(
                $data['emailError']
            )
                ? 'form__invalid'
                : ''; ?>" value="<?php echo $data[
    'email'
]; ?>" placeholder="Email" name="email" id="email" />
            <span class="form__failed-feedback">
                <?php echo $data['emailError']; ?></span>
        </div>
        <div class="form__group">
            <input type="tel" class="form__input <?php echo !empty(
                $data['phoneError']
            )
                ? 'form__invalid'
                : ''; ?>" value="<?php echo $data[
    'phone'
]; ?>" placeholder="Phone" name="phone" id="phone" />
            <span class="form__failed-feedback">
                <?php echo $data['phoneError']; ?></span>
        </div>
    </div>

    <div class="form__row">
        <div class="form__group">
            <input type="password" class="form__input <?php echo !empty(
                $data['passwError']
            )
                ? 'form__invalid'
                : ''; ?>" value="<?php echo $data[
    'passw'
]; ?>" placeholder="Password" name="passw" id="passw" />
            <span class="form__failed-feedback">
                <?php echo $data['passwError']; ?></span>
        </div>
        <div class="form__group">
            <input type="password" class="form__input <?php echo !empty(
                $data['confirmPasswError']
            )
                ? 'form__invalid'
                : ''; ?>" value="<?php echo $data[
    'confirmPassw'
]; ?>" placeholder="Confirm password" name="confirmPassw" id="confirmPassw" />
            <span class="form__failed-feedback">
                <?php echo $data['confirmPasswError']; ?></span>
        </div>
    </div>

    <!-- Add user IMAGE -->
    <div class="form__group u-mb-small">
        <input class="form__input" type="file" name="imgFile" id="imgFile" value="">
        <span class="form__failed-feedback">
            <?php echo $data['imgError']; ?></span>
    </div>

    <div class="form__row">
        <input class="button" type="submit" value="Register">
        <a class="button" href="<?php echo URLROOT; ?>/users/login" type="submit">
            Have an account? Login
        </a>
    </div>
</form>
<!-- ~~~ REGISTRATION FORM end ~~~ --> 