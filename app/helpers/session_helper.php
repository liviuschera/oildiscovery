<?php
// Flash message helper
// Example: flash('register_success, 'Your are registered');
// Display in View: echo flash('register_success');

function flash($name = '', $message = '', $class = 'form__alert-success')
{
    if (!empty($name)) {
        if (!empty($message) && empty($_SESSION[$name])) {
            if (!empty($_SESSION[$name])) {
                unset($_SESSION[$name]);
            }

            if (!empty($_SESSION[$name . '_class'])) {
                unset($_SESSION[$name . '_class']);
            }

            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;
        } elseif (empty($message) && !empty($_SESSION[$name])) {
            $class = !empty($_SESSION[$name . '_class'])
                ? $_SESSION[$name . '_class']
                : '';
            echo "<div class='{$class}'> {$_SESSION[$name]} </div>";
            unset($_SESSION[$name]);
            unset($_SESSION[$name . '_class']);
        }
    }
}

function isLoggedIn()
{
    return isset($_SESSION['login_user_id']) ? true : false;
}

function hasPrivLevel($priv_level = 0)
{
    return $_SESSION['login_user_priv'] >= $priv_level ? true : false;
}

function userHasAccess()
{
    if (!isLoggedIn() || !hasPrivLevel(1)) {
        redirectTo('users/login');
    }
}
