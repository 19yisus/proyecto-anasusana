<?php
require_once("../models/m_entrada_salida.php");
require_once("../models/fpdf/fpdf.php");
class new_fpdf extends FPDF
{
  private $nombre;

  public function SetNombre($name)
  {
    $this->nombre = $name;
  }
  public function Header()
  {
    $this->SetFont("Arial", "B", 14);
    $this->write(5, "Comunidad Cristiana, Iglesia Pan de Vida");
    $this->Image("../views/images/logo.jpeg", 150, 5, 45, 20, "JPEG");
    $this->Ln();
    $this->write(5, "Reporte: $this->nombre");
    $this->Ln(10);
  }

  public function Footer()
  {
    $this->SetFont("Arial", "B", 14);
    $this->SetY(-15);
    $this->SetX(-20);
    $this->write(5, "Pagina numero: " . $this->PageNo());
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

    case "ReporteFiltrado":
      fn_pdf_filtrado();
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
  $fecha = new DateTime($d['doc']['fecha']);

  if (!isset($d['productos'][0][0])) {
    die("No hay información suficiente");
  }


  $pdf = new new_fpdf();
  $pdf->SetNombre("Entrada de productos");
  $pdf->addPage();
  $pdf->setFont('Arial', 'B', 12);
  $pdf->SetTextColor(16, 87, 97);
  $pdf->cell(70, 5, "Numero de operacion: " . $d['doc']['id'], 0, 1, 'L');
  $pdf->cell(70, 5, "Fecha de la operacion: " . $fecha->format("d-m-Y h:i a"), 0, 1, 'L');
  $pdf->cell(70, 5, "N-Orden: " . $d['doc']['orden'], 0, 1, 'L');
  $pdf->cell(90, 5, "Proveedor: " . $d['persona'][0]['proveedor']['tipo_persona'] . "-" . $d['persona'][0]['proveedor']['cedula'] . " " . $d['persona'][0]['proveedor']['nom'], 0, 1, 'L');
  $pdf->cell(80, 5, "Concepto de entrada: " . $conceptos[$d['doc']['concepto']], 0, 1, 'L');
  $pdf->cell(80, 5, "Comedor: " . $d['comedor']['nom'], 0, 1, 'L');
  $pdf->Ln(10);
  $pdf->setFont('Arial', 'B', 11);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->SetFillColor(11, 63, 71);
  $pdf->SetDrawColor(88, 88, 88);
  $pdf->cell(190, 8, "Observacion: " . $d['doc']['observacion'], 1, 1, "C", 1);
  $pdf->cell(190, 8, "Descripcion general de los productos", 1, 1, "C", 1);
  $pdf->cell(16, 7, "Codigo", 1, 0, "C", 1);
  $pdf->cell(80, 7, "Descripcion", 1, 0, "C", 1);
  // $pdf->cell(48,7,"Fecha de vencimiento",1,0,"C",1);
  // $pdf->cell(30,7,"Grupo",1,0,"C",1);
  $pdf->cell(20, 7, "Medida", 1, 0, "C", 1);
  $pdf->cell(26, 7, "Catidad", 1, 0, "C", 1);
  $pdf->cell(48, 7, "Precio", 1, 1, "C", 1);
  $pdf->SetFillColor(255, 255, 255);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->setFont('Arial', 'B', 9);
  foreach ($d['productos'][0] as $dato) {
    $pdf->cell(16, 7, $dato['id_product'], 1, 0, "C", 1);
    $pdf->cell(80, 7, $dato['nom_product'], 1, 0, "C", 1);
    // $pdf->cell(48,7,$dato['fecha_vencimiento_ope'],1,0,"C",1);
    // $pdf->cell(30,7,$dato['nom_grupo'],1,0,"C",1);
    $pdf->cell(20, 7, $dato['valor_product'] . " " . $dato['med_product'], 1, 0, "C", 1);
    $pdf->cell(26, 7, $dato['detalle_cantidad'], 1, 0, "C", 1);
    $pdf->cell(48, 7, $dato['precio_product_ope'] . "Bs.", 1, 1, "C", 1);
  }
  $pdf->Output();
}


function fn_pdf_salida()
{
  $conceptos = [
    'V' => "Vencimiento",
    'R' => "Rechazo",
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
  $pdf->SetTextColor(16, 87, 97);
  $pdf->cell(70, 5, "Numero de operacion: " . $d['doc']['id'], 0, 1, 'L');
  $pdf->cell(70, 5, "Fecha de la operacion: " . $fecha->format("d-m-Y h:i a"), 0, 1, 'L');
  $pdf->cell(70, 5, "N-Orden: " . $d['doc']['orden'], 0, 1, 'L');
  $pdf->cell(90, 5, "Receptor: " . $d['persona'][0]['quien_recibe']['tipo_persona'] . "-" . $d['persona'][0]['quien_recibe']['cedula'] . " " . $d['persona'][0]['quien_recibe']['nom'], 0, 1, 'L');
  $pdf->cell(80, 5, "Concepto de salida: " . $conceptos[$d['doc']['concepto']], 0, 1, 'L');
  $pdf->cell(80, 5, "Comedor: " . $d['comedor']['nom'], 0, 1, 'L');
  $pdf->Ln(10);
  $pdf->setFont('Arial', 'B', 11);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->SetFillColor(11, 63, 71);
  $pdf->SetDrawColor(88, 88, 88);
  $pdf->cell(190, 8, "Observacion: " . $d['doc']['observacion'], 1, 1, "C", 1);
  // var_dump($d['doc']);
  if ($d['doc']['id_jornada']) {
    $pdf->cell(190, 8, "Jornada del dia: " . $d['doc']['titulo_jornada'], 1, 1, "C", 1);
    $pdf->cell(190, 8, "Jornada del dia: " . $d['doc']['des_jornada'], 1, 1, "C", 1);
    $pdf->cell(100, 8, "Menu del dia: " . $d['doc']['des_menu'], 1, 0, "C", 1);
    $pdf->cell(90, 8, "Cantidad de platos aproximada: " . $d['doc']['cant_aproximada'], 1, 1, "C", 1);
    // die("Hay jornada");
  }
  $pdf->cell(190, 8, "Descripcion general de los productos", 1, 1, "C", 1);
  $pdf->cell(16, 7, "Codigo", 1, 0, "C", 1);
  $pdf->cell(80, 7, "Descripcion", 1, 0, "C", 1);
  // $pdf->cell(48,7,"Fecha de vencimiento",1,0,"C",1);
  // $pdf->cell(30,7,"Grupo",1,0,"C",1);
  $pdf->cell(20, 7, "Medida", 1, 0, "C", 1);
  $pdf->cell(26, 7, "Cantidad", 1, 0, "C", 1);
  $pdf->cell(48, 7, "Precio", 1, 1, "C", 1);
  $pdf->SetFillColor(255, 255, 255);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->setFont('Arial', 'B', 9);
  foreach ($d['productos'][0] as $dato) {
    $pdf->cell(16, 7, $dato['id_product'], 1, 0, "C", 1);
    $pdf->cell(80, 7, $dato['nom_product'], 1, 0, "C", 1);
    // $pdf->cell(48,7,$dato['fecha_vencimiento_ope'],1,0,"C",1);
    // $pdf->cell(30,7,$dato['nom_grupo'],1,0,"C",1);
    $pdf->cell(20, 7, $dato['valor_product'] . " " . $dato['med_product'], 1, 0, "C", 1);
    $pdf->cell(26, 7, $dato['detalle_cantidad'], 1, 0, "C", 1);
    $pdf->cell(48, 7, $dato['precio_product_ope'] . "Bs.", 1, 1, "C", 1);
  }
  $pdf->Output();
}

function fn_pdf_filtrado()
{
  $model = new m_entrada_salida();
  $d = $model->GetPdfWithFiltros($_POST['filtro']);
  // var_dump($d);
  $filtro = $_POST['filtro'];

  if (!isset($d[0])) {
    echo "<script>alert('No hay suficientes datos para generar este reporte!');</script>";
    exit;
  }
  // Entradas
  if ($filtro == "C") $des_tipo = "Compra";
  if ($filtro == "D") $des_tipo = "Donacion";
  if ($filtro == "C" || $filtro == "D") $tipo = "Entradas";
  // Salidas
  if ($filtro == "O") $des_tipo = "Consumo";
  if ($filtro == "V") $des_tipo = "Vencimiento";
  if ($filtro == "R") $des_tipo = "Rechazo";
  if ($filtro == "O" || $filtro == "V" || $filtro == "R") $tipo = "Salidas";

  $pdf = new new_fpdf();
  $pdf->SetNombre("Reporte de operaciones de $tipo por $des_tipo");
  $pdf->addPage();
  $pdf->Ln(10);
  $pdf->setFont('Arial', 'B', 10);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->SetFillColor(11, 63, 71);
  $pdf->SetDrawColor(88, 88, 88);
  foreach ($d as $dato) {
    $fecha = new DateTime($dato['invent']['created_invent']);

    $pdf->cell(80, 7, "Codigo de la operacion: " . $dato['invent']['id_invent'], 1, 0, "C", 1);
    $pdf->cell(75, 7, "Fecha y Hora: " . $fecha->format("d/m/Y h:i a"), 1, 0, "C", 1);
    $pdf->cell(35, 7, "Cantidad total: " . $dato['invent']['cantidad_invent'], 1, 0, "C", 1);
    $pdf->Ln();
    $pdf->cell(120, 7, "Nombre del comedor : " . $dato['invent']['nom_comedor'], 1, 0, "C", 1);
    $pdf->cell(70, 7, "N-Orden: " . $dato['invent']['orden_invent'], 1, 0, "C", 1);
    $pdf->Ln();
    $pdf->Cell(190, 7, "Observacion: " . $dato['invent']['observacion_invent'], 1, 0, "C", 1);
    $pdf->Ln();

    if ($filtro == "C" || $filtro == "D") {
      $pdf->cell(190, 7, 'Datos del proveedor', 1, 0, "C", 1);
      $pdf->Ln();
      $pdf->cell(35, 7, $dato['persona']['proveedor']['tipo_persona'] . "-" . $dato['persona']['proveedor']['cedula'], 1, 0, "C", 1);
      $pdf->cell(110, 7, $dato['persona']['proveedor']['nom'], 1, 0, "C", 1);
      $pdf->cell(45, 7, "Telf: " . $dato['persona']['proveedor']['telf'], 1, 0, "C", 1);
      $pdf->Ln();
    } else {
      $pdf->cell(190, 7, 'Datos de quien recibe los alimentos', 1, 0, "C", 1);
      $pdf->Ln();
      $pdf->cell(35, 7, $dato['persona']['quien_recibe']['tipo_persona'] . "-" . $dato['persona']['quien_recibe']['cedula'], 1, 0, "C", 1);
      $pdf->cell(110, 7, $dato['persona']['quien_recibe']['nom'], 1, 0, "C", 1);
      $pdf->cell(45, 7, "Telf: " . $dato['persona']['quien_recibe']['telf'], 1, 0, "C", 1);
      $pdf->Ln();
    }

    if ($filtro == "O") {
      $pdf->cell(190, 7, 'Jornada del dia', 1, 0, "C", 1);
      $pdf->Ln();
      $pdf->cell(100, 7, "Nombre: " . ($dato['invent']['titulo_jornada'] !== "NULL") ? $dato['invent']['titulo_jornada'] : "Sin titulo", 1, 0, "C", 1);
      $pdf->cell(90, 7, "Cantidad Aproximada de platos: " . $dato['invent']['cant_aproximada'], 1, 0, "C", 1);
      $pdf->Ln();
      $pdf->cell(190, 7, "Descripcion de la jornada: " . $dato['invent']['des_jornada'], 1, 0, "C", 1);
      $pdf->Ln();
      $pdf->cell(190, 7, 'Menu del dia', 1, 0, "C", 1);
      $pdf->Ln();
      // $pdf->cell(100, 7, "Nombre: " . ($dato['invent']['des_menu'] !== "NULL") ? $dato['invent']['des_menu'] : "Sin titulo", 1, 0, "C", 1);
      // $pdf->Ln();
      $pdf->cell(190, 7, "Descripcion del menu: " . $dato['invent']['des_menu'], 1, 0, "C", 1);
      $pdf->Ln();
    }

    $pdf->cell(190, 7, 'Datos de los productos', 1, 0, "C", 1);
    $pdf->Ln();
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->setFont('Arial', 'B', 9);
    foreach ($dato['products'] as $prod) {
      $pdf->cell(50, 7, "Descripcion: " . $prod['nom_product'], 1, 0, "C", 1);
      $pdf->cell(15, 7, $prod['valor_product'] . " " . $prod['med_product'], 1, 0, "C", 1);
      $pdf->cell(35, 7, "Cantidad c/u: " . $prod['detalle_cantidad'], 1, 0, "C", 1);
      $pdf->cell(40, 7, "Precio c/u: " . $prod['precio_product_ope'] . "Bs.", 1, 0, "C", 1);
      $pdf->cell(50, 7, "Marca: " . $prod['nom_marca'], 1, 0, "C", 1);
      $pdf->Ln();
    }
    $pdf->Ln(10);
  }

  $pdf->Output();
}
