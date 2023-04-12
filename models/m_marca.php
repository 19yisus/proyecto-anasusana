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
            $result = $this->Query("SELECT * FROM marca WHERE nom_marca = '$this->nom_marca' ;");
            if($result->num_rows > 0) return "err/02ERR";

            $sql = "INSERT INTO marca(id_marca, nom_marca, status_marca, created_marca) VALUES(null,'$this->nom_marca', $this->status_marca, NOW());";
            $this->Query($sql);
            
            if(!isset($_SESSION['user_id'])) session_start();
            
            if($this->Result_last_query()){
              $this->reg_bitacora([
                'user_id' => $_SESSION['user_id'],
                'table_name'=> "MARCA",
                'des' => "REGISTRO DE NUEVO MARCA: $this->nom_marca"
              ]);
              return "msg/01DONE";
            }
            else return "err/01ERR";
        }

        public function Update(){
            $result = $this->Query("SELECT * FROM marca WHERE nom_marca = '$this->nom_marca' AND id_marca != $this->id_marca ;");
            if($result->num_rows > 0) return ["code" => "error", "message" => "Los datos no se pueden duplicar"];

            $sql = "UPDATE marca SET nom_marca = '$this->nom_marca' WHERE id_marca = $this->id_marca ;";
            $this->Query($sql);
            
            if(!isset($_SESSION['user_id'])) session_start();
            
            if($this->Result_last_query()){
              $this->reg_bitacora([
                'user_id' => $_SESSION['user_id'],
                'table_name'=> "MARCA",
                'des' => "ACTUALIZACIÓN DE MARCA: $this->nom_marca, ID => $this->id_marca"
              ]);
      
              return ["code" => "success", "message" => "Operación Exitosa"];
            }
            else return ["code" => "error", "message" => "Operación Fallida"];
        }

        public function Disable(){
            $sqlConsulta = "SELECT * FROM productos WHERE marca_id_product = $this->id_marca ;";
            $result = $this->Query($sqlConsulta);
            
            if($result->num_rows > 0){
                return ["code" => "error", "message" => "Esta marca de ya esta en uso"];
            }else{
                $sql = "UPDATE marca SET status_marca = $this->status_marca WHERE id_marca = $this->id_marca ;";
                $this->Query($sql);

                if(!isset($_SESSION['user_id'])) session_start();
            
                if($this->Result_last_query()){
                  if($this->estatus_marca == 0) $des_estatus = "DESACTIVACIÓN"; else $des_estatus = "ACTIVACIÓN";
                  $this->reg_bitacora([
                    'user_id' => $_SESSION['user_id'],
                    'table_name'=> "MARCA",
                    'des' => "$des_estatus DEL MARCA: ID => $this->id_marca"
                  ]);
          
                  return ["code" => "success", "message" => "Operación Exitosa"];
                }
                else return ["code" => "error", "message" => "Operación Fallida"];  
            }            
        }

        public function Delete(){
            $sql = "DELETE FROM marca WHERE id_marca = $this->id_marca AND status_marca = '0' ;";
            $this->Query($sql);

            if(!isset($_SESSION['user_id'])) session_start();
            
            if($this->Result_last_query()){
              $this->reg_bitacora([
                'user_id' => $_SESSION['user_id'],
                'table_name'=> "MARCA",
                'des' => "ELIMINACIÓN DEL MARCA: ID => $this->id_marca"
              ]);
      
              return ["code" => "success", "message" => "Operación Exitosa"];
            }
            else return ["code" => "error", "message" => "Operación Fallida"]; 
        }

        public function Get_todos_marcas($status = ''){
            if($status != '') $sql = "SELECT * FROM marca WHERE status_marca = '1';"; else $sql = "SELECT * FROM marca ;";            
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