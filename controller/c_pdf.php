<?php
  require_once("../models/m_entrada_salida.php");
  require_once("../models/fpdf/fpdf.php");
  class new_fpdf extends FPDF{
    private $nombre;

    public function SetNombre($name){
      $this->nombre = $name;
    }
    public function Header(){
      $this->SetFont("Arial","B",14);
      $this->write(5,"Comunidad Cristiana, Iglesia Pan de Vida");
      $this->Image("../views/images/logo.jpeg",150,5,45,20,"JPEG");
      $this->Ln();
      $this->write(5,"Reporte: $this->nombre");
      $this->Ln(10);
    }

    public function Footer(){
      $this->SetFont("Arial","B",14);
      $this->SetY(-15);
      $this->SetX(-20);
      $this->write(5,"Pagina numero: ".$this->PageNo());
    }
  }

  if(isset($_POST['ope'])){
    switch($_POST['ope']){
      case "pdf_entrada":
        fn_pdf_entrada();
      break;

      case "pdf_salida":
        fn_pdf_salida();
      break;
    }
  }

  function fn_pdf_entrada(){
    $conceptos = [
      'C' => "Compra",
      'D' => "Donacion",
    ];

    $model = new m_entrada_salida();
    $d = $model->GetPdf($_POST['id_invent'])[0];
    $fecha = new DateTime($d['doc']['fecha']);
    
    $pdf = new new_fpdf();
    $pdf->SetNombre("Entrada de productos");
    $pdf->addPage();
    $pdf->setFont('Arial','B',12);
    $pdf->SetTextColor(16,87,97);
    $pdf->cell(70,5,"Numero de operacion: ".$d['doc']['id'],0,1,'L');
    $pdf->cell(70,5,"Fecha de la operacion: ".$fecha->format("d-m-Y h:i a"),0,1,'L');
    $pdf->cell(70,5,"N-Orden: ".$d['doc']['orden'],0,1,'L');
    $pdf->cell(90,5,"Proveedor: ".$d['persona'][0]['proveedor']['tipo_persona']."-".$d['persona'][0]['proveedor']['cedula']." ".$d['persona'][0]['proveedor']['nom'], 0,1,'L');
    $pdf->cell(80,5,"Concepto de entrada: ".$conceptos[$d['doc']['concepto']],0,1,'L');
    $pdf->cell(80,5,"Comedor: ".$d['comedor']['nom'],0,1,'L');
    $pdf->Ln(10);
    $pdf->setFont('Arial','B',11);
    $pdf->SetTextColor(255,255,255);
    $pdf->SetFillColor(11,63,71);
    $pdf->SetDrawColor(88,88,88);
    $pdf->cell(190,8,"Observacion: ".$d['doc']['observacion'],1,1,"C",1);
    $pdf->cell(190,8,"Descripcion general de los productos",1,1,"C",1);
    $pdf->cell(16,7,"Codigo",1,0,"C",1);
    $pdf->cell(60,7,"Descripcion",1,0,"C",1);
    // $pdf->cell(48,7,"Fecha de vencimiento",1,0,"C",1);
    $pdf->cell(30,7,"Grupo",1,0,"C",1);
    $pdf->cell(20,7,"Medida",1,0,"C",1);
    $pdf->cell(26,7,"Catidad",1,0,"C",1);
    $pdf->cell(38,7,"Precio",1,1,"C",1);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(0,0,0);
    $pdf->setFont('Arial','B',9);
    foreach($d['productos'][0] as $dato){
      $pdf->cell(16,7,$dato['id_product'],1,0,"C",1);
      $pdf->cell(60,7,$dato['nom_product'],1,0,"C",1);
      // $pdf->cell(48,7,$dato['fecha_vencimiento_ope'],1,0,"C",1);
      $pdf->cell(30,7,$dato['nom_grupo'],1,0,"C",1);
      $pdf->cell(20,7,$dato['valor_product']." ".$dato['med_product'],1,0,"C",1);
      $pdf->cell(26,7,$dato['detalle_cantidad'],1,0,"C",1);
      $pdf->cell(38,7,$dato['precio_product_ope']."Bs.",1,1,"C",1);
    }
    $pdf->Output();
  }


  function fn_pdf_salida(){
    $conceptos = [
      'V' => "Vencimiento",
      'R' => "Rechazo",
      'O' => "Consumo",
    ];

    $model = new m_entrada_salida();
    $d = $model->GetPdf($_POST['id_invent'])[0];
    $fecha = new DateTime($d['doc']['fecha']);
    
    $pdf = new new_fpdf();
    $pdf->SetNombre("Salida de productos");
    $pdf->addPage();
    $pdf->setFont('Arial','B',12);
    $pdf->SetTextColor(16,87,97);
    $pdf->cell(70,5,"Numero de operacion: ".$d['doc']['id'],0,1,'L');
    $pdf->cell(70,5,"Fecha de la operacion: ".$fecha->format("d-m-Y h:i a"),0,1,'L');
    $pdf->cell(70,5,"N-Orden: ".$d['doc']['orden'],0,1,'L');
    $pdf->cell(90,5,"Receptor: ".$d['persona'][0]['quien_recibe']['tipo_persona']."-".$d['persona'][0]['quien_recibe']['cedula']." ".$d['persona'][0]['quien_recibe']['nom'], 0,1,'L');
    $pdf->cell(80,5,"Concepto de salida: ".$conceptos[$d['doc']['concepto']],0,1,'L');
    $pdf->cell(80,5,"Comedor: ".$d['comedor']['nom'],0,1,'L');
    $pdf->Ln(10);
    $pdf->setFont('Arial','B',11);
    $pdf->SetTextColor(255,255,255);
    $pdf->SetFillColor(11,63,71);
    $pdf->SetDrawColor(88,88,88);
    $pdf->cell(190,8,"Observacion: ".$d['doc']['observacion'],1,1,"C",1);
    $pdf->cell(190,8,"Descripcion general de los productos",1,1,"C",1);
    $pdf->cell(16,7,"Codigo",1,0,"C",1);
    $pdf->cell(60,7,"Descripcion",1,0,"C",1);
    // $pdf->cell(48,7,"Fecha de vencimiento",1,0,"C",1);
    $pdf->cell(30,7,"Grupo",1,0,"C",1);
    $pdf->cell(20,7,"Medida",1,0,"C",1);
    $pdf->cell(26,7,"Cantidad",1,0,"C",1);
    $pdf->cell(38,7,"Precio",1,1,"C",1);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(0,0,0);
    $pdf->setFont('Arial','B',9);
    foreach($d['productos'][0] as $dato){
      $pdf->cell(16,7,$dato['id_product'],1,0,"C",1);
      $pdf->cell(60,7,$dato['nom_product'],1,0,"C",1);
      // $pdf->cell(48,7,$dato['fecha_vencimiento_ope'],1,0,"C",1);
      $pdf->cell(30,7,$dato['nom_grupo'],1,0,"C",1);
      $pdf->cell(20,7,$dato['valor_product']." ".$dato['med_product'],1,0,"C",1);
      $pdf->cell(26,7,$dato['detalle_cantidad'],1,0,"C",1);
      $pdf->cell(38,7,$dato['precio_product_ope']."Bs.",1,1,"C",1);
    }
    $pdf->Output();
  }
?>