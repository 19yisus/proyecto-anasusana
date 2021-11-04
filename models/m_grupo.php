<?php
    require_once("m_db.php");

    class m_grupo extends m_db{
        private $id_grupo, $nom_grupo, $status_grupo;

        public function __construct(){
            parent::__construct();
            $this->id_grupo = $this->nom_grupo = $this->status_grupo = "";
        }

        public function setDatos($d){
            $this->id_grupo = isset($d['id_grupo']) ? $this->Clean(intval($d['id_grupo'])) : null;
            $this->nom_grupo = isset($d['nom_grupo']) ? $this->Clean($d['nom_grupo']) : null;
            $this->status_grupo = isset($d['status_grupo']) ? $this->Clean(intval($d['status_grupo'])) : null;
        }

        public function Create(){
            $sql = "INSERT INTO grupo(id_grupo, nom_grupo, status_grupo, created_grupo) VALUES(null,'$this->nom_grupo', $this->status_grupo, NOW());";
            $this->Query($sql);
            
            if($this->Result_last_query()) return "msg/01DONE"; else return "err/01ERR";
        }

        public function Update(){
            $sql = "UPDATE grupo SET nom_grupo = '$this->nom_grupo' WHERE id_grupo = $this->id_grupo ;";
            $this->Query($sql);
            
            if($this->Result_last_query()) return ["code" => "success", "message" => "Operacion Exitosa"];
            else return ["code" => "error", "message" => "Operacion Fallida"];
        }

        public function Disable(){
            // $sqlConsulta = "SELECT * FROM producto WHERE grupo_id_product = $this->id_group ;";
            // $result = $this->Query($sql);
            // if($result) return ["code" => "error", "message" => "Este grupo de ya esta en uso"]

            $sql = "UPDATE grupo SET status_grupo = $this->status_grupo WHERE id_grupo = $this->id_grupo ;";
            $this->Query($sql);

            if($this->Result_last_query()) return ["code" => "success", "message" => "Operacion Exitosa"];
            else return ["code" => "error", "message" => "Operacion Fallida"];
        }

        public function Delete(){
            $sql = "DELETE * FROM grupo WHERE id_grupo = $this->id_grupo AND status_grupo = 0 ;";
            $this->Query($sql);

            if($this->Result_last_query()) return ["code" => "success", "message" => "Operacion Exitosa"];
            else return ["code" => "error", "message" => "Operacion Fallida"];
        }

        public function Get_todos_grupos(){
            $sql = "SELECT * FROM grupo ;";
            $results = $this->query($sql);
            return $this->Get_todos_array($results);
        }

        public function Get_grupo(){
            $sql = "SELECT * FROM grupo WHERE id_grupo = $this->id_grupo ;";
            $results = $this->Query($sql);
            return $this->Get_array($results);
        }
    }
?>