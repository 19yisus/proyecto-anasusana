<?php
    class m_db{
        private $host, $dbname, $user, $pass, $conexion;
        public function __construct(){
            $this->host = "localhost";
            $this->dbname = "proyecto_iglesia";
            $this->user = "root";
            $this->pass = "";
            $this->Connect();
        }

        private function Connect(){
            $this->conexion = mysqli_connect($this->host, $this->user, $this->pass, $this->dbname);
            if(mysqli_connect_error()) die("NO SE PUEDO CONECTAR A LA BASE DE DATOS: ".mysqli_connect_error());
        }

        protected function Query($sql){ $this->Connect(); return mysqli_query($this->conexion, $sql); }
        protected function Start_transacction(){ mysqli_autocommit($this->conexion, false); }
        protected function End_transacction(){ mysqli_commit($this->conexion); }
        protected function Rollback(){ mysqli_rollback($this->conexion); }
        protected function Result_last_query(){ return (mysqli_affected_rows($this->conexion)) ? true : false;}
        protected function Get_array($results){ return mysqli_fetch_array($results); }
        protected function Get_todos_array($results){ return mysqli_fetch_all($results, MYSQLI_ASSOC); }
        protected function Clean($variable){
            $variable = stripslashes($variable);
            $variable = str_ireplace("SELECT * FROM","",$variable);
            $variable = str_ireplace("DELETE * FROM","",$variable);
            $variable = str_ireplace("INSERT INTO","",$variable);
            $variable = str_ireplace("[","",$variable);
            $variable = str_ireplace("]","",$variable);
            $variable = str_ireplace("(","",$variable);
            $variable = str_ireplace(")","",$variable);
            $variable = str_ireplace("{","",$variable);
            $variable = str_ireplace("}","",$variable);
            $variable = str_ireplace("==","",$variable);
            $variable = str_ireplace("=","",$variable);
            $variable = str_ireplace("<script>","",$variable);
            $variable = str_ireplace("<script src= >","",$variable);
            $variable = str_ireplace("src=","",$variable);
                
            if(!is_numeric($variable)){
                $variable = strtoupper($variable);
            }else{
                $variable = str_ireplace(" ","",$variable);
            }
            return $variable;
        }
        public function __destruct(){ mysqli_close($this->conexion); }
    }
?>