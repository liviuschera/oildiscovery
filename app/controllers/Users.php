<?php

class Users extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('User');
    }
   
    public function index()
    {
        $fb = initFacebook();
        $helper = $fb->getRedirectLoginHelper();
        // if (isset($_GET['state'])) {
        //     $helper->getPersistentDataHandler()->set('state', $_GET['state']);
        // }
        try {
            $accessToken = $helper->getAccessToken();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit();
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit();
        }
      
        if (!isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " .
               $helper->getErrorDescription() .
               "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit();
        }
      
        // Logged in
        echo '<h3>Access Token</h3>';
        // var_dump($accessToken->getValue());
      
        // The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();
      
        // Get the access token metadata from /debug_token
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
        echo '<h3 class="h-4">Metadata</h3>';
        // var_dump($tokenMetadata);
      
        // Validation (these will throw FacebookSDKException's when they fail)
      $tokenMetadata->validateAppId(FB_APP_ID); // Replace 548221059031502 with your app id
      // If you know the user ID this access token belongs to, you can validate it here
      //$tokenMetadata->validateUserId('123');
      $tokenMetadata->validateExpiration();
      
        if (!$accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken(
                    $accessToken
            );
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                echo "<p ='paragraph'>Error getting long-lived access token: " .
               $e->getMessage() .
               "</p>\n\n";
                exit();
            }
         
            echo '<h3 class="h-4>Long-lived</h3>';
            var_dump($accessToken->getValue());
        }
      
        $_SESSION['fb_access_token'] = (string)$accessToken;
        // User is logged in with a long-lived access token.
        // You can redirect them to a members-only page.
        //header('Location: https://example.com/members.php');
        try {
            // Returns a `Facebook\FacebookResponse` object
            // $response = $fb->get('/me/feed', $_SESSION['fb_access_token']);
            $response = $fb->get(
                '/me?fields=id,name,email,cover,gender,picture,link,friends,posts',
                $_SESSION['fb_access_token']
         );
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit();
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit();
        }
        $user = $response->getGraphUser();
        $_SESSION['fb_user_id'] = $user->getId();
        $_SESSION['fb_user_email'] = $user->getEmail();
        $_SESSION['fb_user_name'] = $user->getName() ?? '';
        $_SESSION['fb_user_fname'] = $user->getFirstName() ?? '';
        $_SESSION['fb_user_lname'] = $user->getLastName() ?? '';
        $_SESSION['fb_user_picture'] = $user->getPicture() ?? '';
      
        
        var_dump($user);
        var_dump($user['picture']);
        var_dump($user->getName());
        var_dump($user->getFirstName());
        var_dump($user->getLink());
        var_dump($user->getPicture());
        if ($_SESSION['fb_access_token']) {
            redirectTo('pages');
            header('Location: ' . URLROOT . '/pages');
        }
        $data = [
         'title' => 'Index title'
      ];
        $this->view('users/index', $data);
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
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            // var_dump($_POST);
            // var_dump($_FILES);
            $file_name = $_FILES['imgFile']['name'] ?? '';
            $file_temp = $_FILES['imgFile']['tmp_name'] ?? '';
            // Init data
            $data = [
            'active' => !isset($_POST['active']) ? 'n' : 'y',
            'firstName' => trim($_POST['firstName']),
            'lastName' => trim($_POST['lastName']),
            'email' => trim($_POST['email']),
            'phone' => trim($_POST['phone']),
            'passw' => trim($_POST['passw']),
            'confirmPassw' => trim($_POST['confirmPassw']),
            'imgName' => $file_name,
            'firstNameError' => '',
            'lastNameError' => '',
            'emailError' => '',
            'phoneError' => '',
            'passwError' => '',
            'confirmPasswError' => '',
            'imgError' => ''
         ];
         
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
                $data['passwError'] = "passw must be at least 6 characters.";
            }
         
            // Validate confirm passw
            if (empty($data['confirmPassw'])) {
                $data['confirmPasswError'] = "Please confirm passw.";
            } else {
                if ($data['passw'] !== $data['confirmPassw']) {
                    $data['confirmPasswError'] = "Password do not match.";
                }
            }
         
            // Validate image
            if (empty($file_name)) {
                $data['imgError'] = 'Please chose a file';
            } elseif ($this->userModel->findUserImageByImageName($file_name)) {
                $data['imgError'] = "$file_name is already taken.";
            } else {
                $target_file_path = USER_IMG_DIR . $file_name;
            
                // Allow only certain extension types
                $image_mime_types = ['image/png', 'image/gif', 'image/jpeg'];
                $file_mime_type = mime_content_type($file_temp);
            
                if (in_array($file_mime_type, $image_mime_types)) {
                    // Upload image file to server
                    move_uploaded_file($file_temp, $target_file_path) ??
               ($data['imgError'] = "The uploading of {$file_name} failed");
                } else {
                    $data['imgError'] =
                  "Only " .
                  implode(', ', $image_mime_types) .
                  " file types allowed.";
                }
            }
         
            // Make sure errors are empty
            if (
            empty($data['firstNameError']) &&
            empty($data['lastNameError']) &&
            empty($data['emailError']) &&
            empty($data['phoneError']) &&
            empty($data['passwError']) &&
            empty($data['confirmPasswError']) &&
            empty($data['imgError'])
         ) {
                // Successfully validated
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
            'active' => !isset($_POST['active']) ? 'n' : 'y',
            'firstName' => '',
            'lastName' => '',
            'email' => '',
            'phone' => '',
            'passw' => '',
            'confirmPassw' => '',
            'imgName' => '',
            'firstNameError' => '',
            'lastNameError' => '',
            'emailError' => '',
            'phoneError' => '',
            'passwError' => '',
            'confirmPasswError' => '',
            'imgError' => ''
         ];
         
            // Load view;
            $this->view('users/register', $data);
        }
    }
   
    public function edit($id)
    {
        // Check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process the form
         
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            // var_dump($_POST);
            // var_dump($_FILES);
            $file_name = $_FILES['imgFile']['name'] ?? '';
            $file_temp = $_FILES['imgFile']['tmp_name'] ?? '';
            // Init data
            $data = [
            'active' => $_POST['active'],
            'id' => $id,
            'firstName' => trim($_POST['firstName']),
            'lastName' => trim($_POST['lastName']),
            'email' => trim($_POST['email']),
            'phone' => trim($_POST['phone']),
            'passw' => trim($_POST['passw']),
            'confirmPassw' => trim($_POST['confirmPassw']),
            'priv' => trim($_POST['priv']),
            'imgName' => $file_name,
            'firstNameError' => '',
            'lastNameError' => '',
            'emailError' => '',
            'phoneError' => '',
            'passwError' => '',
            'confirmPasswError' => '',
            'imgError' => ''
         ];
         
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
                $check_if_email_exists = $this->userModel->findUserByEmail(
                    $data['email']
            );
                if ($id !== $check_if_email_exists->id) {
                    $data['emailError'] = "Email is already taken.";
                }
            }
            // !empty($check_if_email_exists) &&
         
            // Validate phone
            if (empty($data['phone'])) {
                $data['phoneError'] = "Please enter phone.";
            }
         
            // Validate password
            if (empty($data['passw'])) {
                $data['passwError'] = "Please enter passw.";
            } elseif (strlen($data['passw']) < 6) {
                $data['passwError'] = "passw must be at least 6 charaters.";
            }
         
            // Validate confirm password
            if (empty($data['confirmPassw'])) {
                $data['confirmPasswError'] = "Please confirm passw.";
            } else {
                if ($data['passw'] !== $data['confirmPassw']) {
                    $data['confirmPasswError'] = "passws do not match.";
                }
            }
            // Validate image
            if (!empty($file_name)) {
                if (
               !empty(
               $this->userModel->findUserImageByImageName($file_name)
               ) &&
               $this->userModel->findUserImageByImageName($file_name)
                  ->id !== $id
            ) {
                    $data['imgError'] = "$file_name is already taken.";
                } else {
                    $target_file_path = USER_IMG_DIR . $file_name;
               
                    // Allow only certain extension types
                    $image_mime_types = [
                  'image/png',
                  'image/gif',
                  'image/jpeg'
               ];
                    $file_mime_type = mime_content_type($file_temp);
               
                    if (in_array($file_mime_type, $image_mime_types)) {
                        // Upload image file to server
                        move_uploaded_file($file_temp, $target_file_path) ??
                  ($data['imgError'] = "The uploading of {$file_name} failed");
                    } else {
                        $data['imgError'] =
                     "Only " .
                     implode(', ', $image_mime_types) .
                     " file types allowed.";
                    }
                }
            }
            // Make sure errors are empty
            if (
            empty($data['firstNameError']) &&
            empty($data['lastNameError']) &&
            empty($data['emailError']) &&
            empty($data['phoneError']) &&
            empty($data['passwError']) &&
            empty($data['confirmPasswError']) &&
            empty($data['imgError'])
         ) {
                // Successfully validated
            
                // Don't hash the password if user didn't changed it
                if ($_SESSION['user_edit_passw'] !== $data['passw']) {
                    // Hash the password if changed
                    $data['passw'] = password_hash(
                        $data['passw'],
                        PASSWORD_DEFAULT
               );
                }
            
                // Register user
                try {
                    $this->userModel->editUser($data);
                    flash('user_message', 'Updated user info successfully');
                    redirectTo('users/search');
                } catch (Exception $e) {
                    $this->error = $e->getMessage();
                    echo "<strong>Error message:</strong> {$this->error}";
                }
            } else {
                // Load view with errors
                $this->view('users/edit', $data);
            }
        } else {
            // Find user
            $user = $this->userModel->getUserById($id);
         
            // Check for if user has the right to edit
            if (
            $_SESSION['login_user_priv'] < $user->priv ??
            $user->id !== $_SESSION['login_user_id']
         ) {
                redirectTo('users/login');
            }
         
            // if ($_SESSION['login_user_priv'] < $user->priv) {
            //     if ($user->id !== $_SESSION['login_user_id']) {
            //         redirectTo('users/login');
            //     }
            // }
            // Init data
            $data = [
            'id' => $id,
            'firstName' => $user->firstName,
            'lastName' => $user->lastName,
            'email' => $user->email,
            'phone' => $user->phone,
            'priv' => $user->priv,
            'active' => $user->active,
            'passw' => $user->passw,
            'confirmPassw' => $user->passw,
            'imgName' => $user->img_name,
            'firstNameError' => '',
            'lastNameError' => '',
            'emailError' => '',
            'phoneError' => '',
            'passwError' => '',
            'confirmPasswError' => '',
            'imgError' => ''
         ];
            $_SESSION['user_edit_passw'] = $user->passw;
         
            // Load view;
            $this->view('users/edit', $data);
        }
    }
   
    public function login()
    {
        // Check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process the form
         
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
         
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
                'passwError' => '',
                'fb_token' => $_SESSION['fb_access_token'] ?? 'No Facebook token'
            ];
         
            // Load view;
            $this->view('users/login', $data);
        }
    }
   
    public function search()
    {
        userHasAccess();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
         
            if (isset($_POST['search'])) {
                $_SESSION['search'] = $_POST['search'];
            }
         
            $data = [
            'keyword' =>
               $_POST['search'] ??
               trim($_POST['search'] ?? $_SESSION['search']),
            'offset' => $_POST['page'] ?? 0
         ];
         
            $search_result = $this->userModel->searchUsers($data);
            $this->view('users/search', $search_result);
        } else {
            $this->view('users/search');
        }
    }
   
    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $user = $this->userModel->getUserById($id);
                $img_file = PUBLICROOT . USER_IMG_DIR . $user->img_name;
                if (is_writable($img_file)) {
                    unlink($img_file);
                }
                $this->userModel->deleteUser($id);
                flash('user_message', "User deleted");
                redirectTo('users/search');
            } catch (Throwable $e) {
                $this->error = $e->getMessage();
                echo "<strong>Delete from users error:</strong> {$this->error}";
            }
        } else {
            redirectTo('users/search');
        }
    }
   
    public function createUserSession($user)
    {
        $_SESSION['login_user_id'] = $user->id;
        $_SESSION['login_user_priv'] = $user->priv;
        $_SESSION['login_user_email'] = $user->email;
        $_SESSION['login_user_fname'] = $user->firstName;
        $_SESSION['login_user_lname'] = $user->lastName;
        redirectTo('posts');
    }
   
    public function logout()
    {
        if (isset($_SESSION['fb_access_token'])) {
            $url =
            'https://www.facebook.com/logout.php?next=' .
            URLROOT .
            '&access_token=' .
            $_SESSION['fb_access_token'];
            unset($_SESSION['fb_access_token']);
            session_destroy();
            header('Location: ' . $url);
        } else {
            unset($_SESSION['login_user_id']);
            unset($_SESSION['login_user_priv']);
            unset($_SESSION['login_user_email']);
            unset($_SESSION['login_user_fname']);
            unset($_SESSION['login_user_lname']);
            session_destroy();
            redirectTo('pages');
        }
    }
}
