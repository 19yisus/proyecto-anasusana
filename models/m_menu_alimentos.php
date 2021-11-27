<?php
    require_once("m_db.php");

    class m_menu_alimentos extends m_db{
        private $id_producto, $nom_producto, $status_producto, $med_producto, $valor_producto, $stock_producto, $marca_id_producto, $grupo_id_producto;

        public function __construct(){
            parent::__construct();
            $this->id_producto = $this->nom_producto = $this->status_producto = $this->med_producto = $this->valor_producto = $this->stock_producto = $this->marca_id_producto = $this->grupo_id_producto = "";
        }

        public function setDatos($d){
            $this->id_producto = isset($d['id_producto']) ? $this->Clean(intval($d['id_producto'])) : null;
            $this->nom_producto = isset($d['nom_producto']) ? $this->Clean($d['nom_producto']) : null;
            $this->status_producto = isset($d['status_producto']) ? $this->Clean(intval($d['status_producto'])) : null;
            $this->med_producto = isset($d['med_producto']) ? $this->Clean($d['med_producto']) : null;
            $this->valor_producto = isset($d['valor_producto']) ? $this->Clean(intval($d['valor_producto'])) : null;
            $this->stock_producto = isset($d['stock_producto']) ? $this->Clean(intval($d['stock_producto'])) : null;
            $this->marca_id_producto = isset($d['marca_id_producto']) ? $this->Clean($d['marca_id_producto']) : null;
            $this->grupo_id_producto = isset($d['grupo_id_producto']) ? $this->Clean($d['grupo_id_producto']) : null;
        }
        
        public function Create(){
            $sqlVerificar = "SELECT * FROM producto WHERE nom_product = '$this->nom_producto' ;";
            $result = $this->Query($sqlVerificar);

            if($result->num_rows > 0){
                return "err/02ERR";
            }else{
                $sql = "INSERT INTO producto(id_product, nom_product, med_product, valor_product, status_product, created_product, stock_product, marca_id_product, grupo_id_product) 
                VALUES(null,'$this->nom_producto', '$this->med_producto', '$this->valor_producto', $this->status_producto, NOW(), 0, $this->marca_id_producto, $this->grupo_id_producto);";
                $this->Query($sql);
                
                if($this->Result_last_query()) return "msg/01DONE"; else return "err/01ERR";
            }
        }

        public function Update(){
            $sqlVerificar = "SELECT * FROM producto WHERE nom_product = '$this->nom_producto' AND id_product != $this->id_producto ;";
            $result = $this->Query($sqlVerificar);

            if($result->num_rows > 0){
                return ["code" => "error", "message" => "Operacion Fallida!, el regitro no se puede duplicar"];
            }else{
                $sql = "UPDATE producto SET nom_product = '$this->nom_producto', med_product = '$this->med_producto',
                valor_product = '$this->valor_producto', marca_id_product = $this->marca_id_producto, 
                grupo_id_product = $this->grupo_id_producto WHERE id_product = $this->id_producto ;";
                $this->Query($sql);
                
                if($this->Result_last_query()) return ["code" => "success", "message" => "Operacion Exitosa"];
                else return ["code" => "error", "message" => "Operacion Fallida"];
            }
        }

        public function Disable(){
            $sqlConsulta = "SELECT * FROM operacion WHERE product_id_ope = $this->id_producto ;";
            $result = $this->Query($sqlConsulta);
            
            if($result->num_rows > 0){
                return ["code" => "error", "message" => "Este producto de ya esta en uso"];
            }else{
                $sql = "UPDATE producto SET status_product = $this->status_producto WHERE id_product = $this->id_producto ;";
                $this->Query($sql);

                if($this->Result_last_query()) return ["code" => "success", "message" => "Operacion Exitosa"];
                else return ["code" => "error", "message" => "Operacion Fallida"];
            }            
        }

        public function Delete(){
            $sql = "DELETE FROM producto WHERE id_product = $this->id_producto AND status_product = '0' ;";
            $this->Query($sql);

            if($this->Result_last_query()) return ["code" => "success", "message" => "Operacion Exitosa"];
            else return ["code" => "error", "message" => "Operacion Fallida"];
        }

        public function Get_todos_productos($status = ''){
            if($status != '') $condition = "WHERE producto.status_product = '1' "; else $condition = "";
            $sql = "SELECT * FROM producto INNER JOIN marca ON marca.id_marca = producto.marca_id_product INNER JOIN grupo ON grupo.id_grupo = producto.grupo_id_product $condition ;";
            if($status != '' && $status == 2){
                $sql = "SELECT * FROM producto
                    INNER JOIN marca ON marca.id_marca = producto.marca_id_product
                    INNER JOIN grupo ON grupo.id_grupo = producto.grupo_id_product
                    INNER JOIN operacion ON operacion.product_id_ope = producto.id_product
                    $condition AND producto.stock_product > 0 GROUP BY producto.id_product;";
            }
            $results = $this->query($sql);
            return $this->Get_todos_array($results);
        }

        public function Get_producto(){
            $sql = "SELECT * FROM producto WHERE id_product = $this->id_producto ;";
            $results = $this->Query($sql);
            return $this->Get_array($results);
        }
    }
?>
