<?php
require_once("../models/m_entrada_salida.php");
require_once("../models/m_productos.php");
require_once("../models/m_menu.php");
require_once("../models/m_jornada.php");
require_once("../models/fpdf/fpdf.php");
class new_fpdf extends FPDF
{
  private $nombre;

  public function SetNombre($name, $des = '')
  {
    $this->nombre = $name;
    $this->des = $des;
    $this->AliasNbPages();
  }
  public function Header()
  {
    $this->SetFont("Arial", "B", 14);
    $this->write(5, utf8_decode("ANA SUSSANA DE OUSSET, Acarigua - Portuguesa"));
    $this->Image("../views/images/logo.png", 150, 5, 45, 40, "PNG");
    $this->Ln();
    $this->write(5, utf8_decode("$this->nombre"));
    $this->Ln(2);
    $this->write(5, utf8_decode("$this->des"));
    $this->Ln(30);
  }

  public function Footer()
  {
    $this->SetFont("Arial", "B", 14);
    $this->SetY(-15);
    $this->SetX(-20);
    $this->write(5, utf8_decode("Página número: " . $this->PageNo() . '/{nb}'));
  }
}

if (isset($_POST['ope'])) {
  switch ($_POST['ope']) {
    case "pdf_entrada":
      fn_pdf_entrada();
      break;

    case "pdf_salida":
      fn_pdf_salida();
      break;

    case "Entrada":
      fn_pdf_filtrado();
      break;

    case "Salida":
      fn_pdf_filtrado();
      break;

    case "Productos":
      fn_pdf_productos();
      break;

    case "Menu":
      fn_pdf_menu();
      break;

    case "Jornada":
      fn_pdf_Jornada();
      break;
  }
}

function fn_pdf_entrada()
{
  $conceptos = [
    'C' => "Compra",
    'D' => "Donacion",
  ];

  $model = new m_entrada_salida();
  $d = $model->GetPdf($_POST['id_invent'])[0];

  // die("DFD"); 
  $fecha = new DateTime($d['doc']['fecha']);

  if (!isset($d['productos'][0][0])) {
    die("No hay información suficiente");
  }

  $pdf = new new_fpdf();
  $pdf->SetNombre("Entrada de productos");
  $pdf->addPage();
  $pdf->setFont('Arial', 'B', 12);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->cell(70, 5, utf8_decode("Numero de operación: " . $d['doc']['id']), 0, 1, 'L');
  $pdf->cell(70, 5, utf8_decode("Fecha de la operación: " . $fecha->format("d-m-Y h:i a")), 0, 1, 'L');
  $pdf->cell(70, 5, utf8_decode("N-Orden: " . $d['doc']['orden']), 0, 1, 'L');
  $pdf->cell(90, 5, utf8_decode("Proveedor: " . $d['persona'][0]['proveedor']['tipo_persona'] . "-" . $d['persona'][0]['proveedor']['cedula'] . " " . $d['persona'][0]['proveedor']['nom']), 0, 1, 'L');
  $pdf->cell(80, 5, utf8_decode("Concepto de entrada: " . $conceptos[$d['doc']['concepto']]), 0, 1, 'L');
  $pdf->cell(80, 5, utf8_decode("Comedor: " . $d['comedor']['nom']), 0, 1, 'L');
  $pdf->Ln(2);
  $pdf->setFont('Arial', 'B', 11);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetFillColor(253, 234, 13);
  $pdf->SetDrawColor(88, 88, 88);
  $pdf->cell(190, 8, utf8_decode("Descripción general de los productos"), 1, 1, "C", 1);
  $pdf->SetFillColor(255, 255, 255);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->cell(190, 8, utf8_decode("Observación: " . $d['doc']['observacion']), 1, 1, "C", 1);
  $pdf->SetFillColor(253, 234, 13);
  $pdf->SetDrawColor(88, 88, 88);
  $pdf->cell(16, 7, utf8_decode("Código"), 1, 0, "C", 1);
  $pdf->cell(80, 7, utf8_decode("Descripción"), 1, 0, "C", 1);
  // $pdf->cell(48,7,"Fecha de vencimiento",1,0,"C",1);
  // $pdf->cell(30,7,"Grupo",1,0,"C",1);
  $pdf->cell(20, 7, utf8_decode("Medida"), 1, 0, "C", 1);
  $pdf->cell(26, 7, utf8_decode("Catidad"), 1, 0, "C", 1);
  $pdf->cell(48, 7, utf8_decode("Precio"), 1, 1, "C", 1);
  $pdf->SetFillColor(255, 255, 255);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->setFont('Arial', 'B', 9);
  foreach ($d['productos'][0] as $dato) {
    $pdf->cell(16, 7, utf8_decode($dato['id_product']), 1, 0, "C", 1);
    $pdf->cell(80, 7, utf8_decode($dato['nom_product']), 1, 0, "C", 1);
    // $pdf->cell(48,7,$dato['fecha_vencimiento_ope'],1,0,"C",1);
    // $pdf->cell(30,7,$dato['nom_grupo'],1,0,"C",1);
    $pdf->cell(20, 7, utf8_decode($dato['valor_product'] . " " . $dato['med_product']), 1, 0, "C", 1);
    $pdf->cell(26, 7, utf8_decode($dato['detalle_cantidad']), 1, 0, "C", 1);
    $pdf->cell(48, 7, utf8_decode($dato['precio_product_ope'] . "Bs."), 1, 1, "C", 1);
  }
  $pdf->Output();
}

