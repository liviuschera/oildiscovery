<?php
class Admins extends Controller
{
    public function __construct()
    {
        if (!isAdmin()) {
            redirectTo('users/login');
        }
    }

    public function index()
    {
        $this->view('admins/index');
    }
}
?>
