<?php require APPROOT . '/views/includes/header.php'; ?>
<?php require APPROOT . '/views/includes/navbar.php'; ?>




<form action="<?php echo URLROOT; ?>/users/login"
    class="form u-div-center u-txt-align-center" method="post">
    <?php flash('register_success'); ?>
    <h3 class="h-2">Login with Email</h3>

    <div class="form__row">
        <div class="form__group">
            <input type="email" class="form__input <?php echo !empty(
            $data['emailError']
            )
               ? 'form__invalid'
               : ''; ?>"
                value="<?php echo $data['email']; ?>"
                placeholder="Email" name="email" />
            <span class="form__failed-feedback">
                <?php echo $data['emailError']; ?></span>
        </div>
        <div class="form__group">
            <input type="password" class="form__input <?php echo !empty(
            $data['passwError']
            )
               ? 'form__invalid'
            : ''; ?>"
                value="<?php echo $data['passw']; ?>"
                placeholder="Enter password" name="passw" id="passw" />
            <span class="form__failed-feedback">
                <?php echo $data['passwError']; ?></span>
        </div>
    </div>

    <div class="form__row">

        <input class="button" value="Login" type="submit">
        <a class="button"
            href="<?php echo URLROOT; ?>/users/register"
            type="submit">
            No account? Register
        </a>
</form>
<!-- ~~~ LOGIN FORM end ~ ~~ -->