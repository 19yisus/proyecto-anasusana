<?php
  require_once("./models/config.php");
  require_once("./controller/c_errors.php");

  class App{
    private $ruta_actual, $code_error;

    public function __construct(){
      session_start();
      $ruta = $this->GetRoute();
      $this->GetView($ruta[0]);
    }

    private function GetHeader(){
      $this->Auth();
      include_once("./views/includes/header.php");
    }

    private function GetComplement($name){
      $ruta = "./views/includes/$name.php";
      if(file_exists($ruta)) require_once("./views/includes/$name.php");
    }

    private function Auth(){
      if(in_array($this->ruta_actual, constant("PRIVATE_URLS"))){
        if(!isset($_SESSION['id_username'])){
          header("Location: ".constant("URL")."inicio/err/01AUTH");
        }
      }
      if(isset($this->code_error)){
        $objError = new c_errors();
        $objError->printError($this->code_error);
      }
    }

    private function GetRoute(){
      $url = isset($_GET['url']) ? $_GET['url'] : "inicio";
      $url = rtrim($url, '/');
      $url = explode('/', $url);

      if(sizeof($url) > 1 && $url[1] == "err") $this->code_error = $url[2];
      return $url;
    }

    private function GetView($nameView){
      $file_view = "./views/contents/vis_$nameView.php";
      if(file_exists($file_view)){
        $this->ruta_actual = $nameView;
        require_once($file_view);
      }
    }
  }

  $app = new App();
?>
