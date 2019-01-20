<?php
class Users extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function index()
    {
        $data = ["title" => "Wellcome to Homepage"];
        $this->view('pages/index', $data);
    }

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

            // echo "naked post: " . var_dump($_POST);
            // Init data
            $data = [
                'firstName' => trim($_POST['firstName']),
                'lastName' => trim($_POST['lastName']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'passw' => trim($_POST['passw']),
                'confirmPassw' => trim($_POST['confirmPassw']),
                'firstNameError' => '',
                'lastNameError' => '',
                'emailError' => '',
                'phoneError' => '',
                'passwError' => '',
                'confirmPasswError' => ''
            ];
            // echo "<pre> post init: " . var_dump($data) . "</pre>";

            // Validate first name
            if (empty($data['firstName'])) {
                $data['firstNameError'] = "Please enter first name.";
            }
            // Validate last name
            if (empty($data['lastName'])) {
                $data['lastNameError'] = "Please enter last name.";
            }

            // Validate email
            if (empty($data['email'])) {
                $data['emailError'] = "Please enter email.";
            } else {
                // Check if the email is unique
                if (!empty($this->userModel->findUserByEmail($data['email']))) {
                    $data['emailError'] = "Email is already taken.";
                }
            }

            // Validate phone
            if (empty($data['phone'])) {
                $data['phoneError'] = "Please enter phone.";
            }

            // Validate passw
            if (empty($data['passw'])) {
                $data['passwError'] = "Please enter passw.";
            } elseif (strlen($data['passw']) < 6) {
                $data['passwError'] = "passw must be at least 6 charaters.";
            }

            // Validate confirm passw
            if (empty($data['confirmPassw'])) {
                $data['confirmPasswError'] = "Please confirm passw.";
            } else {
                if ($data['passw'] !== $data['confirmPassw']) {
                    $data['confirmPasswError'] = "passws do not match.";
                }
            }

            // Make sure errors are empty
            if (
                empty($data['firstNameError']) &&
                empty($data['lastNameError']) &&
                empty($data['emailError']) &&
                empty($data['phoneError']) &&
                empty($data['passwError']) &&
                empty($data['confirmPasswError'])
            ) {
                // Successfuly validated
                // Hash the password
                $data['passw'] = password_hash(
                    $data['passw'],
                    PASSWORD_DEFAULT
                );

                // Register user
                try {
                    $this->userModel->registerUser($data);
                    flash(
                        'register_success',
                        'You are registered and can log in now'
                    );
                    redirectTo('users/login');
                } catch (Exception $e) {
                    $this->error = $e->getMessage();
                    echo "<strong>Error message:</strong> {$this->error}";
                }
            } else {
                // Load view with errors
                $this->view('users/register', $data);
            }
        } else {
            // Init data
            $data = [
                'firstName' => '',
                'lastName' => '',
                'email' => '',
                'phone' => '',
                'passw' => '',
                'confirmPassw' => '',
                'firstNameError' => '',
                'lastNameError' => '',
                'emailError' => '',
                'phoneError' => '',
                'passwError' => '',
                'confirmPasswError' => ''
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
            // echo "fitered post: " . var_dump($_POST);

            // Init data
            $data = [
                'email' => trim($_POST['email']),
                'passw' => trim($_POST['passw']),
                'emailError' => '',
                'passwError' => ''
            ];

            // Validate Email
            if (empty($data['email'])) {
                $data['emailError'] = 'Please enter email';
            }

            // Validate password
            if (empty($data['passw'])) {
                $data['passwError'] = 'Please enter passw';
            }

            // Check for user/email
            if ($this->userModel->findUserByEmail($data['email'])) {
                // User found
            } else {
                // User not found
                $data['emailError'] = 'No user found';
            }

            // Make sure errors are empty
            if (empty($data['emailError']) && empty($data['passwError'])) {
                // Validated
                // Check and set logged in user
                $loggedInUser = $this->userModel->login(
                    $data['email'],
                    $data['passw']
                );

                if ($loggedInUser) {
                    // Create session
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['passwError'] = 'Password incorrect';
                    $this->view('users/login', $data);
                }
            } else {
                // Load view with errors
                $this->view('users/login', $data);
            }
        } else {
            // Init data
            $data = [
                'email' => '',
                'passw' => '',
                'emailError' => '',
                'passwError' => ''
            ];

            // Load view;
            $this->view('users/login', $data);
        }
    }

    public function createUserSession($user)
    {
        $_SESSION['login_user_id'] = $user->id;
        $_SESSION['login_user_priv'] = $user->priv;
        $_SESSION['login_user_email'] = $user->email;
        $_SESSION['login_user_name'] = $user->firstName;
        redirectTo('posts');
    }

    public function logout()
    {
        unset($_SESSION['login_user_id']);
        unset($_SESSION['login_user_priv']);
        unset($_SESSION['login_user_email']);
        unset($_SESSION['login_user_name']);
        session_destroy();
        redirectTo('users/login');
    }
}
?>
