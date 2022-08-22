<?php
    require_once("m_db.php");

    class m_usuarios extends m_db{
        private $id_user, $rol_user, $status_user;

        public function __construct(){
            parent::__construct();
            $this->id_user = $this->rol_user = $this->status_user = "";
        }

        public function setDatos($d){
            $this->id_user = isset($d['id_user']) ? $this->Clean(intval($d['id_user'])) : null;
            $this->rol_user = isset($d['rol_user']) ? $this->Clean(intval($d['rol_user'])) : null;
            $this->status_user = isset($d['status_user']) ? $this->Clean(intval($d['status_user'])) : null;
        }

        public function Update(){
            $sql = "UPDATE usuarios SET id_rol = '$this->rol_user' WHERE id_user = $this->id_user ;";
            $this->Query($sql);
            
            if($this->Result_last_query()) return ["code" => "success", "message" => "Operación Exitosa"];
            else return ["code" => "error", "message" => "Operación Fallida"];
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

        public function Get_roles(){
          $sql = "SELECT * FROM roles_usuario WHERE nivel_permisos_rol < 3;";
          $results = $this->Query($sql);
          return $this->Get_todos_array($results);
        }
    }
?>