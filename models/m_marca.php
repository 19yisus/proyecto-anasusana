<?php
    require_once("m_db.php");

    class m_marca extends m_db{
        private $id_marca, $nom_marca, $status_marca;

        public function __construct(){
            parent::__construct();
            $this->id_marca = $this->nom_marca = $this->status_marca = "";
        }

        public function setDatos($d){
            $this->id_marca = isset($d['id_marca']) ? $this->Clean(intval($d['id_marca'])) : null;
            $this->nom_marca = isset($d['nom_marca']) ? $this->Clean($d['nom_marca']) : null;
            $this->status_marca = isset($d['status_marca']) ? $this->Clean(intval($d['status_marca'])) : null;
        }

        public function Create(){
            $sql = "INSERT INTO marca(id_marca, nom_marca, status_marca, created_marca) VALUES(null,'$this->nom_marca', $this->status_marca, NOW());";
            $this->Query($sql);
            
            if($this->Result_last_query()) return "msg/01DONE"; else return "err/01ERR";
        }

        public function Update(){
            $sql = "UPDATE marca SET nom_marca = '$this->nom_marca' WHERE id_marca = $this->id_marca ;";
            $this->Query($sql);
            
            if($this->Result_last_query()) return ["code" => "success", "message" => "Operacion Exitosa"];
            else return ["code" => "error", "message" => "Operacion Fallida"];
        }

        public function Disable(){
            $sqlConsulta = "SELECT * FROM producto WHERE marca_id_product = $this->id_marca ;";
            $result = $this->Query($sqlConsulta);
            
            if($result->num_rows > 0){
                return ["code" => "error", "message" => "Esta marca de ya esta en uso"];
            }else{
                $sql = "UPDATE marca SET status_marca = $this->status_marca WHERE id_marca = $this->id_marca ;";
                $this->Query($sql);

                if($this->Result_last_query()) return ["code" => "success", "message" => "Operacion Exitosa"];
                else return ["code" => "error", "message" => "Operacion Fallida"];
            }            
        }

        public function Delete(){
            $sql = "DELETE FROM marca WHERE id_marca = $this->id_marca AND status_marca = '0' ;";
            $this->Query($sql);

            if($this->Result_last_query()) return ["code" => "success", "message" => "Operacion Exitosa"];
            else return ["code" => "error", "message" => "Operacion Fallida"];
        }

        public function Get_todos_marcas(){
            $sql = "SELECT * FROM marca ;";
            $results = $this->query($sql);
            return $this->Get_todos_array($results);
        }

        public function Get_marca(){
            $sql = "SELECT * FROM marca WHERE id_marca = $this->id_marca ;";
            $results = $this->Query($sql);
            return $this->Get_array($results);
        }
    }
?>