function fn_pdf_salida()
{
  $conceptos = [
    'V' => "Vencimiento",
    'R' => "Remanente",
    'O' => "Consumo",
  ];

  $model = new m_entrada_salida();
  $d = $model->GetPdf($_POST['id_invent'])[0];
  $fecha = new DateTime($d['doc']['fecha']);

  if (!isset($d['productos'][0][0])) {
    die("No hay información suficiente");
  }

  $pdf = new new_fpdf();
  $pdf->SetNombre("Salida de productos");
  $pdf->addPage();
  $pdf->setFont('Arial', 'B', 12);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->cell(70, 5, utf8_decode("Número de operación: " . $d['doc']['id']), 0, 1, 'L');
  $pdf->cell(70, 5, utf8_decode("Fecha de la operación: " . $fecha->format("d-m-Y h:i a")), 0, 1, 'L');
  // $pdf->cell(70, 5, utf8_decode("N-Orden: " . $d['doc']['orden']), 0, 1, 'L');
  $pdf->cell(90, 5, utf8_decode("Receptor: " . $d['persona'][0]['quien_recibe']['tipo_persona'] . "-" . $d['persona'][0]['quien_recibe']['cedula'] . " " . $d['persona'][0]['quien_recibe']['nom']), 0, 1, 'L');
  $pdf->cell(80, 5, utf8_decode("Concepto de salida: " . $conceptos[$d['doc']['concepto']]), 0, 1, 'L');
  $pdf->cell(80, 5, utf8_decode("Comedor: " . $d['comedor']['nom']), 0, 1, 'L');
  $pdf->Ln(2);
  $pdf->setFont('Arial', 'B', 11);
  // $pdf->SetTextColor(255, 255, 255);
  // $pdf->SetFillColor(11, 63, 71);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetFillColor(253, 234, 13);
  $pdf->cell(190, 8, utf8_decode("Salida de productos"), 1, 1, "C", 1);
  $pdf->SetFillColor(255, 255, 255);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetDrawColor(88, 88, 88);
  $pdf->cell(190, 8, utf8_decode("Observación: " . $d['doc']['observacion']), 1, 1, "C", 1);
  // var_dump($d['doc']);
  if ($d['doc']['id_jornada']) {
    $pdf->cell(190, 8, utf8_decode("Jornada del dia: " . $d['doc']['titulo_jornada']), 1, 1, "C", 1);
    $pdf->cell(190, 8, utf8_decode("Jornada del dia: " . $d['doc']['des_jornada']), 1, 1, "C", 1);
    $pdf->cell(100, 8, utf8_decode("Menú del dia: " . $d['doc']['des_menu']), 1, 0, "C", 1);
    $pdf->cell(90, 8, utf8_decode("Cantidad de platos aproximada: " . $d['doc']['cant_aproximada']), 1, 1, "C", 1);
    // die("Hay jornada");
  }
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetFillColor(253, 234, 13);
  $pdf->cell(190, 8, utf8_decode("Descripción general de los productos"), 1, 1, "C", 1);
  $pdf->cell(16, 7, utf8_decode("Código"), 1, 0, "C", 1);
  $pdf->cell(80, 7, utf8_decode("Descripción"), 1, 0, "C", 1);
  // $pdf->cell(48,7,"Fecha de vencimiento",1,0,"C",1);
  // $pdf->cell(30,7,"Grupo",1,0,"C",1);
  $pdf->cell(20, 7, utf8_decode("Medida"), 1, 0, "C", 1);
  $pdf->cell(26, 7, utf8_decode("Cantidad"), 1, 0, "C", 1);
  $pdf->cell(48, 7, utf8_decode("Precio"), 1, 1, "C", 1);
  $pdf->SetFillColor(255, 255, 255);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->setFont('Arial', 'B', 9);
  foreach ($d['productos'][0] as $dato) {
    $pdf->cell(16, 7, utf8_decode($dato['id_product']), 1, 0, "C", 1);
    $pdf->cell(80, 7, utf8_decode($dato['nom_product']), 1, 0, "C", 1);
    // $pdf->cell(48,7,$dato['fecha_vencimiento_ope'],1,0,"C",1);
    // $pdf->cell(30,7,$dato['nom_grupo'],1,0,"C",1);
    $pdf->cell(20, 7, utf8_decode($dato['valor_product'] . " " . $dato['med_product']), 1, 0, "C", 1);
    $pdf->cell(26, 7, utf8_decode($dato['detalle_cantidad']), 1, 0, "C", 1);
    $pdf->cell(48, 7, utf8_decode($dato['precio_product_ope'] . "Bs."), 1, 1, "C", 1);
  }
  $pdf->Output();
}

