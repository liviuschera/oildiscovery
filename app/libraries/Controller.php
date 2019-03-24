<?php
// Base Controller - loads the models and views

class Controller
{
   // loads a model file and instantiate the model object
   public function model($model)
   {
      // require the model file
      require_once "../app/models/{$model}.php";
      
      // instantiate the model
      return new $model();
   }
   
   // loads a view file and instantiate the view object
   public function view($view, $data = [])
   {
      // check for the view file
      if (file_exists("../app/views/{$view}.php")) {
         require_once "../app/views/{$view}.php";
      } else {
         // view does not exist so show msg and exit
         die("<p>View <strong>{$view}</strong> does not exist!</p>");
      }
   }
}

?>
