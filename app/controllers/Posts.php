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
        $data = [
            'active' => '',
            'priv' => '',
            'title' => '',
            'content' => '',
            'activeError' => '',
            'privError' => '',
            'titleError' => '',
            'contentError' => ''
        ];

        $this->view('posts/add', $data);
    }
}
?>
