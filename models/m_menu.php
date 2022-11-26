<?php

if (!class_exists("m_db")) require("m_db.php");

class m_menu extends m_db
{
  private $id_menu, $des_menu, $des_procedimiento, $estatus_menu, $porcion;
  private $des_comida_detalle, $med_comida_detalle, $menu_id_detalle, $consumo;

  public function __construct()
  {
    parent::__construct();
    $this->id_menu = $this->des_menu = $this->estatus_menu = $this->des_procedimiento = null;
    $this->des_comida_detalle = $this->med_comida_detalle = $this->menu_id_detalle = $this->consumo = null;
  }

  public function setDatos($d)
  {
    $this->id_menu = isset($d["id_menu"]) ? $this->Clean(intval($d["id_menu"]))  : null;
    $this->des_menu = isset($d["des_menu"]) ? $this->Clean($d["des_menu"]) : null;
    $this->des_procedimiento = isset($d['des_procedimiento']) ? $this->Clean($d['des_procedimiento']) : null;
    $this->estatus_menu = isset($d["estatus_menu"]) ? $this->Clean($d["estatus_menu"]) : null;
    $this->porcion = isset($d["porcion"]) ? $this->Clean($d["porcion"]) : null;
    $this->des_comida_detalle = isset($d['des_comida_detalle']) ? $d['des_comida_detalle']  : null;
    $this->med_comida_detalle = isset($d['med_comida_detalle']) ? $d['med_comida_detalle']  : null;
    $this->menu_id_detalle = isset($d["menu_id_detalle"]) ? $this->Clean(intval($d["menu_id_detalle"]))  : null;
    $this->consumo = isset($d["consumo"]) ? $d["consumo"]  : null;
  }

  public function Create()
  {
    try {
      // TRANSACCTION
      $status_transaccion = true;
      $result = $this->Query("SELECT * FROM menu WHERE des_menu = '$this->des_menu'");
      if ($result->num_rows > 0) return "err/02ERR";

      $this->Start_transacction();
      $sql1 = "INSERT INTO menu(des_menu, des_procedimiento, porcion, status_menu, created_menu) 
      VALUES('$this->des_menu', '$this->des_procedimiento', $this->porcion, 1, NOW());";
      $this->Query($sql1);

      if ($this->Result_last_query()) {
        $id = $this->Returning_id();
        $count = sizeof($this->des_comida_detalle);
        for ($i = 0; $i < $count; $i++) {
          // $item = $this->product_id_menu_detalle[$i];
          $consumo = $this->consumo[$i];
          $des = $this->des_comida_detalle[$i];
          $med = $this->med_comida_detalle[$i];
          $sql2 = "INSERT INTO menu_detalle(menu_id_detalle, consumo, des_comida_detalle, med_comida_detalle) VALUES($id,$consumo,'$des','$med')";

          $this->Query($sql2);

          if (!$this->Result_last_query()) {
            $status_transaccion = false;
            die("FINALLL");
            break;
          }
        }
      } else {
        $status_transaccion = false;
        die("FINAL");
        $this->Rollback();
      }

      if ($status_transaccion) {
        $this->End_transacction();
        return "msg/01DONE";
      } else {
        $this->Rollback();
        return "err/01ERR";
      }
    } catch (Exception $e) {
      die("AH OCURRIDO UN ERROR: " . $e->getMessage());
    }
  }

  public function Update()
  {
    $result = $this->Query("SELECT * FROM menu WHERE des_menu = '$this->des_menu' AND id_menu != $this->id_menu ;");
    if ($result->num_rows > 0) return ["code" => "error", "message" => "Los datos no se pueden duplicar"];

    $sql = "UPDATE menu SET des_menu = '$this->des_menu', des_procedimiento = '$this->des_procedimiento',
    porcion = $this->porcion WHERE id_menu = $this->id_menu ;";
    $this->Query($sql);

    $sqlDelete = "DELETE FROM menu_detalle WHERE menu_id_detalle = $this->id_menu";
    $this->Query($sqlDelete);

    $count = sizeof($this->des_comida_detalle);
    for ($i = 0; $i < $count; $i++) {
      $consumo = $this->consumo[$i];
      $des = $this->des_comida_detalle[$i];
      $med = $this->med_comida_detalle[$i];
      $sql2 = "INSERT INTO menu_detalle(menu_id_detalle, consumo, des_comida_detalle, med_comida_detalle) VALUES($this->id_menu,$consumo,'$des','$med')";

      $this->Query($sql2);
    }

    if ($this->Result_last_query()) return ["code" => "success", "message" => "Operación Exitosa"];
    else return ["code" => "error", "message" => "Operación Fallida"];
  }

  public function Disable()
  {

    $sql = "UPDATE menu SET status_menu = $this->estatus_menu WHERE id_menu = $this->id_menu ;";
    $this->Query($sql);

    if ($this->Result_last_query()) return ["code" => "success", "message" => "Operación Exitosa"];
    else return ["code" => "error", "message" => "Operación Fallida"];
  }

  public function Delete()
  {
    $sql = "DELETE FROM menu WHERE id_menu = $this->id_menu AND estatus_menu = '0' ;";
    $this->Query($sql);

    if ($this->Result_last_query()) return ["code" => "success", "message" => "Operación Exitosa"];
    else return ["code" => "error", "message" => "Operación Fallida"];
  }

  public function Get_todos_menu($status = '')
  {
    if ($status != '') $sql = "SELECT * FROM menu WHERE estatus_menu = $status";
    else $sql = "SELECT * FROM menu ";
    $results = $this->query($sql);
    return $this->Get_todos_array($results);
  }

  public function Get_menu()
  {
    $sql = "SELECT * FROM menu WHERE id_menu = $this->id_menu ;";
    $sql2 = "SELECT * FROM menu_detalle WHERE menu_id_detalle = $this->id_menu";
    $results = $this->Query($sql);
    $result2 = $this->Query($sql2);
    $datos_generales = $this->Get_array($results);
    $datos_comidas = $this->Get_todos_array($result2);
    return [$datos_generales, $datos_comidas];
  }

  public function GetPdf($post)
  {
    $menu = [];
    $desde = $post['desde'];
    $hasta = $post['hasta'];
    $sql = "SELECT * FROM menu WHERE created_menu BETWEEN '$desde' AND '$hasta';";
    $datos_menu = $this->Get_todos_array($this->Query($sql));

    foreach ($datos_menu as $item) {
      $id = $item['id_menu'];
      $sql2 = "SELECT * FROM menu_detalle WHERE menu_id_detalle = $id";
      $datos_menu_detalle = $this->Get_todos_array($this->Query($sql2));
      array_push($menu, ['menu' => $item,'detalle' => $datos_menu_detalle]);
    }

    return $menu;
  }
}
