<?php

if (!class_exists("m_db")) require("m_db.php");

class m_menu extends m_db
{
  private $id_menu, $des_menu, $des_procedimiento, $estatus_menu, $med_comida_detalle;
  private $des_comida_detalle, $product_id_menu_detalle, $menu_id_detalle, $consumo;

  public function __construct()
  {
    parent::__construct();
    $this->id_menu = $this->des_menu = $this->estatus_menu = $this->des_procedimiento = $this->med_comida_detalle = null;
    $this->des_comida_detalle = $this->product_id_menu_detalle = $this->menu_id_detalle = $this->consumo = null;
  }

  public function setDatos($d)
  {
    $this->id_menu = isset($d["id_menu"]) ? $this->Clean(intval($d["id_menu"]))  : null;
    $this->des_menu = isset($d["des_menu"]) ? $this->Clean($d["des_menu"]) : null;
    $this->des_procedimiento = isset($d['des_procedimiento']) ? $this->Clean($d['des_procedimiento']) : null;
    $this->estatus_menu = isset($d["estatus_menu"]) ? $this->Clean($d["estatus_menu"]) : null;
    // $this->porcion = isset($d["porcion"]) ? $this->Clean($d["porcion"]) : null;
    // $this->des_comida_detalle = isset($d['des_comida_detalle']) ? $d['des_comida_detalle']  : null;
    $this->med_comida_detalle = isset($d['med_comida_detalle']) ? $d['med_comida_detalle']  : [];
    $this->menu_id_detalle = isset($d["menu_id_detalle"]) ? $this->Clean(intval($d["menu_id_detalle"]))  : null;
    $this->consumo = isset($d["consumo"]) ? $d["consumo"]  : [];
    $this->product_id_menu_detalle = isset($d['comidas']) ? $d['comidas'] : [];
  }