function fn_pdf_filtrado()
{
  $model = new m_entrada_salida();
  $filtro = $_POST['filtro'];
  if ($filtro == "Compra") $f = "C";
  if ($filtro == "Donacion") $f = "D";
  if ($filtro == "Consumo") $f = "O";
  if ($filtro == "Vencimiento") $f = "V";
  if ($filtro == "Rechazo") $f = "R";
  if ($filtro == "Todas_entradas") $f = "E";
  if ($filtro == "Todas_salidas") $f = "S";
  if ($filtro == "Todas_entradas" || $filtro == "Todas_salidas") $desf = "Todas";
  else $desf = "";

  if (isset($_POST['filtro_extra']) && $_POST['filtro_extra'] != '') {
    $d = $model->GetPdfWithFiltros($f, $_POST['desde'], $_POST['hasta']);
  } else $d = $model->GetPdfWithFiltros($f);

  if (!isset($d[0])) {
    echo "<script>
      alert('No hay suficientes datos para generar este reporte!');
      window.close();
    </script>";
    exit;
  }
  // Entradas
  // if ($filtro == "Compra") $des_tipo = "Compra";
  // if ($filtro == "D") $des_tipo = "Donacion";
  if ($_POST['tipo_reporte'] == "Entrada") $tipo = "Entradas";
  // Salidas
  // if ($filtro == "O") $des_tipo = "Consumo";
  // if ($filtro == "V") $des_tipo = "Vencimiento";
  // if ($filtro == "R") $des_tipo = "Rechazo";
  if ($_POST['tipo_reporte'] == "Salida") $tipo = "Salidas";

  $pdf = new new_fpdf();
  if (isset($_POST['filtro_extra']) && $_POST['filtro_extra'] != '') {
    $date_desde = new DateTime($_POST['desde']);
    $date_hasta = new DateTime($_POST['hasta']);
    $desde_ = $date_desde->format('d-m-Y');
    $hasta_ = $date_hasta->format('d-m-Y');
    // echo $date_desde->format("d-m-Y");
    // echo $date_hasta->format('d-m-Y');

    $pdf->SetNombre("Reporte de operaciones de $tipo por " . ($desf == "" ? $filtro : $desf), "Entre las fechas ($desde_ y $hasta_)");
  } else {
    $pdf->SetNombre("Reporte de operaciones de $tipo por " . ($desf == "" ? $filtro : $desf));
  }

  $pdf->addPage();
  $pdf->Ln(10);
  $pdf->setFont('Arial', 'B', 10);
  foreach ($d as $dato) {
    $fecha = new DateTime($dato['invent']['created_invent']);

    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFillColor(253, 234, 13);
    $pdf->SetDrawColor(88, 88, 88);

    $pdf->cell(80, 7, utf8_decode("Código de la operacion: " . $dato['invent']['id_invent']), 1, 0, "C", 1);
    $pdf->cell(75, 7, utf8_decode("Fecha y Hora: " . $fecha->format("d/m/Y h:i a")), 1, 0, "C", 1);
    $pdf->cell(35, 7, utf8_decode("Cantidad total: " . $dato['invent']['cantidad_invent']), 1, 0, "C", 1);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Ln();
    $pdf->cell(120, 7, utf8_decode("Nombre del comedor : " . $dato['invent']['nom_comedor']), 1, 0, "C", 1);
    $pdf->cell(70, 7, utf8_decode("N-Orden: " . $dato['invent']['orden_invent']), 1, 0, "C", 1);
    $pdf->Ln();
    $pdf->Cell(190, 7, utf8_decode("Observación: " . $dato['invent']['observacion_invent']), 1, 1, "C", 1);
    $concepto = "";
    $concepto = ($dato['invent']['concept_invent'] == "O") ? "Consumo" : $concepto;
    $concepto = ($dato['invent']['concept_invent'] == "V") ? "Vencimiento" : $concepto;
    $concepto = ($dato['invent']['concept_invent'] == "R") ? "Remanente" : $concepto;
    $concepto = ($dato['invent']['concept_invent'] == "D") ? "Donación" : $concepto;
    $concepto = ($dato['invent']['concept_invent'] == "C") ? "Compra" : $concepto;

    $pdf->Cell(190, 7, utf8_decode("Concepto de operación: " . $concepto), 1, 0, "C", 1);
    $pdf->Ln();

    if ($filtro == "Compra" || $filtro == "Donacion" || $filtro == "Todas_entradas") {
      $pdf->SetTextColor(0, 0, 0);
      $pdf->SetFillColor(253, 234, 13);
      $pdf->cell(190, 7, utf8_decode('Datos del proveedor'), 1, 0, "C", 1);
      $pdf->SetFillColor(255, 255, 255);
      $pdf->SetTextColor(0, 0, 0);
      $pdf->Ln();
      $pdf->cell(35, 7, utf8_decode($dato['persona']['proveedor']['tipo_persona'] . "-" . $dato['persona']['proveedor']['cedula']), 1, 0, "C", 1);
      $pdf->cell(110, 7, utf8_decode($dato['persona']['proveedor']['nom']), 1, 0, "C", 1);
      $pdf->cell(45, 7, utf8_decode("Telf: " . $dato['persona']['proveedor']['telf']), 1, 0, "C", 1);
      $pdf->Ln();
    } else {
      $pdf->SetTextColor(0, 0, 0);
      $pdf->SetFillColor(253, 234, 13);
      $pdf->cell(190, 7, utf8_decode('Datos de quien recibe los alimentos'), 1, 0, "C", 1);
      $pdf->SetFillColor(255, 255, 255);
      $pdf->SetTextColor(0, 0, 0);
      $pdf->Ln();
      $pdf->cell(35, 7, utf8_decode($dato['persona']['quien_recibe']['tipo_persona'] . "-" . $dato['persona']['quien_recibe']['cedula']), 1, 0, "C", 1);
      $pdf->cell(110, 7, utf8_decode($dato['persona']['quien_recibe']['nom']), 1, 0, "C", 1);
      $pdf->cell(45, 7, utf8_decode("Telf: " . $dato['persona']['quien_recibe']['telf']), 1, 0, "C", 1);
      $pdf->Ln();
    }

    if ($filtro == "Consumo" || $filtro == "Todas_salidas" && isset($dato['invent']['titulo_jornada'])) {
      $pdf->SetTextColor(0, 0, 0);
      $pdf->SetFillColor(253, 234, 13);
      $pdf->cell(190, 7, utf8_decode('Jornada del dia'), 1, 0, "C", 1);
      $pdf->SetFillColor(255, 255, 255);
      $pdf->SetTextColor(0, 0, 0);
      $pdf->Ln();
      if (!isset($dato['invent']['titulo_jornada']) || $dato['invent']['titulo_jornada'] === "") {
        $titulo = "Sin titulo";
      } else $titulo = $dato['invent']['titulo_jornada'];
      $pdf->cell(100, 7, utf8_decode("Nombre: " . $titulo), 1, 0, "C", 1);
      $pdf->cell(90, 7, utf8_decode("Cantidad Aproximada de platos: " . $dato['invent']['cant_aproximada']), 1, 0, "C", 1);
      $pdf->Ln();
      $pdf->cell(190, 7, utf8_decode("Descripción de la jornada: " . $dato['invent']['des_jornada']), 1, 0, "C", 1);
      $pdf->Ln();
      $pdf->SetTextColor(0, 0, 0);
      $pdf->SetFillColor(253, 234, 13);
      $pdf->cell(190, 7, utf8_decode('Menú del dia'), 1, 0, "C", 1);
      $pdf->SetFillColor(255, 255, 255);
      $pdf->SetTextColor(0, 0, 0);
      $pdf->Ln();
      // $pdf->cell(100, 7, "Nombre: " . ($dato['invent']['des_menu'] !== "NULL") ? $dato['invent']['des_menu'] : "Sin titulo", 1, 0, "C", 1);
      // $pdf->Ln();
      $pdf->cell(190, 7, utf8_decode("Descripción del menu: " . $dato['invent']['des_menu']), 1, 0, "C", 1);
      $pdf->Ln();
    }
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFillColor(253, 234, 13);
    $pdf->SetDrawColor(88, 88, 88);

    $pdf->cell(190, 7, utf8_decode('Datos de los productos'), 1, 0, "C", 1);
    $pdf->Ln();
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->setFont('Arial', 'B', 9);
    foreach ($dato['products'] as $prod) {
      $pdf->cell(50, 7, utf8_decode("" . $prod['nom_product']), 1, 0, "C", 1);
      $pdf->cell(15, 7, utf8_decode($prod['valor_product'] . " " . $prod['med_product']), 1, 0, "C", 1);
      $pdf->cell(35, 7, utf8_decode("Cantidad c/u: " . $prod['detalle_cantidad']), 1, 0, "C", 1);
      $pdf->cell(40, 7, utf8_decode("Precio c/u: " . $prod['precio_product_ope'] . "Bs."), 1, 0, "C", 1);
      $pdf->cell(50, 7, utf8_decode("Marca: " . $prod['nom_marca']), 1, 0, "C", 1);
      $pdf->Ln();
    }
    $pdf->Ln(10);
  }

  $pdf->Output();
}

