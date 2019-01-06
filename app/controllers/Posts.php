<?php
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
                'userId' => $_SESSION['user_id'],
                'activeError' => '',
                'privError' => '',
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

            if (empty($data['titleError'] && empty($data['contentError']))) {
                # code...
            } else {
                // Load the view with errors
                $this->view('post/add', $data);
            }
        } else {
            // Display the blank form
            $data = [
                'active' => !isset($_POST['active']) ? 'n' : 'y',
                'priv' => '0',
                'title' => '',
                'content' => '',
                'activeError' => '',
                'privError' => '',
                'titleError' => '',
                'contentError' => ''
            ];
        }

        $this->view('posts/add', $data);
    }
}
?>
