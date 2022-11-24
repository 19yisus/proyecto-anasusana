<?php

if (!class_exists("m_db")) require("m_db.php");

class m_jornada extends m_db
{
  private $id_jornada, $des_jornada, $titulo_jornada, $estatus_jornada;
  private $cant_aproximada, $menu_id_jornada, $fecha_jornada, $responsable;

  public function __construct()
  {
    parent::__construct();
    $this->id_jornada = $this->des_jornada = $this->estatus_jornada = $this->titulo_jornada = null;
    $this->cant_aproximada = $this->menu_id_jornada = $this->fecha_jornada = $this->responsable = null;
  }

  public function setDatos($d)
  {
    $this->id_jornada = isset($d["id_jornada"]) ? $this->Clean(intval($d["id_jornada"]))  : null;
    $this->des_jornada = isset($d["des_jornada"]) ? $this->Clean($d["des_jornada"]) : null;
    $this->titulo_jornada = isset($d['titulo_jornada']) ? $this->Clean($d['titulo_jornada']) : null;
    $this->estatus_jornada = isset($d["estatus_jornada"]) ? $this->Clean($d["estatus_jornada"]) : null;
    $this->cant_aproximada = isset($d['cant_aproximada']) ? $this->Clean($d['cant_aproximada'])  : null;
    $this->menu_id_jornada = isset($d["menu_id_jornada"]) ? $this->Clean(intval($d["menu_id_jornada"]))  : null;
    $this->fecha_jornada = isset($d["fecha_jornada"]) ? $d["fecha_jornada"] : null;
    $this->responsable = isset($d["responsable"]) ? $this->Clean(intval($d["responsable"]))  : null;
  }

  public function Create()
  {
    try {
      $sql1 = "INSERT INTO jornada(
        titulo_jornada,
        des_jornada, 
        cant_aproximada, 
        estatus_jornada, 
        fecha_jornada,
        menu_id_jornada,
        person_id_responsable) 
        
        VALUES(
          '$this->titulo_jornada',
          '$this->des_jornada', 
          $this->cant_aproximada, 
          1, 
          '$this->fecha_jornada',
          $this->menu_id_jornada,
          $this->responsable);";
      $this->Query($sql1);

      if ($this->Result_last_query()) return "msg/01DONE";
      else return "err/01ERR";
    } catch (Exception $e) {
      die("AH OCURRIDO UN ERROR: " . $e->getMessage());
    }
  }

  public function Update()
  {
    $result = $this->Query("SELECT * FROM jornada WHERE des_jornada = '$this->des_jornada' AND id_jornada != $this->id_jornada ;");
    if ($result->num_rows > 0) return ["code" => "error", "message" => "Los datos no se pueden duplicar"];

    $sql = "UPDATE jornada SET des_jornada = '$this->des_jornada', des_procedimiento = '$this->des_procedimiento' WHERE id_jornada = $this->id_jornada ;";
    $this->Query($sql);

    $sqlDelete = "DELETE FROM jornada_detalle WHERE jornada_id_detalle = $this->id_jornada";
    $this->Query($sqlDelete);

    if ($this->Result_last_query()) return ["code" => "success", "message" => "Operación Exitosa"];
    else return ["code" => "error", "message" => "Operación Fallida"];
  }

  public function Disable()
  {

    $sql = "UPDATE jornada SET status_jornada = $this->estatus_jornada WHERE id_jornada = $this->id_jornada ;";
    $this->Query($sql);

    if ($this->Result_last_query()) return ["code" => "success", "message" => "Operación Exitosa"];
    else return ["code" => "error", "message" => "Operación Fallida"];
  }

  public function Delete()
  {
    $sql = "DELETE FROM jornada WHERE id_jornada = $this->id_jornada AND estatus_jornada = '0' ;";
    $this->Query($sql);

    if ($this->Result_last_query()) return ["code" => "success", "message" => "Operación Exitosa"];
    else return ["code" => "error", "message" => "Operación Fallida"];
  }

  public function Get_todos_jornada($status = '')
  {
    if ($status != '') $sql = "SELECT * FROM jornada WHERE estatus_jornada = $status";
    else $sql = "SELECT * FROM jornada INNER JOIN personas ON personas.id_person = jornada.person_id_responsable";
    $results = $this->query($sql);
    return $this->Get_todos_array($results);
  }

  public function Get_jornada()
  {
    $sql = "SELECT * FROM jornada INNER JOIN menu ON menu.id_menu = jornada.menu_id_jornada WHERE jornada.id_jornada = $this->id_jornada ;";
    $results = $this->Query($sql);
    $datos_jornada = $this->Get_array($results);

    $id = $datos_jornada['menu_id_jornada'];

    $sql2 = "SELECT * FROM menu 
      INNER JOIN menu_detalle ON menu_detalle.menu_id_detalle = menu.id_menu WHERE id_menu = $id";
    $results2 = $this->Query($sql2);
    $datos_menu = $this->Get_todos_array($results2);
    return [$datos_jornada, $datos_menu];
  }

  public function Get_jornada_hoy(){
    $fecha = date("Y-m-d");
    // $fecha = '2022-11-23';
    $sql = "SELECT * FROM jornada WHERE fecha_jornada = '$fecha' AND estatus_jornada = 1";
    // die($sql);
    $results = $this->query($sql);
    return $this->Get_todos_array($results);
  }
}
