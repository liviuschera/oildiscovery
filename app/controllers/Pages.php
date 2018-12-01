<?php
class Pages extends Controller
{
    public function __construct()
    {
        $this->postModel = $this->model('Post');
    }

    public function index()
    {
        $data = ["title" => "Wellcome to Homepage"];
        $this->view('pages/index', $data);
    }

    public function about($param)
    {
        $this->view('pages/about');
    }
}
?>
