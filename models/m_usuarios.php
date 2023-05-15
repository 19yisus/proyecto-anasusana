<?php
    if(!class_exists("m_db")) require_once("m_db.php");

    class m_usuarios extends m_db{
        private $id_user, $rol_user, $status_user, $modulos;

        public function __construct(){
            parent::__construct();
            $this->id_user = $this->rol_user = $this->status_user = $this->modulos = "";
        }

        public function setDatos($d){
            $this->id_user = isset($d['id_user']) ? $this->Clean(intval($d['id_user'])) : null;
            $this->rol_user = isset($d['rol_user']) ? $this->Clean(intval($d['rol_user'])) : null;
            $this->status_user = isset($d['status_user']) ? $this->Clean(intval($d['status_user'])) : null;
            $this->modulos = isset($d['modulos']) ? $d['modulos'] : null;
        }

        public function Update(){
          $sql = "UPDATE usuarios SET id_rol = '$this->rol_user' WHERE id_user = $this->id_user ;";
          $this->Query($sql);
          
          return ["code" => "success", "message" => "Operación Exitosa"];
        }

        public function Disable(){
            
          if($_SESSION['permisos'] < 3) return ["code" => "error", "message" => "No posees permisos para desactivar este usuario"];
          if($_SESSION['user_id'] == $this->id_user) return ["code" => "error", "message" => "NO puedes desactivar tu propia cuenta"];

          $sql = "UPDATE usuarios SET status_user = $this->status_user WHERE id_user = $this->id_user ;";
          $this->Query($sql);

          if($this->Result_last_query()) return ["code" => "success", "message" => "Operación Exitosa"];
          else return ["code" => "error", "message" => "Operación Fallida"];
        }

        // public function Delete(){
        //     $sql = "DELETE FROM grupo WHERE id_user = $this->id_user AND status_user = '0' ;";
        //     $this->Query($sql);

        //     if($this->Result_last_query()) return ["code" => "success", "message" => "Operación Exitosa"];
        //     else return ["code" => "error", "message" => "Operación Fallida"];
        // }

      public function Get_todos_users(){
        $sql = "SELECT * FROM usuarios INNER JOIN personas ON personas.id_person = usuarios.person_id_user
        INNER JOIN roles_usuario ON roles_usuario.id = usuarios.id_rol;";
        $results = $this->query($sql);
        return $this->Get_todos_array($results);
      }

      public function Get_user(){
        $sql = "SELECT id_user,id_rol FROM usuarios WHERE id_user = $this->id_user ;";
        $results = $this->Query($sql);
        return $this->Get_array($results);
      }

      public function Get_permisosVistas(){
        $sql = "SELECT modulo_name FROM permiso_vista WHERE user_id = $this->id_user ;";
        $results = $this->Query($sql);
        return $this->Get_todos_array($results);
      }

      public function Get_roles(){
        $sql = "SELECT * FROM roles_usuario WHERE nivel_permisos_rol < 3;";
        $results = $this->Query($sql);
        return $this->Get_todos_array($results);
      }

      public function Actualizar_permisos_vista(){
        $sql = "DELETE FROM permiso_vista WHERE user_id = $this->id_user;";
        $this->Query($sql);

        foreach($this->modulos as $modulo){
          $sql = "INSERT INTO permiso_vista(user_id, modulo_name) VALUES($this->id_user, '$modulo');";
          $this->Query($sql);
        }

        return ["code" => "success", "message" => "Operación Exitosa"];
      }

      public function Save_pregunta($pregunta){
        $pregunta = isset($pregunta) ? strtoupper($pregunta) : null;
        $sql = "INSERT INTO preguntas(des_pregun) VALUES('$pregunta');";
        // var_dump($sql);
        $result = $this->Query($sql);
        
        if($this->Result_last_query()) return ["code" => "success", "message" => "Operación Exitosa"];
        else return ["code" => "error", "message" => "Operación Fallida"];
      }

      public function Update_pregunta($datos){
        $id = isset($datos['id_pregun']) ? $datos['id_pregun'] : null;
        $des = isset($datos['des_pregun']) ? strtoupper($datos['des_pregun']) : null;

        $sql = "UPDATE preguntas  SET des_pregun = '$des' WHERE id_pregun = $id;";
        $result = $this->Query($sql);
        
        if($this->Result_last_query()) return ["code" => "success", "message" => "Operación Exitosa"];
        else return ["code" => "error", "message" => "Operación Fallida"];
      }

      public function Get_Pregunta($id){
        $sql = "SELECT * FROM preguntas WHERE id_pregun = $id ;";
        $results = $this->Query($sql);
        return $this->Get_array($results);
      }

      public function Get_All_bitacora(){
        $sql = "SELECT * FROM bitacora INNER JOIN usuarios ON usuarios.id_user = bitacora.id_usuario INNER JOIN personas ON personas.id_person = usuarios.person_id_user";
        $results = $this->query($sql);
        return $this->Get_todos_array($results);
      }
    }
?>