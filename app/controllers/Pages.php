<?php

class Pages extends Controller
{
    public function __construct()
    {
        $this->postModel = $this->model('Post');
        $this->navbarModel = $this->model('Page');
    }

    public function index()
    {
        $posts = $this->postModel->getPosts(1);
        $data = ['posts' => $posts];

        //   $pages = $this->navbarModel->getPages();
        // $GLOBALS['pages'] = $this->navbarModel->getPages();
        $_SESSION['pages'] = $this->navbarModel->getNavbar();
        //   $data = [$_SESSION['pages'] => $pages];
        $this->view('/pages/index', $data);
        //   $this->view('pages/index', $_SESSION['pages']);
    }

    public function about()
    {
        $this->view('pages/about');
    }

    public function add()
    {
        userHasAccess();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize POST array
            // $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            var_dump($_POST);
            // var_dump($_FILES);
            $file_name = $_FILES['imgFile']['name'] ?? '';
            $file_temp = $_FILES['imgFile']['tmp_name'] ?? '';

            $data = [
                'order' => $_POST['order'],
                'menuactive' => !isset($_POST['menuactive']) ? 'n' : 'y',
                'active' => !isset($_POST['active']) ? 'n' : 'y',
                'priv' => trim($_POST['priv']),
                'title' => trim($_POST['title']),
                'menutitle' => trim($_POST['menutitle']),
                'imgName' => $file_name,
                'content' => trim($_POST['content']),
                'loggedUserId' => $_SESSION['login_user_id'],
                'postID' => '',
                'link' => '/pages/show/',
                'isBlogpost' => 'n',
                'titleError' => '',
                'menutitleError' => '',
                'imgError' => '',
                'contentError' => '',
                'orderError' => ''
            ];

            // Validate menu title
            if (empty($data['menutitle'])) {
                $data['menutitleError'] = 'Please enter menu title';
            }

            // Validate title
            if (empty($data['title'])) {
                $data['titleError'] = 'Please enter title';
            }

            // Validate navbar order
            if (((int)$data['order'] < 0) || ((int)$data['order'] > 127)) {
                $data['orderError'] = 'Chose a value between 0 - 127';
            }

            // Validate content
            if (empty($data['content'])) {
                $data['contentError'] = 'Please enter content';
            }

            // Validate image
            if (empty($file_name)) {
                $data['imgError'] = 'Please chose a file';
            } elseif ($this->postModel->findPostImageByImageName($file_name)) {
                $data['imgError'] = "$file_name is already taken.";
            } else {
                $target_file_path = PUBLICROOT . BLOG_IMG_DIR . $file_name;
                $file_type = strtolower(
                    pathinfo($target_file_path, PATHINFO_EXTENSION)
                );
                // Allow only certain extension types
                $image_mime_types = ['image/png', 'image/gif', 'image/jpeg'];
                $file_mime_type = mime_content_type($file_temp);

                if (in_array($file_mime_type, $image_mime_types)) {
                    // Upload image file to server
                    move_uploaded_file($file_temp, $target_file_path) ?? ($data['imgError'] = "The uploading of {$file_name} failed");
                } else {
                    $data['imgError'] =
                        "Only " .
                        implode(', ', $image_mime_types) .
                        " file types allowed.";
                }
            }

            if (
                empty($data['menutitleError']) &&
                empty($data['titleError']) &&
                empty($data['contentError']) &&
                empty($data['orderError']) &&
                empty($data['imgError'])
            ) {
                try {
                    // Insert image file name into database
                    // $this->postModel->addPost($data);
                    $this->navbarModel->addPage($data);
                    flash('post_message', "Menu and page content added");
                    redirectTo('');
                } catch (Throwable $e) {
                    $this->error = $e->getMessage();
                    echo "<strong>Throwable message:</strong> {$this->error}";
                }
            } else {
                // Load the view with errors
                $this->view('pages/add', $data);
            }
        } else {
            // Display the blank form
            $data = [
                'order' => '0',
                'menuactive' => !isset($_POST['menuactive']) ? 'n' : 'y',
                'active' => !isset($_POST['active']) ? 'n' : 'y',
                'priv' => '1',
                'title' => '',
                'menutitle' => '',
                'imgName' => '',
                'content' => '',
                'link' => '',
                'isBlogpost' => 'n',
                'imgError' => '',
                'titleError' => '',
                'menutitleError' => '',
                'contentError' => '',
                'orderError' => ''
            ];
        }

