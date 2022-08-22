<?php
    require_once("m_db.php");

    class m_comedor extends m_db{
        private $id_comedor, $nom_comedor, $encargado_comedor, $direccion_comedor, $if_sede, $status_comedor;

        public function __construct(){
            parent::__construct();
            $this->id_comedor = $this->nom_comedor = $this->status_comedor = $this->encargado_comedor = $this->direccion_comedor =  $this->if_sede = "";
        }

        public function setDatos($d){
            $this->id_comedor = isset($d['id_comedor']) ? $this->Clean(intval($d['id_comedor'])) : null;
            $this->nom_comedor = isset($d['nom_comedor']) ? $this->Clean($d['nom_comedor']) : null;
            $this->encargado_comedor = isset($d['encargado_comedor']) ? $this->Clean($d['encargado_comedor']) : null;
            $this->direccion_comedor = isset($d['direccion_comedor']) ? $this->Clean($d['direccion_comedor']) : null;
            $this->status_comedor = isset($d['status_comedor']) ? $this->Clean(intval($d['status_comedor'])) : null;
            $this->if_sede = isset($d['if_sede']) ? $this->Clean(intval($d['if_sede'])) : null;
        }

        public function Create(){
            $result = $this->Query("SELECT * FROM comedor WHERE nom_comedor = '$this->nom_comedor' ;");
            if($result->num_rows > 0) return "err/02ERR";

            $sql = "INSERT INTO comedor(id_comedor, nom_comedor, encargado_comedor, direccion_comedor, if_sede, status_comedor, created_comedor) VALUES(null,'$this->nom_comedor',$this->encargado_comedor,'$this->direccion_comedor', $this->if_sede ,$this->status_comedor, NOW());";
            $this->Query($sql);

            if($this->Result_last_query()) return "msg/01DONE"; else return "err/01ERR";
        }

        public function ExisteSede(){
          $result = $this->Query("SELECT * FROM comedor WHERE if_sede = '1';");
          if($result->num_rows > 0) return true; else return false;
        }

        public function Update(){
            $result = $this->Query("SELECT * FROM comedor WHERE encargado_comedor = $this->encargado_comedor AND direccion_comedor = '$this->direccion_comedor' AND nom_comedor = '$this->nom_comedor' AND id_comedor != $this->id_comedor ;");
            if($result->num_rows > 0) return ["code" => "error", "message" => "Los datos no se pueden duplicar"];

            $sql = "UPDATE comedor SET nom_comedor = '$this->nom_comedor', encargado_comedor = $this->encargado_comedor, direccion_comedor = '$this->direccion_comedor', if_sede = $this->if_sede
            WHERE id_comedor = $this->id_comedor ;";
            $this->Query($sql);

            if($this->Result_last_query()) return ["code" => "success", "message" => "Operación Exitosa"];
            else return ["code" => "error", "message" => "Operación Fallida"];
        }

        public function Disable(){

            $sql = "UPDATE comedor SET status_comedor = $this->status_comedor WHERE id_comedor = $this->id_comedor ;";
            $this->Query($sql);

            if($this->Result_last_query()) return ["code" => "success", "message" => "Operación Exitosa"];
            else return ["code" => "error", "message" => "Operación Fallida"];
        }

        public function Delete(){
            $sql = "DELETE FROM comedor WHERE id_comedor = $this->id_comedor AND status_comedor = '0' ;";
            $this->Query($sql);

            if($this->Result_last_query()) return ["code" => "success", "message" => "Operación Exitosa"];
            else return ["code" => "error", "message" => "Operación Fallida"];
        }

        public function Get_todos_comedor($status = ''){
            if($status != '') $sql = "SELECT * FROM comedor WHERE status_comedor = '1';"; else $sql = "SELECT * FROM comedor INNER JOIN personas ON comedor.encargado_comedor = personas.id_person;";
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
