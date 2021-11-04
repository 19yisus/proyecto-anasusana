<?php
  require_once("./models/config.php");
  require_once("./controller/c_messages.php");

  class App{
    private $ruta_actual, $code_error, $code_done, $titleContent, $controlador;

    public function __construct(){
      session_start();
      $this->GetView($this->GetRoute());
    }

    private function IsActive($nameRoute){
      if(is_array($nameRoute) && in_array($this->ruta_actual, $nameRoute)) echo "active";
      if($nameRoute === $this->ruta_actual) echo "active";
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
          $this->Redirect("inicio/index","err/01AUTH");
        }
      }
      if(isset($this->code_error)){
        $ObjMessage = new c_messages();
        $ObjMessage->printError($this->code_error);
      }

      if(isset($this->code_done)){
        $ObjMessage = new c_messages();
        $ObjMessage->printMessage($this->code_done);
      }
    }

    private function Redirect($view, $params){ header("Location: ".constant("URL")."$view/$params"); }

    private function GetRoute(){
      $url = isset($_GET['url']) ? $_GET['url'] : "inicio/index";
      $url = rtrim($url, '/');
      $url = explode('/', $url);

      if(sizeof($url) > 2 && $url[2] === "err") $this->code_error = $url[3];
      if(sizeof($url) > 2 && $url[2] === "msg") $this->code_done = $url[3];
      return $url;
    }

    private function GetView($nameView){
      $vista = (isset($nameView[1]) ? $nameView[1] : "index");
      $file_view = "./views/contents/".$nameView[0]."/vis_".$vista.".php";
      if(file_exists($file_view)){
        $this->ruta_actual = $nameView[0]."/".$vista;
        $this->controlador = $nameView[0];
        require_once($file_view);
      }
    }
  }

  $app = new App();
?>
