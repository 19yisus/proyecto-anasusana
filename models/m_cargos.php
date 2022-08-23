<?php 
  
  if(!class_exists("m_db")) require("m_db.php");

  class m_cargos extends m_db{
    private $id_cargo, $des_cargo, $estatus_cargo;

    public function __construct(){
      parent::__construct();
      $this->id_cargo = $this->des_cargo = $this->estatus_cargo = null;
    }

    public function setDatos($d){
      $this->id_cargo = isset($d["id_cargo"]) ? $this->Clean(intval($d["id_cargo"]))  : null;
      $this->des_cargo = isset($d["des_cargo"]) ? $this->Clean($d["des_cargo"]) : null;
      $this->estatus_cargo = isset($d["estatus_cargo"]) ? $this->Clean($d["estatus_cargo"]) : null;
    }

    public function Create(){
      $result = $this->Query("SELECT * FROM cargo WHERE des_cargo = '$this->des_cargo'");
      if($result->num_rows > 0) return "err/02ERR";

      $sql = "INSERT INTO cargo(des_cargo, estatus_cargo) VALUES('$this->des_cargo', 1);";
      $this->Query($sql);
      if($this->Result_last_query()) return "msg/01DONE"; else return "err/01ERR";
    }

    public function Update(){
      $result = $this->Query("SELECT * FROM cargo WHERE des_cargo = '$this->des_cargo' AND id_cargo != $this->id_cargo ;");
      if($result->num_rows > 0) return ["code" => "error", "message" => "Los datos no se pueden duplicar"];

      $sql = "UPDATE cargo SET des_cargo = '$this->des_cargo' WHERE id_cargo = $this->id_cargo ;";
      $this->Query($sql);

      if($this->Result_last_query()) return ["code" => "success", "message" => "Operación Exitosa"];
      else return ["code" => "error", "message" => "Operación Fallida"];
    }

    public function Disable(){

      $sql = "UPDATE cargo SET estatus_cargo = $this->estatus_cargo WHERE id_cargo = $this->id_cargo ;";
      $this->Query($sql);

      if($this->Result_last_query()) return ["code" => "success", "message" => "Operación Exitosa"];
      else return ["code" => "error", "message" => "Operación Fallida"];
    }

    public function Delete(){
      $sql = "DELETE FROM cargo WHERE id_cargo = $this->id_cargo AND estatus_cargo = '0' ;";
      $this->Query($sql);

      if($this->Result_last_query()) return ["code" => "success", "message" => "Operación Exitosa"];
      else return ["code" => "error", "message" => "Operación Fallida"];
    }

    public function Get_todos_cargo($status = ''){
      if($status != '' ) $sql = "SELECT * FROM cargo WHERE estatus_cargo = $status"; else $sql = "SELECT * FROM cargo ";
      $results = $this->query($sql);
      return $this->Get_todos_array($results);
    }

    public function Get_cargo(){
      $sql = "SELECT * FROM cargo WHERE id_cargo = $this->id_cargo ;";
      $results = $this->Query($sql);
      return $this->Get_array($results);
    }
  }