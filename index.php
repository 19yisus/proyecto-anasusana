<?php
  require_once("./models/config.php");
  require_once("./controller/c_messages.php");

  class App{
    private $ruta_actual, $code_error, $code_done, $titleContent, $controlador, $file_view_name, $ObjMessage;
    public $url;

    public function __construct(){
      session_set_cookie_params(0);
      session_start();
      $this->ObjMessage = new c_messages();
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

    private function NotFound404(){
      require_once("./views/contents/error/404.php");
    }

    private function Auth(){
      if(in_array($this->ruta_actual, constant("PRIVATE_URLS"))){
        if(!isset($_SESSION['user_id'])){
          $this->Redirect("auth/login","err/01AUTH");
        }

        if(isset($_SESSION['user_id'])){
          if($_SESSION['permisos'] == 1 && $this->file_view_name == "form") $this->Redirect($this->controlador.'/index',"err/08AUTH");
          if($_SESSION['permisos'] < 3 && $this->controlador == "usuarios" && $this->file_view_name == "index") $this->Redirect("inicio/index","err/08AUTH");
        }
      }
    }
    private function DateNow($param = ""){
      $unixTime = time();
      $timeZone = new \DateTimeZone('America/Caracas');

      $time = new \DateTime();
      $time->setTimestamp($unixTime)->setTimezone($timeZone);

      if($param == "") $fecha = $time->format('Y-m-d');
      else $fecha = $fecha = $time->format($param);

      return $fecha;
    }
    private function thisDateMoreOneHour(){
      $date = $this->DateNow("Y-m-d H:i");
      $fecha = new DateTime($this->DateNow("Y-m-d H:i"));
      $fecha->add(new dateInterval("PT1H"));
      return $fecha->format("Y-m-d\TH:i");
    }
    private function Redirect($view, $params){ header("Location: ".constant("URL")."$view/$params"); }

    private function GetRoute(){
      $url = isset($_GET['url']) ? $_GET['url'] : "inicio/index";
      $url = rtrim($url, '/');
      $url = explode('/', $url);
      $this->url = $url;
      
      if(sizeof($url) > 2 && $url[2] === "err") $this->code_error = $url[3];
      if(sizeof($url) > 2 && $url[2] === "msg") $this->code_done = $url[3];
      return $url;
    }

    private function SetURL($vista = ''){ 
      if($vista == '') echo constant("URL"). $this->controlador;
      else echo constant("URL"). $vista;
    }

    private function GetView($nameView){
      $this->file_view_name = (isset($nameView[1]) && $nameView[1] != "err" ? $nameView[1] : "index");
      $file_view_path = "./views/contents/".$nameView[0]."/vis_".$this->file_view_name.".php";
      if(file_exists($file_view_path)){
        $this->ruta_actual = $nameView[0]."/".$this->file_view_name;
        $this->controlador = $nameView[0];
        require_once($file_view_path);
      }else $this->NotFound404();
    }
  }

  $app = new App();
?>
