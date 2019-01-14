<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
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
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            // echo var_dump($_POST['active']);
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

    public function show($id)
    {
        $post = $this->postModel->getPostById($id);
        $data = ['post' => $post];
        $this->view('posts/show', $data);
    }
}
?>
