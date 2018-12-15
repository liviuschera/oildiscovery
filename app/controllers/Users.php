<?php
class Users extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    // public function index()
    // {
    //     $this->view('users/login');
    // }

    public function register()
    {
        /*
     It will handle
        1. loading out forms if we go to register page
        2. when we submit the register form, when we submit
           the POST requests
         */

        // Check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process the form

            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            echo "naked post: " . var_dump($_POST);
            // Init data
            $data = [
                'first_name' => trim($_POST['first_name']) ?? '',
                'last_name' => trim($_POST['last_name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'first_name_error' => '',
                'last_name_error' => '',
                'email_error' => '',
                'phone_error' => '',
                'password_error' => '',
                'confirm_password_error' => ''
            ];
            echo "<pre> post init: " . var_dump($data) . "</pre>";

            // Validate first name
            if (empty($data['first_name'])) {
                $data['first_name_error'] = "Please enter first name.";
            }
            // Validate last name
            if (empty($data['last_name'])) {
                $data['last_name_error'] = "Please enter last name.";
            }

            // Validate email
            if (empty($data['email'])) {
                $data['email_error'] = "Please enter email.";
            } else {
                // Check if the email is unique
                if (!empty($this->userModel->findUserByEmail($data['email']))) {
                    $data['email_error'] = "Email is already taken.";
                }
            }

            // Validate phone
            if (empty($data['phone'])) {
                $data['phone_error'] = "Please enter phone.";
            }

            // Validate password
            if (empty($data['password'])) {
                $data['password_error'] = "Please enter password.";
            } elseif (strlen($data['password']) < 6) {
                $data['password_error'] =
                    "Password must be at least 6 charaters.";
            }

            // Validate confirm password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_error'] = "Please confirm password.";
            } else {
                if ($data['password'] !== $data['confirm_password']) {
                    $data['confirm_password_error'] = "Passwords do not match.";
                }
            }

            // Make sure errors are empty
            if (
                empty($data['first_name_error']) &&
                empty($data['last_name_error']) &&
                empty($data['email_error']) &&
                empty($data['phone_error']) &&
                empty($data['password_error']) &&
                empty($data['confirm_password_error'])
            ) {
                // Successfuly validated
                // Hash password
                $data['password'] = password_hash(
                    $data['password'],
                    PASSWORD_DEFAULT
                );

                // Register user
                if ($this->userModel->registerUser($data)) {
                    redirectTo('/users/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                echo "<pre>" . var_dump($data) . "</pre>";

                // Load view with errors
                $this->view('users/register', $data);
            }
        } else {
            // Init data
            $data = [
                'first_name' => '',
                'last_name' => '',
                'email' => '',
                'phone' => '',
                'password' => '',
                'confirm_password' => '',
                'first_name_error' => '',
                'last_name_error' => '',
                'email_error' => '',
                'phone_error' => '',
                'password_error' => '',
                'confirm_password_error' => ''
            ];

            // Load view;
            $this->view('users/register', $data);
        }
    }

    public function login()
    {
        // Check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process the form

            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            echo "naked post: " . var_dump($_POST);

            // Init data
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_error' => '',
                'password_error' => ''
            ];

            // Validate Email
            if (empty($data['email'])) {
                $data['email_error'] = 'Please enter email';
            }

            // Validate Password
            if (empty($data['password'])) {
                $data['password_error'] = 'Please enter password';
            }

            // Make sure errors are empty
            if (empty($data['email_error']) && empty($data['password_error'])) {
                // Validated
                die('SUCCESS');
            } else {
                // Load view with errors
                $this->view('users/login', $data);
            }
        } else {
            // Init data
            $data = [
                'email' => '',
                'password' => '',
                'email_error' => '',
                'password_error' => ''
            ];

            // Load view;
            $this->view('users/login', $data);
        }
    }
}
?>
