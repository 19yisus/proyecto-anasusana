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
    $this->verificarJornadas();
    try {

      $fechaFormateada = date_create($this->fecha_jornada)->format('Y-m-d');

      $sql1 = "INSERT INTO `jornada` (`titulo_jornada`, `des_jornada`, `cant_aproximada`, `estatus_jornada`, `fecha_jornada`, `menu_id_jornada`, `person_id_responsable`) VALUES('$this->titulo_jornada', '$this->des_jornada', $this->cant_aproximada, 1, '$fechaFormateada', $this->menu_id_jornada, $this->responsable)";

      $this->Query($sql1);

      if (!isset($_SESSION['user_id'])) session_start();

      if ($this->Result_last_query()) {
        $this->reg_bitacora([
          'user_id' => $_SESSION['user_id'],
          'table_name' => "JORNADA",
          'des' => "REGISTRO DE NUEVA JORNADA: $this->titulo_jornada, DESCRIPCIÓN: $this->des_jornada, CANTIDAD APROXIMADA DE BENEFICIADOS: $this->cant_aproximada"
        ]);
        return "msg/01DONE";
      } else return "err/01ERR";
    } catch (Exception $e) {
      die("AH OCURRIDO UN ERROR: " . $e->getMessage());
    }
  }

  public function Update()
  {
    $this->verificarJornadas();
    $result = $this->Get_todos_array($this->Query("SELECT * FROM jornada WHERE titulo_jornada = '$this->titulo_jornada' AND id_jornada != $this->id_jornada AND fecha_jornada = '$this->fecha_jornada';"));
    if (isset($result[0])) return ["code" => "error", "message" => "Los datos no se pueden duplicar"];

    $sql = "UPDATE jornada SET 
    des_jornada = '$this->des_jornada', 
    fecha_jornada = '$this->fecha_jornada',
    cant_aproximada = '$this->cant_aproximada',
    titulo_jornada = '$this->titulo_jornada',
    menu_id_jornada = $this->menu_id_jornada,
    person_id_responsable = $this->responsable
    WHERE id_jornada = $this->id_jornada ;";

    $this->Query($sql);

    if (!isset($_SESSION['user_id'])) session_start();

    if ($this->Result_last_query()) {
      $this->reg_bitacora([
        'user_id' => $_SESSION['user_id'],
        'table_name' => "JORNADA",
        'des' => "ACTUALIZACIÓN DE JORNADA: $this->titulo_jornada, DESCRIPCIÓN: $this->des_jornada, CANTIDAD APROXIMADA DE BENEFICIADOS: $this->cant_aproximada, ID DEL MENÚ => $this->menu_id_jornada"
      ]);

      return ["code" => "success", "message" => "Operación Exitosa"];
    } else return ["code" => "error", "message" => "Operación Fallida"];
  }

  public function Update_cantidad()
  {
    $this->verificarJornadas();
    $sql = "UPDATE jornada SET 
    cant_aproximada = '$this->cant_aproximada',
    menu_id_jornada = $this->menu_id_jornada
    WHERE id_jornada = $this->id_jornada ;";

    $this->Query($sql);

    if (!isset($_SESSION['user_id'])) session_start();

    if ($this->Result_last_query()) {
      $this->reg_bitacora([
        'user_id' => $_SESSION['user_id'],
        'table_name' => "JORNADA",
        'des' => "ACTUALIZACIÓN DE JORNADA -CANTIDAD APROXIMADA DE BENEFICIADOS: $this->cant_aproximada, ID DEL MENÚ => $this->menu_id_jornada"
      ]);

      return ["code" => "success", "message" => "Operación Exitosa"];
    } else return ["code" => "error", "message" => "Operación Fallida"];
  }

  // public function Disable()
  // {

  //   $sql = "UPDATE jornada SET status_jornada = $this->estatus_jornada WHERE id_jornada = $this->id_jornada ;";
  //   $this->Query($sql);

  //   if ($this->Result_last_query()) return ["code" => "success", "message" => "Operación Exitosa"];
  //   else return ["code" => "error", "message" => "Operación Fallida"];
  // }

  // public function Delete()
  // {
  //   $sql = "DELETE FROM jornada WHERE id_jornada = $this->id_jornada AND estatus_jornada = '0' ;";
  //   $this->Query($sql);

  //   if ($this->Result_last_query()) return ["code" => "success", "message" => "Operación Exitosa"];
  //   else return ["code" => "error", "message" => "Operación Fallida"];
  // }

  public function Get_todos_jornada($status = '')
  {
    $this->verificarJornadas();
    if ($status != '') $sql = "SELECT * FROM jornada WHERE estatus_jornada = $status";
    else $sql = "SELECT * FROM jornada 
      INNER JOIN personas ON personas.id_person = jornada.person_id_responsable 
      INNER JOIN menu ON menu.id_menu = jornada.menu_id_jornada";
    $results = $this->query($sql);
    return $this->Get_todos_array($results);
  }

  public function Get_jornada()
  {
    $this->verificarJornadas();
    $sql = "SELECT * FROM jornada INNER JOIN menu ON menu.id_menu = jornada.menu_id_jornada WHERE jornada.id_jornada = $this->id_jornada ;";
    $results = $this->Query($sql);
    $datos_jornada = $this->Get_array($results);

    $id = $datos_jornada['menu_id_jornada'];

    $sql2 = "SELECT * FROM menu 
      INNER JOIN menu_detalle ON menu_detalle.menu_id_detalle = menu.id_menu 
      INNER JOIN productos ON productos.id_product = menu_detalle.product_id_menu_detalle
      WHERE id_menu = $id";
    $results2 = $this->Query($sql2);
    $datos_menu = $this->Get_todos_array($results2);
    return [$datos_jornada, $datos_menu];
  }

  public function Get_jornada_hoy()
  {
    $this->verificarJornadas();
    $unixTime = time();
    $timeZone = new \DateTimeZone('America/Caracas');

    $time = new \DateTime();
    $time->setTimestamp($unixTime)->setTimezone($timeZone);
    $fecha = $time->format('Y-m-d');
    $sql = "SELECT * FROM jornada WHERE fecha_jornada = '$fecha' AND estatus_jornada = 1";

    $results = $this->query($sql);
    return $this->Get_todos_array($results);
  }

  public function verificarJornadas()
  {
    $unixTime = time();
    $timeZone = new \DateTimeZone('America/Caracas');

    $time = new \DateTime();
    $time->setTimestamp($unixTime)->setTimezone($timeZone);
    $fecha = $time->format('Y-m-d');
    $this->Query("UPDATE jornada SET estatus_jornada = 0 WHERE fecha_jornada < '$fecha';");
    if (!isset($_SESSION['user_id'])) session_start();

    if ($this->Result_last_query()) {
      $this->reg_bitacora([
        'user_id' => $_SESSION['user_id'],
        'table_name' => "JORNADA",
        'des' => "DESACTIVACIÓN AUTOMATICA DE LA JORNADA EN SESIÓN DEL USUARIO: " . $_SESSION['user_id']
      ]);

      return ["code" => "success", "message" => "Operación Exitosa"];
    } else return ["code" => "error", "message" => "Operación Fallida"];
  }

  public function GetPdf($post)
  {
    $menu = [];
    $desde = $post['desde'];
    $hasta = $post['hasta'];
    $sql = "SELECT * FROM jornada 
    INNER JOIN menu ON menu.id_menu = jornada.menu_id_jornada WHERE jornada.fecha_jornada BETWEEN '$desde' AND '$hasta';";
    $datos_menu = $this->Get_todos_array($this->Query($sql));

    foreach ($datos_menu as $item) {
      $id = $item['id_menu'];
      $sql2 = "SELECT * FROM menu_detalle INNER JOIN productos ON productos.id_product = menu_detalle.product_id_menu_detalle WHERE menu_id_detalle = $id";
      $datos_menu_detalle = $this->Get_todos_array($this->Query($sql2));
      array_push($menu, ['jornada_menu' => $item, 'detalle_menu' => $datos_menu_detalle]);
    }

    return $menu;
  }
}
