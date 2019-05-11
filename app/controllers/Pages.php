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
        //   $pages = $this->navbarModel->getPages();
        // $GLOBALS['pages'] = $this->navbarModel->getPages();
        $_SESSION['pages'] = $this->navbarModel->getNavbar();
        //   $data = [$_SESSION['pages'] => $pages];
        $this->view('/pages/index');
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
            'link' => '/pages/' . makeLinkSEOFriendly($_POST['menutitle']),
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
            // var_dump($_POST);
            // var_dump($_FILES);
            $file_name = $_FILES['imgFile']['name'] ?? '';
            $file_temp = $_FILES['imgFile']['tmp_name'] ?? '';
            $data = [
            // 'active' => $_POST['active'],
            'active' => !isset($_POST['active']) ? 'n' : 'y',
            'priv' => $_POST['priv'],
            'title' => trim($_POST['title']),
            'imgName' => $file_name,
            'content' => trim($_POST['content']),
            'loggedUserId' => $_SESSION['login_user_id'],
            'postID' => $id,
            'titleError' => '',
            'imgError' => '',
            'contentError' => ''
         ];

            // Validate title
            if (empty($data['title'])) {
                $data['titleError'] = 'Please enter title';
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

            // If there are no errors update the post
            if (
            empty($data['titleError']) &&
            empty($data['contentError']) &&
            empty($data['imgError'])
         ) {
                try {
                    $this->postModel->updatePost($data);
                    flash('post_message', "Post updated");
                    redirectTo('posts');
                } catch (Throwable $e) {
                    $this->error = $e->getMessage();
                    echo "<strong>Throwable message:</strong> {$this->error}";
                }
            } else {
                // Load the view with errors
                $this->view('posts/edit', $data);
            }
        } else {
            // Check for owner
            $post = $this->postModel->getPostById($id);
            if ($post->userID !== $_SESSION['login_user_id']) {
                redirectTo('posts');
            }
            // Display the blank form
            $data = [
            'userID' => $post->userID,
            'postID' => $post->postID,
            'active' => $post->postActive,
            'priv' => $post->postPriv,
            'title' => $post->title,
            'imgName' => $post->imgName,
            'content' => $post->content,
            'titleError' => '',
            'imgError' => '',
            'contentError' => ''
         ];
        }

        $this->view('posts/edit', $data);
    }

    public function show($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // if (isset($_POST['comment'])) {
            $post = $this->postModel->getPostById($id);
            // Init comment data
            $data = [
            'post' => $post
         ];
            $data['post']->comment = trim($_POST['comment']);
            $data['post']->commentError = '';

            // Validate comment
            if (empty($data['post']->comment)) {
                $data['post']->commentError = "Please enter some text.";
                // $data['commentError'] = "Please enter some text.";
            }

            // If comment is error free then:
            if (empty($data['post']->commentError)) {
                // if (empty($data['commentError'])) {
                try {
                    $this->postModel->addComment($data);
                    flash('post_message', "Comment added");
                    redirectTo('posts/show/' . $data['post']->postID);
                } catch (Throwable $e) {
                    echo "<strong>Failed to add comment:</strong> {$e->getMessage()}";
                }
            } else {
                // Load the views with errors

                $this->view('posts/show', $data);
            }
        } else {
            $comments = $this->postModel->getCommentsByPostId($id);
            $post = $this->postModel->getPostById($id);
            $data = [
            'post' => $post,
            'comments' => $comments
         ];
            $this->view('posts/show', $data);
        }
    }
}