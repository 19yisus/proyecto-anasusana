<?php
  class c_messages{
    private $list_errors = [
      '01AUTH' => "NO EXISTE SESSION ACTIVA",
      '01ERR' => "Operacion fallida!",
    ];

    private $list_messages = [
      '01DONE' => "Operacion exitosa!",
    ];

    public function printError($indexError){
      foreach($this->list_errors as $error => $key){
        if($indexError === $error){
          ?>
          <script>
            alert("<?php echo $key; ?>")
          </script>
          <?php
        }
      }
    }

    public function printMessage($indexMessage){
      foreach($this->list_messages as $msg => $key){
        if($indexMessage === $msg){
          ?>
          <script>
            alert("<?php echo $key; ?>")
          </script>
          <?php
        }
      }
    }
  }
?>
