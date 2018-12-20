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

            // echo "naked post: " . var_dump($_POST);
            // Init data
            $data = [
                'first_name' => trim($_POST['first_name']) ?? '',
                'last_name' => trim($_POST['last_name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'passw' => trim($_POST['passw']),
                'confirm_passw' => trim($_POST['confirm_passw']),
                'first_name_error' => '',
                'last_name_error' => '',
                'email_error' => '',
                'phone_error' => '',
                'passw_error' => '',
                'confirm_passw_error' => ''
            ];
            // echo "<pre> post init: " . var_dump($data) . "</pre>";

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

            // Validate passw
            if (empty($data['passw'])) {
                $data['passw_error'] = "Please enter passw.";
            } elseif (strlen($data['passw']) < 6) {
                $data['passw_error'] = "passw must be at least 6 charaters.";
            }

            // Validate confirm passw
            if (empty($data['confirm_passw'])) {
                $data['confirm_passw_error'] = "Please confirm passw.";
            } else {
                if ($data['passw'] !== $data['confirm_passw']) {
                    $data['confirm_passw_error'] = "passws do not match.";
                }
            }

            // Make sure errors are empty
            if (
                empty($data['first_name_error']) &&
                empty($data['last_name_error']) &&
                empty($data['email_error']) &&
                empty($data['phone_error']) &&
                empty($data['passw_error']) &&
                empty($data['confirm_passw_error'])
            ) {
                // Successfuly validated
                // Hash the password
                $data['passw'] = password_hash(
                    $data['passw'],
                    PASSWORD_DEFAULT
                );

                // Register user
                try {
                    if ($this->userModel->registerUser($data)) {
                        redirectTo('users/login');
                    }
                    //  else {
                    //     die('Something went wrong');
                    // }
                    $this->userModel->registerUser($data);
                } catch (Exception $e) {
                    // } catch (PDOException $e) {
                    $this->error = $e->getMessage();
                    $this->code = $e->getCode();
                    if ($this->code === '23000') {
                        redirectTo('users/login');
                    }
                    echo "<strong>Error message:</strong> {$this->error}";
                }
            } else {
                // echo "<pre> view with errors" . var_dump($data) . "</pre>";

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
                'passw' => '',
                'confirm_passw' => '',
                'first_name_error' => '',
                'last_name_error' => '',
                'email_error' => '',
                'phone_error' => '',
                'passw_error' => '',
                'confirm_passw_error' => ''
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
                'email_error' => '',
                'passw_error' => ''
            ];

            // Validate Email
            if (empty($data['email'])) {
                $data['email_error'] = 'Please enter email';
            }

            // Validate passw
            if (empty($data['passw'])) {
                $data['passw_error'] = 'Please enter passw';
            }

            // Make sure errors are empty
            if (empty($data['email_error']) && empty($data['passw_error'])) {
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
                'passw' => '',
                'email_error' => '',
                'passw_error' => ''
            ];

            // Load view;
            $this->view('users/login', $data);
        }
    }
}
?>
