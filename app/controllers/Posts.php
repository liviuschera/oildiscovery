<?php

class Posts extends Controller
{
    public function __construct()
    {
        // if (!isLoggedIn()) {
        //     redirectTo('users/login');
        // }

        $this->postModel = $this->model('Post');
    }

    public function index()
    {
        // $offset = 0;
        // $maximum_number_of_rows_to_fetch = 0;
        // $page_count = ceil($_SESSION['row_count_posts'] / ROWS_PER_PAGE_POSTS);
        // $_SESSION['offset'] = 0;
        // $_SESSION['max_rows_limit'] = 0;
        // if (!isset($_POST['page']) || (int)$_POST['page'] == 1) {
        //     $offset = 0;
        //     $maximum_number_of_rows_to_fetch = ROWS_PER_PAGE_POSTS;
        // } elseif ($_SESSION['row_count_posts'] > ROWS_PER_PAGE_POSTS) {
        //     // $offset = $_POST['page'];
        //     $offset = $_SESSION['offset'];

        // }
        // var_dump((int)$_POST['page']);
        // $page_no = isset($_POST['page']) ? (int)$_POST['page'] : 0;
        // $posts = $this->postModel->getPosts($page_no);



        $offset = "";
        if (!isset($_POST['page']) || $_POST['page'] == '1') {
            $offset = 0;
        } else {
            $offset = (int)$_POST['page'];
        }
        $posts = $this->postModel->getPosts($offset);
        $data = ['posts' => $posts];

        $this->view('posts/index', $data);
    }

    public function add()
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
                'active' => !isset($_POST['active']) ? 'n' : 'y',
                'priv' => trim($_POST['priv']),
                'title' => trim($_POST['title']),
                'imgName' => $file_name,
                'content' => trim($_POST['content']),
                'loggedUserId' => $_SESSION['login_user_id'],
                'postID' => '',
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
                empty($data['titleError']) &&
                empty($data['contentError']) &&
                empty($data['imgError'])
            ) {
                try {
                    // Insert image file name into database
                    $this->postModel->addPost($data);
                    flash('post_message', "Post added.");
                    redirectTo('posts');
                } catch (Throwable $e) {
                    $this->error = $e->getMessage();
                    echo "<strong>Throwable message:</strong> {$this->error}";
                }
            } else {
                // Load the view with errors
                $this->view('posts/add', $data);
            }
        } else {
            // Display the blank form
            $data = [
                'active' => !isset($_POST['active']) ? 'n' : 'y',
                'priv' => '0',
                'title' => '',
                'imgName' => '',
                'content' => '',
                'imgError' => '',
                'titleError' => '',
                'contentError' => ''
            ];
        }

        $this->view('posts/add', $data);
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
            if (hasPrivLevel(1) || $post->userID === $_SESSION['login_user_id']) {
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
            } else {
                redirectTo('posts');
            }
        }

        $this->view('posts/edit', $data);
    }

    public function delete($id)
    {
        userHasAccess();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $post = $this->postModel->getPostById($id);
                $img_file = PUBLICROOT . BLOG_IMG_DIR . $post->imgName;
                if (is_writable($img_file)) {
                    unlink($img_file);
                }
                $this->postModel->deletePost($id);
                flash('post_message', "Post deleted");
                redirectTo('posts');
            } catch (Throwable $e) {
                $this->error = $e->getMessage();
                echo "<strong>Delete from post error:</strong> {$this->error}";
            }
        } else {
            redirectTo('posts');
        }
    }

    public function show($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
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

    public function comment($id)
    {
        userHasAccess();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init comment data
            $data = [
                'comment' => trim($_POST['comment']),
                'commentError' => ''
            ];

            // Validate comment
            if (empty($data['comment'])) {
                $data['commentError'] = "Please enter some text.";
            }

            // If comment is error free then:
            if (empty($data['commentError'])) {
                try {
                    // $this->postModel->addComment($id);
                    flash('post_message', "Comment added");
                    redirectTo('posts/show/' . $id);
                } catch (Throwable $e) {
                    echo "<strong>Failed to add comment:</strong> {$e->getMessage()}";
                }
            } else {
                // Load the views with errors
                $this->view('posts/show', $data);
            }
        } else {
            $data = [
                'comment' => '',
                'commentError' => ''
            ];

            // Load views
            $this->view('posts/show', $data);
        }
    }
}
