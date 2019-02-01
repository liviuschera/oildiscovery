<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
class Posts extends Controller
{
    public function __construct()
    {
        if (!isLoggedIn()) {
            redirectTo('users/login');
        }

        $this->postModel = $this->model('Post');
    }

    public function index()
    {
        // Get posts
        $posts = $this->postModel->getPosts();

        $data = ['posts' => $posts];

        $this->view('posts/index', $data);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize POST array
            // $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            var_dump($_POST);
            $data = [
                'active' => !isset($_POST['active']) ? 'n' : 'y',
                'priv' => trim($_POST['priv']),
                'title' => trim($_POST['title']),
                'content' => trim($_POST['content']),
                'loggedUserId' => $_SESSION['login_user_id'],
                'postID' => '',
                'titleError' => '',
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

            if (empty($data['titleError']) && empty($data['contentError'])) {
                try {
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
                'content' => '',
                'titleError' => '',
                'contentError' => ''
            ];
        }

        $this->view('posts/add', $data);
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'active' => $_POST['active'],
                'priv' => $_POST['priv'],
                'title' => trim($_POST['title']),
                'content' => trim($_POST['content']),
                'loggedUserId' => $_SESSION['login_user_id'],
                'postID' => $id,
                'titleError' => '',
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

            // If there are no errors update the post
            if (empty($data['titleError']) && empty($data['contentError'])) {
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
                'content' => $post->content,
                'titleError' => '',
                'contentError' => ''
            ];
        }

        $this->view('posts/edit', $data);
    }

    public function show($id)
    {
        $post = $this->postModel->getPostById($id);
        $data = ['post' => $post];
        $this->view('posts/show', $data);
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
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
}
?>
