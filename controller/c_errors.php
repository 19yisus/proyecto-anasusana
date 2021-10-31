<?php
  class c_errors{
    private $list_errors = [
      '01AUTH' => "NO EXISTE SESSION ACTIVA",
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
  }
?>
