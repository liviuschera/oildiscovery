<?php

class Pages extends Controller
{
   public function __construct()
   {
      $this->pageModel = $this->model('Page');
   }
   
   public function index()
   {
      //   $pages = $this->pageModel->getPages();
      // $GLOBALS['pages'] = $this->pageModel->getPages();
      $_SESSION['pages'] = $this->pageModel->getPages();
      //   $data = [$_SESSION['pages'] => $pages];
      $this->view('/pages/index');
      //   $this->view('pages/index', $_SESSION['pages']);
   }
   
   public function about()
   {
      $this->view('pages/about');
   }
}
