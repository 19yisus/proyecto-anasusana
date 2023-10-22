<?php
require_once("../models/config.php");
require_once("../models/m_jornada.php");

if (isset($_POST['ope'])) {
    switch ($_POST['ope']) {
        case "Registrar":
            fn_Registrar();
            break;

        case "Actualizar":
            fn_Actualizar();
            break;

            // case "Desactivar":
            //     fn_Desactivar();
            // break;

            // case "Eliminar":
            //     fn_Eliminar();
            // break;

        case "Actualizar_cantidades":
            fn_Actualizar_Cantidad();
            break;
    }
}

if (isset($_GET['ope'])) {
    switch ($_GET['ope']) {
        case "Todos_jornada":
            fn_Consultar_todos();
            break;

        case "Consultar_jornada":
            fn_Consultar_jornada();
            break;

        case "Consultar_jornada_detallado":
            fn_Consultar_jornada_detallado();
            break;
    }
}

function fn_Registrar()
{
    $model = new m_jornada();
    $model->setDatos($_POST);
    $mensaje = $model->Create();

    header("Location: " . constant("URL") . "jornada/form/$mensaje");
}

function fn_Actualizar()
{
    $model = new m_jornada();
    $model->setDatos($_POST);
    $result = $model->Update();

    print json_encode(["data" => $result]);
}

function fn_Actualizar_Cantidad()
{
    $model = new m_jornada();
    $model->setDatos($_POST);
    $result = $model->Update_cantidad();

    print json_encode(["data" => $result]);
}

// function fn_Desactivar(){
//     $model = new m_jornada();
//     $model->setDatos($_POST);
//     $result = $model->Disable();

//     print json_encode(["data" => $result]);
// }

// function fn_Eliminar(){
//     $model = new m_jornada();
//     $model->setDatos($_POST);
//     $result = $model->Delete();

//     print json_encode(["data" => $result]);
// }

function fn_Consultar_todos()
{
    $model = new m_jornada();
    $results = $model->Get_todos_jornada();

    print json_encode(["data" => $results]);
}

function fn_Consultar_jornada()
{
    $model = new m_jornada();
    $model->setDatos(["id_jornada" => $_GET["id_jornada"]]);
    $result = $model->Get_jornada();

    print json_encode(["data" => $result]);
}

function fn_Consultar_jornada_detallado()
{
    $model = new m_jornada();
    $model->setDatos(["id_jornada" => $_GET["id_jornada"]]);
    $result = $model->Get_jornada();
    require_once("../models/tem_jornada_detallado.php");
}
