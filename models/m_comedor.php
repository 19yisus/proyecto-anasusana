<?php
    require_once("m_db.php");

    class m_comedor extends m_db{
        private $id_comedor, $nom_comedor, $status_comedor;

        public function __construct(){
            parent::__construct();
            $this->id_comedor = $this->nom_comedor = $this->status_comedor = "";
        }

        public function setDatos($d){
            $this->id_comedor = isset($d['id_comedor']) ? $this->Clean(intval($d['id_comedor'])) : null;
            $this->nom_comedor = isset($d['nom_comedor']) ? $this->Clean($d['nom_comedor']) : null;
            $this->status_comedor = isset($d['status_comedor']) ? $this->Clean(intval($d['status_comedor'])) : null;
        }

        public function Create(){
            $result = $this->Query("SELECT * FROM comedor WHERE nom_comedor = '$this->nom_comedor' ;");
            if($result->num_rows > 0) return "err/02ERR";

            $sql = "INSERT INTO comedor(id_comedor, nom_comedor, status_comedor, created_comedor) VALUES(null,'$this->nom_comedor', $this->status_comedor, NOW());";
            $this->Query($sql);
            
            if($this->Result_last_query()) return "msg/01DONE"; else return "err/01ERR";
        }

        public function Update(){
            $result = $this->Query("SELECT * FROM comedor WHERE nom_comedor = '$this->nom_comedor' AND id_comedor != $this->id_comedor ;");
            if($result->num_rows > 0) return ["code" => "error", "message" => "Los datos no se pueden duplicar"];

            $sql = "UPDATE comedor SET nom_comedor = '$this->nom_comedor' WHERE id_comedor = $this->id_comedor ;";
            $this->Query($sql);
            
            if($this->Result_last_query()) return ["code" => "success", "message" => "Operacion Exitosa"];
            else return ["code" => "error", "message" => "Operacion Fallida"];
        }

        public function Disable(){
            
            $sql = "UPDATE comedor SET status_comedor = $this->status_comedor WHERE id_comedor = $this->id_comedor ;";
            $this->Query($sql);

            if($this->Result_last_query()) return ["code" => "success", "message" => "Operacion Exitosa"];
            else return ["code" => "error", "message" => "Operacion Fallida"];            
        }

        public function Delete(){
            $sql = "DELETE FROM comedor WHERE id_comedor = $this->id_comedor AND status_comedor = '0' ;";
            $this->Query($sql);

            if($this->Result_last_query()) return ["code" => "success", "message" => "Operacion Exitosa"];
            else return ["code" => "error", "message" => "Operacion Fallida"];
        }

        public function Get_todos_comedor($status = ''){
            if($status != '') $sql = "SELECT * FROM comedor WHERE status_comedor = '1';"; else $sql = "SELECT * FROM comedor ;";            
            $results = $this->query($sql);
            return $this->Get_todos_array($results);
        }

        public function Get_comedor(){
            $sql = "SELECT * FROM comedor WHERE id_comedor = $this->id_comedor ;";
            $results = $this->Query($sql);
            return $this->Get_array($results);
        }
    }
?>