function fn_pdf_productos()
{
  $model = new m_productos();

  if (isset($_POST['id'])) $id =  $_POST['id'];
  else $id = "";
  $dato = $model->GetPdf($_POST['filtro'],  $id);

  $pdf = new new_fpdf();

  if ($_POST['filtro'] == "Todos") $des_report = "Todos los productos";
  if ($_POST['filtro'] == "Marcas") $des_report = "Todos los productos según su Marca";
  if ($_POST['filtro'] == "Unidades") $des_report = "Todos los productos según su presentación";
  if ($_POST['filtro'] == "Stock_max") $des_report = "Todos los productos según su stock maximo";

  $pdf->SetNombre($des_report);
  $pdf->addPage();
  $pdf->Ln(10);
  $pdf->setFont('Arial', 'B', 10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetFillColor(253, 234, 13);
  $pdf->SetDrawColor(88, 88, 88);
  $pdf->cell(190, 7, utf8_decode('Datos de los productos'), 1, 0, "C", 1);
  $pdf->Ln();
  $pdf->cell(70, 7, utf8_decode('Descripción'), 1, 0, "C", 1);
  $pdf->cell(50, 7, utf8_decode('Marca'), 1, 0, "C", 1);
  $pdf->cell(70, 7, utf8_decode('Información del stock'), 1, 0, "C", 1);
  $pdf->Ln();
  $pdf->SetFillColor(255, 255, 255);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->setFont('Arial', 'B', 9);
  foreach ($dato as $prod) {
    $pdf->cell(55, 7, utf8_decode($prod['nom_product']), 1, 0, "C", 1);
    $pdf->cell(15, 7, utf8_decode($prod['valor_product'] . " " . $prod['med_product']), 1, 0, "C", 1);
    $pdf->cell(50, 7, utf8_decode($prod['nom_marca']), 1, 0, "C", 1);
    $pdf->cell(35, 7, utf8_decode("Stock maximo: " . $prod['stock_maximo_product']), 1, 0, "C", 1);
    $pdf->cell(35, 7, utf8_decode("Stock en almacen: " . $prod['stock_product']), 1, 0, "C", 1);
    $pdf->Ln();
  }
  $pdf->Output();
}

function fn_pdf_menu()
{
  $model = new m_menu();
  $menu = $model->GetPdf($_POST);
  $pdf = new new_fpdf();

  if ($_POST['filtro_extra'] == "Fecha_registro") $des_report = "Todos los menus por fecha de registro";

  $pdf->SetNombre($des_report);
  $pdf->addPage();
  $pdf->Ln(10);
  $pdf->setFont('Arial', 'B', 10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetFillColor(253, 234, 13);
  $pdf->SetDrawColor(88, 88, 88);

  foreach ($menu as $item_menu) {
    $fecha = new DateTime($item_menu['menu']['created_menu']);
    $pdf->cell(190, 7, utf8_decode('Datos de los menus'), 1, 0, "C", 1);
    $pdf->Ln();
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->cell(100, 7, utf8_decode('Descripción del menú: ' . $item_menu['menu']['des_menu']), 1, 0, "C", 1);
    $pdf->cell(90, 7, utf8_decode("Fecha de creación: " . $fecha->format("d-m-Y")), 1, 0, "C", 1);
    $pdf->Ln();
    $pdf->cell(190, 7, utf8_decode("Procedimiento: " . $item_menu['menu']['des_procedimiento']), 1, 0, "C", 1);
    $pdf->Ln();
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFillColor(253, 234, 13);
    $pdf->cell(190, 7, utf8_decode('Detalles del menú'), 1, 0, "C", 1);
    $pdf->Ln();
    $pdf->cell(150, 7, utf8_decode('Descripción del ingrediente'), 1, 0, "C", 1);
    $pdf->cell(40, 7, utf8_decode('Consumo'), 1, 0, "C", 1);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->setFont('Arial', 'B', 9);
    $pdf->Ln();
    foreach ($item_menu['detalle'] as $item_detalle) {
      $pdf->cell(150, 7, utf8_decode($item_detalle['nom_product']), 1, 0, "C", 1);
      $pdf->cell(40, 7, utf8_decode($item_detalle['consumo'] . " " . $item_detalle['med_comida_detalle']), 1, 0, "C", 1);
      $pdf->Ln();
    }
    $pdf->Ln(10);
  }
  $pdf->Output();
}

function fn_pdf_Jornada()
{
  $model = new m_jornada();
  $datos = $model->GetPdf($_POST);
  $pdf = new new_fpdf();

  if ($_POST['filtro_extra'] == "Fecha_registro") $des_report = "Todos las jornada por fecha";

  $pdf->SetNombre($des_report);
  $pdf->addPage();
  $pdf->Ln(10);
  $pdf->setFont('Arial', 'B', 10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetFillColor(253, 234, 13);
  $pdf->SetDrawColor(88, 88, 88);

  foreach ($datos as $item_jornada_menu) {
    $fecha = new DateTime($item_jornada_menu['jornada_menu']['created_menu']);
    $fecha2 = new DateTime($item_jornada_menu['jornada_menu']['fecha_jornada']);
    // INFORMACIÓN DE LA JORNADA
    $pdf->cell(190, 7, utf8_decode('Datos de la jornada'), 1, 0, "C", 1);
    $pdf->Ln();
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->cell(190, 7, utf8_decode("Título: " . $item_jornada_menu['jornada_menu']['titulo_jornada']), 1, 0, "C", 1);
    $pdf->Ln();
    $pdf->cell(190, 7, utf8_decode('Descripción del jornada: ' . $item_jornada_menu['jornada_menu']['des_jornada']), 1, 0, "C", 1);
    $pdf->Ln();
    $pdf->cell(80, 7, utf8_decode("Cantidad aproximada de benecifiados: " . $item_jornada_menu['jornada_menu']['cant_aproximada']), 1, 0, "C", 1);
    $pdf->cell(110, 7, utf8_decode("Fecha de creación: " . $fecha2->format("d-m-Y")), 1, 0, "C", 1);
    $pdf->Ln();
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFillColor(253, 234, 13);
    // INFORMACIÓN DEL MENU
    $pdf->cell(190, 7, utf8_decode('Datos del menú'), 1, 0, "C", 1);
    $pdf->Ln();
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->cell(100, 7, utf8_decode('Descripción del menu: ' . $item_jornada_menu['jornada_menu']['des_menu']), 1, 0, "C", 1);
    // $pdf->cell(80, 7, "Porcion: " . $item_jornada_menu['jornada_menu']['porcion'], 1, 0, "C", 1);
    $pdf->cell(90, 7, utf8_decode("Fecha de creación: " . $fecha->format("d-m-Y")), 1, 0, "C", 1);
    $pdf->Ln();
    $pdf->cell(190, 7, utf8_decode("Procedimiento: " . $item_jornada_menu['jornada_menu']['des_procedimiento']), 1, 0, "C", 1);
    $pdf->Ln();
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFillColor(253, 234, 13);
    $pdf->cell(190, 7, utf8_decode('Detalles del menú'), 1, 0, "C", 1);
    $pdf->Ln();
    $pdf->cell(150, 7, utf8_decode('Descripción del ingrediente'), 1, 0, "C", 1);
    $pdf->cell(40, 7, utf8_decode('Consumo'), 1, 0, "C", 1);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->setFont('Arial', 'B', 9);
    $pdf->Ln();
    foreach ($item_jornada_menu['detalle_menu'] as $item_detalle) {
      $pdf->cell(150, 7, utf8_decode($item_detalle['nom_product']), 1, 0, "C", 1);
      $pdf->cell(40, 7, utf8_decode($item_detalle['consumo'] . " " . $item_detalle['med_comida_detalle']), 1, 0, "C", 1);
      $pdf->Ln();
    }
    $pdf->Ln(10);
  }
  $pdf->Output();
}