  public function Create()
  {
    try {
      // TRANSACCTION
      $status_transaccion = true;
      $result = $this->Query("SELECT * FROM menu WHERE des_menu = '$this->des_menu'");
      if ($result->num_rows > 0) return "err/02ERR";

      $this->Start_transacction();
      $sql1 = "INSERT INTO menu(des_menu, des_procedimiento, status_menu, created_menu) 
      VALUES('$this->des_menu', '$this->des_procedimiento', 1, NOW());";
      $this->Query($sql1);

      if ($this->Result_last_query()) {
        $id = $this->Returning_id();
        $count = sizeof($this->product_id_menu_detalle);
        for ($i = 0; $i < $count; $i++) {
          $item = $this->product_id_menu_detalle[$i];
          $consumo = $this->consumo[$i];
          $med = $this->med_comida_detalle[$i];
          $sql2 = "INSERT INTO menu_detalle(menu_id_detalle,product_id_menu_detalle,consumo,med_comida_detalle) VALUES($id,$item,$consumo,'$med')";
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
        if(!isset($_SESSION['user_id'])) session_start();
        $this->reg_bitacora([
          'user_id' => $_SESSION['user_id'],
          'table_name'=> "MENU - MENU_DETALE",
          'des' => "TRANSACIÓN DE REGISTRO DEL MENÚ: $this->des_menu, ID DEL MENÚ: $id"
        ]);

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

    $sql = "UPDATE menu SET des_menu = '$this->des_menu', des_procedimiento = '$this->des_procedimiento' 
    WHERE id_menu = $this->id_menu ;";
    $this->Query($sql);

    $sqlDelete = "DELETE FROM menu_detalle WHERE menu_id_detalle = $this->id_menu";
    $this->Query($sqlDelete);

    $count = sizeof($this->product_id_menu_detalle);
    for ($i = 0; $i < $count; $i++) {
      $item = $this->product_id_menu_detalle[$i];
      $consumo = $this->consumo[$i];
      $med = $this->med_comida_detalle[$i];
      $sql2 = "INSERT INTO menu_detalle(menu_id_detalle,product_id_menu_detalle,consumo,med_comida_detalle) VALUES($this->id_menu,$item,$consumo,'$med')";

      $this->Query($sql2);
    }

    if(!isset($_SESSION['user_id'])) session_start();
            
    if($this->Result_last_query()){
      $this->reg_bitacora([
        'user_id' => $_SESSION['user_id'],
        'table_name'=> "MENU - MENU_DETALLE",
        'des' => "ACTUALIZACIÓN DE MENÚ Y DETALLES DEL MENÚ: $this->des_menu, ID DEL MENU: $this->id_menu"
      ]);

      return ["code" => "success", "message" => "Operación Exitosa"];
    }
    else return ["code" => "error", "message" => "Operación Fallida"];
  }

  public function Update_cantidad()
  {
    $sqlDelete = "DELETE FROM menu_detalle WHERE menu_id_detalle = $this->id_menu";
    $this->Query($sqlDelete);

    $count = sizeof($this->product_id_menu_detalle);
    for ($i = 0; $i < $count; $i++) {
      $item = $this->product_id_menu_detalle[$i];
      $consumo = $this->consumo[$i];
      $med = $this->med_comida_detalle[$i];
      $sql2 = "INSERT INTO menu_detalle(menu_id_detalle,product_id_menu_detalle,consumo,med_comida_detalle) VALUES($this->id_menu,$item,$consumo,'$med')";

      $this->Query($sql2);
    }

    if(!isset($_SESSION['user_id'])) session_start();
            
    if($this->Result_last_query()){
      $this->reg_bitacora([
        'user_id' => $_SESSION['user_id'],
        'table_name'=> "MENU - MENU_DETALLE",
        'des' => "ACTUALIZACIÓN DETALLES DEL MENÚ => ID DEL MENU: $this->id_menu"
      ]);

      return ["code" => "success", "message" => "Operación Exitosa"];
    }
    else return ["code" => "error", "message" => "Operación Fallida"];
  }

  public function Disable()
  {

    $sql = "UPDATE menu SET status_menu = $this->estatus_menu WHERE id_menu = $this->id_menu ;";
    $this->Query($sql);

    if(!isset($_SESSION['user_id'])) session_start();
            
    if($this->Result_last_query()){
      if($this->estatus_menu == 0) $des_estatus = "DESACTIVACIÓN"; else $des_estatus = "ACTIVACIÓN";
      $this->reg_bitacora([
        'user_id' => $_SESSION['user_id'],
        'table_name'=> "MENU",
        'des' => "$des_estatus DEL MENU: ID => $this->id_menu"
      ]);

      return ["code" => "success", "message" => "Operación Exitosa"];
    }
    else return ["code" => "error", "message" => "Operación Fallida"];  
  }

  public function Delete()
  {
    $sql = "DELETE FROM menu WHERE id_menu = $this->id_menu AND estatus_menu = '0' ;";
    $this->Query($sql);

    if(!isset($_SESSION['user_id'])) session_start();
            
    if($this->Result_last_query()){
      $this->reg_bitacora([
        'user_id' => $_SESSION['user_id'],
        'table_name'=> "MENÚ",
        'des' => "ELIMINACIÓN DEL MENÚ: ID => $this->id_menu"
      ]);

      return ["code" => "success", "message" => "Operación Exitosa"];
    }
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
    $sql2 = "SELECT * FROM menu_detalle INNER JOIN productos ON productos.id_product = menu_detalle.product_id_menu_detalle WHERE menu_id_detalle = $this->id_menu";
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
      $sql2 = "SELECT * FROM menu_detalle INNER JOIN productos ON productos.id_product = menu_detalle.product_id_menu_detalle WHERE menu_id_detalle = $id";
      $datos_menu_detalle = $this->Get_todos_array($this->Query($sql2));
      array_push($menu, ['menu' => $item, 'detalle' => $datos_menu_detalle]);
    }

    return $menu;
  }
}
