<?php
    require_once("m_db.php");

    class m_entrada_salida extends m_db{
        private $id_invent, $orden_invent, $status_invent, $cantidad_invent, $type_operation_invent, $concept_invent, $person_id_invent, $comedor_id_invent, $user_id_invent, $observacion_invent, $productos, $fecha_invent;
        
        public function __construct(){
            parent::__construct();
            $this->id_invent = $this->orden_invent = $this->status_invent = $this->cantidad_invent = $this->type_operation_invent = $this->concept_invent = $this->person_id_invent = $this->comedor_id_invent = $this->user_id_invent = $this->observacion_invent = $this->productos = $this->fecha_invent = "";
        }

        public function setDatos($d, $productos =[]){
            $this->id_invent = isset($d['id_invent']) ? $d['id_invent'] : null;
            $this->orden_invent = isset($d['orden_invent']) ? $this->Clean(intval($d['orden_invent'])) : null;
            $this->status_invent = isset($d['status_invent']) ? $d['status_invent'] : null;
            $this->type_operation_invent = isset($d['type_operation_invent']) ? $d['type_operation_invent'] : null;
            $this->concept_invent = isset($d['concept_invent']) ? $d['concept_invent'] : null;
            $this->person_id_invent = isset($d['person_id_invent']) ? $d['person_id_invent'] : null;
            $this->comedor_id_invent = isset($d['comedor_id_invent']) ? $d['comedor_id_invent'] : null;
            $this->user_id_invent = isset($d['user_id_invent']) ? $d['user_id_invent'] : 1;
            $this->observacion_invent = isset($d['observacion_invent']) ? $this->Clean($d['observacion_invent']) : null;
            $this->cantidad_invent = isset($d['cantidad_invent']) ? $this->Clean(intVal($d['cantidad_invent'])) : null;
            $this->productos = isset($productos) ? $productos : null;
            $this->fecha_invent = isset($d['fecha_invent']) ? $d['fecha_invent'] : null;
        }

        public function Entrada_productos(){
            // TRANSACCTION
            $status_transaccion = true;
            $sql_inventario_insert = "INSERT INTO inventario(id_invent,orden_invent,cantidad_invent,status_invent,created_invent,type_operacion_invent,
            concept_invent,person_id_invent,comedor_id_invent,user_id_invent,observacion_invent) 
            VALUES ('$this->id_invent','$this->orden_invent',$this->cantidad_invent,1,'$this->fecha_invent','E','$this->concept_invent',$this->person_id_invent,$this->comedor_id_invent,$this->user_id_invent,'$this->observacion_invent')";
            
            try{
                $this->Start_transacction();
                $results_invent = $this->Query($sql_inventario_insert);
    
                if($this->Result_last_query()){
                        
                    foreach($this->productos as $producto){
                        $id = $producto['id_product'];
                        $precio = $producto['precio_product'];
                        $fecha = $producto['fecha_product'];
                        $stock = $producto['stock_product'];

                        if($fecha != "") $sql_operacion = "INSERT INTO detalle_inventario(product_id_ope,invent_id_ope,fecha_vencimiento_ope,precio_product_ope) VALUES ('$id','$this->id_invent','$fecha',$precio)";
                        else $sql_operacion = "INSERT INTO detalle_inventario(product_id_ope,invent_id_ope,fecha_vencimiento_ope,precio_product_ope) VALUES ('$id','$this->id_invent',NULL,$precio)";                        

                        $sql_producto_stock = "UPDATE productos SET productos.stock_product = (SELECT SUM(productos.stock_product + $stock) 
                        WHERE productos.id_product = $id) WHERE productos.id_product = $id";
                            
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
            }catch(Exception $e){
                die("AH OCURRIDO UN ERROR: ".$e->getMessage());
            }
        }

        public function Salida_productos(){
            // TRANSACCTION
            $status_transaccion = true;
            $sql_inventario_insert = "INSERT INTO inventario(id_invent,orden_invent,cantidad_invent,status_invent,created_invent,type_operacion_invent,
            concept_invent,person_id_invent,comedor_id_invent,user_id_invent,observacion_invent) 
            VALUES ('$this->id_invent','$this->orden_invent',$this->cantidad_invent,1,'$this->fecha_invent','S','$this->concept_invent',null,$this->comedor_id_invent,$this->user_id_invent,'$this->observacion_invent')";
            
            try{
                $this->Start_transacction();
                $results_invent = $this->Query($sql_inventario_insert);
    
                if($this->Result_last_query()){
    
                    foreach($this->productos as $producto){
                        $id = $producto['id_product'];
                        $stock = $producto['stock_product'];
                            
                        $sql_operacion = "INSERT INTO detalle_inventario(product_id_ope,invent_id_ope,fecha_vencimiento_ope,precio_product_ope) 
                        VALUES ($id,'$this->id_invent',null,null)";
        
                        $sql_producto_stock = "UPDATE productos SET productos.stock_product =( 
                            (SELECT productos.stock_product FROM productos WHERE productos.id_product = $id) - $stock) WHERE productos.id_product = $id;";
                            
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
            }catch(Exception $e){
                die("AH OCURRIDO UN ERROR: ".$e->getMessage());
            }
        }

        public function Get_todos_invent($type_operacion){
            $second_inner = $select_person = "";
            if($type_operacion == "E") $second_inner = "INNER JOIN personas ON personas.id_person = inventario.person_id_invent";
            if($type_operacion == "E") $select_person = "personas.nom_person,";

            $sql = "SELECT inventario.id_invent, inventario.orden_invent, inventario.status_invent, inventario.created_invent,
            $select_person cantidad_invent FROM inventario 
            INNER JOIN detalle_inventario ON detalle_inventario.invent_id_ope = inventario.id_invent $second_inner WHERE
            inventario.type_operacion_invent = '$type_operacion' GROUP BY inventario.id_invent;";
            
            return $this->Get_todos_array($this->query($sql));
        }

        public function Get_Consultar_invent(){
            $results = $this->Query("SELECT * FROM inventario INNER JOIN detalle_inventario ON detalle_inventario.invent_id_ope = inventario.id_invent  
            WHERE inventario.id_invent = $this->id_invent;");

            return $this->Get_array($results);
        }

        public function NextId($tipo){
			$count = 1;
			$digits = 8;
            $result = $this->Query("SELECT MAX(id_invent) AS id_invent FROM inventario WHERE type_operacion_invent = '$tipo' ;");
            if($result->num_rows == 0) return "$tipo-00000001";
            $valor = $this->Get_array($result)['id_invent'];
            if($valor == null ) return "$tipo-00000001";
            $start = ( intval(explode("-",$valor)[1]) + 1);
                        
            for ($n = $start; $n < $start + $count; $n++) $new_code = str_pad($n, $digits, "0", STR_PAD_LEFT);			
			if (strlen($new_code) < 8) return "$tipo-0".$new_code; else return  "$tipo-$new_code";
        }
    }
?>