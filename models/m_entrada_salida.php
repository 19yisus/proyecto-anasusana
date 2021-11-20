<?php
    require_once("m_db.php");

    class m_entrada_salida extends m_db{
        private $id_invent, $orden_invent, $status_invent, $type_operation_invent, $person_id_invent, $comedor_id_invent, $user_id_invent, $observacion_invent;

        public function __construct(){
            parent::__construct();
            $this->id_invent = $this->orden_invent = $this->status_invent = $this->type_operation_invent = $this->person_id_invent = $this->comedor_id_invent = $this->user_id_invent = $this->observacion_invent = "";
        }

        public function setDatos($d){
            $this->id_invent = isset($d['id_invent']) ? $d['id_ivent'] : null;
            $this->orden_invent = isset($d['orden_invent']) ? $this->Clean(intval($d['orden_invent'])) : null;
            $this->status_invent = isset($d['status_invent']) ? $d['status_invent'] : null;
            $this->type_operation_invent = isset($d['type_operation_invent']) ? $d['type_operation_invent'] : null;
            $this->person_id_invent = isset($d['person_id_invent']) ? $d['person_id_invent'] : null;
            $this->comedor_id_invent = isset($d['comedor_id_ivent']) ? $d['comedor_id_invent'] : null;
            $this->user_id_invent = isset($d['user_id_invent']) ? $d['user_id_invent'] : null;
            $this->observacion_invent = isset($d['observacion_invent']) ? $this->Clean($d['observacion_invent']) : null;
        }

        public function Entrada_productos(){
            // TRANSACCTION
        }

        public function Salida_productos(){
            // TRANSACCTION
        }

        public function Get_todos_invent($type_operacion){
            $sql = "SELECT * FROM inventario INNER JOIN operacion ON operacion.invent_id_ope = inventario.id_invent 
            WHERE inventario.type_operacion_invent = '$type_operacion';";
            $results = $this->query($sql);
            return $this->Get_todos_array($results);
        }

        public function Get_Consultar_invent(){
            $sql = "SELECT * FROM inventario INNER JOIN operacion ON operacion.invent_id_ope = inventario.id_invent  
            WHERE inventario.id_invent = $this->id_invent;";
            $results = $this->Query($sql);
            return $this->Get_array($results);
        }
    }
?>