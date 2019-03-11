<?php require APPROOT . '/views/includes/header.php'; ?>
<?php require APPROOT . '/views/includes/navbar.php'; ?>

<div class="facebook-login">

    <?php
    require_once VENDORROOT . 'autoload.php';
    $fb = new Facebook\Facebook([
        'app_id' => '548221059031502',
        'app_secret' => '78649 a9365addd45aa8cf0f7c90efbf6',
        'default_graph_version' => 'v2.2'
    ]);
    $helper = $fb->getRedirectLoginHelper(); // $permissions = [' email ']; // Optional permissions
    $loginUrl = $helper->getLoginUrl(
        ' http://localhost/oildiscovery//users/fb-callback.php'
    );
    ?>

    <a class="button button--login" href="<?php echo htmlspecialchars(
        $loginUrl
    ); ?>">
        Log in with
        <svg class="icon">
            <use href="<?php echo URLROOT; ?>/images/sprite.svg#icon-facebook"></use>
        </svg>acebook!</a>
</div>


<form action="<?php echo URLROOT; ?>/users/login" class="form u-div-center u-txt-align-center" method="post">
    <?php flash('register_success'); ?>
    <h3 class="h-2">Login</h3>

    <div class="form__row">
        <div class="form__group">
            <input type="email" class="form__input <?php echo !empty(
                $data['emailError']
            )
                ? 'form__invalid'
                : ''; ?>" value="<?php echo $data[
    'email'
]; ?>" placeholder="Email" name="email" />
            <span class="form__failed-feedback">
                <?php echo $data['emailError']; ?></span>
        </div>
        <div class="form__group">
            <input type="password" class="form__input <?php echo !empty(
                $data['passwError']
            )
                ? 'form__invalid'
                : ''; ?>" value="<?php echo $data[
    'passw'
]; ?>" placeholder="Enter password" name="passw" />
            <span class="form__failed-feedback">
                <?php echo $data['passwError']; ?></span>
        </div>
    </div>

    <div class="form__row">

        <input class="button" value="Login" type="submit">
        <a class="button" href="<?php echo URLROOT; ?>/users/register" type="submit">
            No account? Register
        </a>
</form>
<!-- ~~~ LOGIN FORM end ~~~ --> 