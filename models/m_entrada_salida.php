<?php
    require_once("m_db.php");

    class m_entrada_salida extends m_db{
        private $id_invent, $orden_invent, $status_invent, $type_operation_invent, $person_id_invent, $comedor_id_invent, $user_id_invent, $observacion_invent, $productos;
        
        public function __construct(){
            parent::__construct();
            $this->id_invent = $this->orden_invent = $this->status_invent = $this->type_operation_invent = $this->person_id_invent = $this->comedor_id_invent = $this->user_id_invent = $this->observacion_invent = $this->productos = "";
        }

        public function setDatos($d, $productos =[]){
            $this->id_invent = isset($d['id_invent']) ? $d['id_ivent'] : null;
            $this->orden_invent = isset($d['orden_invent']) ? $this->Clean(intval($d['orden_invent'])) : null;
            $this->status_invent = isset($d['status_invent']) ? $d['status_invent'] : null;
            $this->type_operation_invent = isset($d['type_operation_invent']) ? $d['type_operation_invent'] : null;
            $this->person_id_invent = isset($d['person_id_invent']) ? $d['person_id_invent'] : null;
            $this->comedor_id_invent = isset($d['comedor_id_invent']) ? $d['comedor_id_invent'] : null;
            $this->user_id_invent = isset($d['user_id_invent']) ? $d['user_id_invent'] : 1;
            $this->observacion_invent = isset($d['observacion_invent']) ? $this->Clean($d['observacion_invent']) : null;
            $this->productos = isset($productos) ? $productos : null;
        }

        public function Entrada_productos(){
            // TRANSACCTION
            $status_transaccion = true;
            $sql_inventario_insert = "INSERT INTO inventario(id_invent,orden_invent,status_invent,created_invent,type_operacion_invent,
            person_id_invent,comedor_id_invent,user_id_invent,observacion_invent) 
            VALUES (null,'$this->orden_invent',1,NOW(),'E',$this->person_id_invent,$this->comedor_id_invent,$this->user_id_invent,'$this->observacion_invent')";
            
            $sql_inventario_select = "SELECT MAX(id_invent) AS id_invent FROM inventario WHERE status_invent = '1';";

            try{
                $this->Start_transacction();
                $results_invent = $this->Query($sql_inventario_insert);
    
                if($this->Result_last_query()){
                    $inventario = $this->Get_array($this->Query($sql_inventario_select));
    
                    foreach($this->productos as $producto){
                        $id = $producto['id_product'];
                        $precio = $producto['precio_product'];
                        $fecha = $producto['fecha_product'];
                        $stock = $producto['stock_product'];
                        $id_inventario = $inventario['id_invent'];
    
                        $sql_operacion = "INSERT INTO operacion(product_id_ope,invent_id_ope,fecha_vencimiento_ope,precio_product_ope) 
                        VALUES ($id,$id_inventario,'$fecha',$precio)";
        
                        $sql_producto_stock = "UPDATE producto SET producto.stock_product = (SELECT SUM(producto.stock_product + $stock) 
                        WHERE producto.id_product = $id) WHERE producto.id_product = $id";
                            
                        $results_operacion = $this->Query($sql_operacion);    
                        if(!$this->Result_last_query()){
                            $status_transaccion = false;
                            break;
                        }

                        $results_producto_stock = $this->Query($sql_producto_stock);    
                        if(!$this->Result_last_query()){
                            $status_transaccion = false;
                            break;
                        }
                    }
                }else{
                    $status_transaccion = false;
                    $this->Rollback();
                }
    
                if($status_transaccion){
                    $this->End_transacction();
                    return "msg/01DONE"; 
                }else{
                    $this->Rollback();
                    return "err/01ERR";
                }      
            }catch(Error $e){
                var_dump($e);
                die("AH OCURRIDO UN ERROR");
            }
        }

        public function Salida_productos(){
            // TRANSACCTION
        }

        public function Get_todos_invent($type_operacion){
            $sql = "SELECT inventario.id_invent, inventario.orden_invent, inventario.status_invent, inventario.created_invent,
            personas.nom_person, COUNT(operacion.invent_id_ope) AS cantidad_producst FROM inventario 
            INNER JOIN operacion ON operacion.invent_id_ope = inventario.id_invent 
            INNER JOIN personas ON personas.id_person = inventario.person_id_invent WHERE
            inventario.type_operacion_invent = '$type_operacion' GROUP BY inventario.id_invent;";
            
            return $this->Get_todos_array($this->query($sql));
        }

        public function Get_Consultar_invent(){
            $results = $this->Query("SELECT * FROM inventario INNER JOIN operacion ON operacion.invent_id_ope = inventario.id_invent  
            WHERE inventario.id_invent = $this->id_invent;");

            return $this->Get_array($results);
        }

        public function NextId(){
            $results = $this->Query("SELECT MAX(id_invent) AS maximo FROM inventario;");

            if($results->num_rows > 0) return $this->Get_array($results)['maximo'] + 1;
            else return 1;
        }

        public function GetComedor(){
            $results = $this->Query("SELECT * FROM comedor;");
            if($results->num_rows > 0) return $this->Get_array($results);
        }
    }
?>