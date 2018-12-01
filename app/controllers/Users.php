<?php
class Users
{
    public function __constructor()
    {
    }

    public function register()
    {
        /*
     It will handle
        1. loading out forms if we go to register page
        2. the submit the register form, when we submit
           the POST requests
       */

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process the form
        } else {
            // Load the form
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_error' => '',
                'email_error' => '',
                'confirm_password_error' => ''
            ];

            // Load view;
            $this->view('users/register', $data);
        }
    }
}
?>