        $this->view('pages/add', $data);
    }

    public function edit($id)
    {
        userHasAccess();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize POST array
            // $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            var_dump($_POST);
            // var_dump($_FILES);
            $file_name = $_FILES['imgFile']['name'] ?? '';
            $file_temp = $_FILES['imgFile']['tmp_name'] ?? '';

            $data = [
                'order' => $_POST['order'],
                'menuactive' => !isset($_POST['menuactive']) ? 'n' : 'y',
                'active' => !isset($_POST['active']) ? 'n' : 'y',
                'priv' => trim($_POST['priv']),
                'title' => trim($_POST['title']),
                'menutitle' => trim($_POST['menutitle']),
                'imgName' => $file_name,
                'content' => trim($_POST['content']),
                'loggedUserId' => $_SESSION['login_user_id'],
                'postID' => $id,
                'link' => '/pages/show/',
                'isBlogpost' => 'n',
                'titleError' => '',
                'menutitleError' => '',
                'imgError' => '',
                'contentError' => '',
                'orderError' => ''
            ];

            // Validate menu title
            if (empty($data['menutitle'])) {
                $data['menutitleError'] = 'Please enter menu title';
            }

            // Validate title
            if (empty($data['title'])) {
                $data['titleError'] = 'Please enter title';
            }

            // Validate navbar order
            if (((int)$data['order'] < 0) || ((int)$data['order'] > 127)) {
                $data['orderError'] = 'Chose a value between 0 - 127';
            }

            // Validate content
            if (empty($data['content'])) {
                $data['contentError'] = 'Please enter content';
            }

            // Validate image
            if (!empty($file_name)) {
                if (
                    !empty($this->postModel->findPostImageByImageName($file_name)) &&
                    $this->postModel->findPostImageByImageName($file_name)
                    ->id !== $id
                ) {
                    $data['imgError'] = "$file_name is already taken.";
                } else {
                    $target_file_path = BLOG_IMG_DIR . $file_name;
                    $file_type = strtolower(
                        pathinfo($target_file_path, PATHINFO_EXTENSION)
                    );
                    // Allow only certain extension types
                    $image_mime_types = [
                        'image/png',
                        'image/gif',
                        'image/jpeg'
                    ];
                    $file_mime_type = mime_content_type($file_temp);

                    if (in_array($file_mime_type, $image_mime_types)) {
                        // Upload image file to server
                        move_uploaded_file($file_temp, $target_file_path) ?? ($data['imgError'] = "The uploading of {$file_name} failed");
                    } else {
                        $data['imgError'] =
                            "Only " .
                            implode(', ', $image_mime_types) .
                            " file types allowed.";
                    }
                }
            }

            if (
                empty($data['menutitleError']) &&
                empty($data['titleError']) &&
                empty($data['contentError']) &&
                empty($data['orderError']) &&
                empty($data['imgError'])
            ) {
                try {
                    // Insert image file name into database
                    // $this->postModel->addPost($data);
                    $this->navbarModel->updatePage($data);
                    flash('post_message', "Page edited");
                    redirectTo('');
                } catch (Throwable $e) {
                    $this->error = $e->getMessage();
                    echo "<strong>Throwable message:</strong> {$this->error}";
                }
            } else {
                // Load the view with errors
                $this->view('pages/edit', $data);
            }
        } else {
            // Check for owner
            $page = $this->navbarModel->getPageById($id);
            if ($page->userID !== $_SESSION['login_user_id']) {
                redirectTo('');
            }
            // Display the blank form
            $data = [
                'userID' => $page->userID,
                'postID' => $page->postID,
                'active' => $page->postActive,
                'menuactive' => $page->pageActive,
                'priv' => $page->postPriv,
                'title' => $page->title,
                'menutitle' => $page->pageTitle,
                'imgName' => $page->imgName,
                'content' => $page->content,
                'order' => $page->pageOrder,
                'link' => $page->pageLink,
                'isBlogpost' => 'n',
                'imgError' => '',
                'titleError' => '',
                'menutitleError' => '',
                'contentError' => '',
                'orderError' => ''
            ];
        }

        $this->view('pages/edit', $data);
    }


    public function show($id)
    {
        $post = $this->postModel->getPostById($id);
        $data = ['post' => $post];
        $this->view('pages/show', $data);
    }

    public function list(){
        userHasAccess(1);
        $page = $this->navbarModel->getAllPages();
        $data = ['page'=> $page];
        $this->view('pages/list', $data);
    }
}