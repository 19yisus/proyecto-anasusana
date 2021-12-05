<?php
  require("m_db.php");

  class m_auth extends m_db{
    private $user_id, $password;

    public function __construct(){
      parent::__construct();
      $this->user_id = null;
      $this->password = null;
    }
    
    public function SetDatos($d){
      $this->user_id = isset($d['user_id']) ? $d['user_id'] : null;
      $this->password = isset($d['password']) ? $d['password'] : null;
    }
    
    public function Login(){
      $res = $this->Query("SELECT * FROM personas 
      INNER JOIN usuarios ON usuarios.person_id_user = personas.id_person 
      INNER JOIN roles_usuario ON roles_usuario.id = usuarios.id_rol
      WHERE personas.cedula_person = $this->user_id ;");
      if($res->num_rows > 0){
        $datos = $this->Get_array($res);
        if($datos['status_user'] === "0") return [false,"err/06AUTH"];

        if(password_verify($this->password, $datos['password_user'])){
          session_start();
          $_SESSION['user_id'] = $datos['id_user'];
          $_SESSION['cedula'] = $datos['cedula_person'];
          $_SESSION['username'] = $datos['nom_person'];
          $_SESSION['permisos'] = $datos['nivel_permisos_rol'];
          
          return [true,'msg/01AUTH'];
        }else return [false,'err/07AUTH'];
      }
      else return [false,"err/05AUTH"];
      
    }

    public function Register_user(){
      // Comprobamos que la persona ya este registrada en la base de datos
      $res = $this->Query("SELECT id_person,if_user FROM personas WHERE cedula_person = $this->user_id;");

      if($res->num_rows > 0){
        // Comprobamos que la persona tenga permisos para tener usuario
        $datos = $this->Get_array($res);
        if($datos['if_user'] == "0") return "err/03AUTH";

        // Comprobamos si la persona ya posee un usuario
        $res = $this->Query("SELECT * FROM usuarios WHERE person_id_user = ".$datos['id_person']." ;");
        if($res->num_rows > 0) return "err/04AUTH";

        $this->password = password_hash($this->password, PASSWORD_BCRYPT, ['cost' => 12]);

        $sql_insert = "INSERT INTO usuarios(id_user,person_id_user,password_user,status_user,id_rol,
        created_user,pregun1_user,pregun2_user,respuesta1_user,respuesta2_user) 
        VALUES(null,".$datos['id_person'].",'$this->password',1,3,NOW(),'nada','nada','nada','nada');";        
            
        $this->Query($sql_insert);

        if($this->Result_last_query()) return "msg/02AUTH";
        else return "err/05AUTH";
      }else{
        return "err/02AUTH";
      }
    }
  }