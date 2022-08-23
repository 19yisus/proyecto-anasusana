<?php
    require_once("../models/config.php");
    require_once("../models/m_cargos.php");

    if(isset($_POST['ope'])){
        switch($_POST['ope']){
            case "Registrar":
                fn_Registrar();
            break;

            case "Actualizar":
                fn_Actualizar();
            break;

            case "Desactivar":
                fn_Desactivar();
            break;

            case "Eliminar":
                fn_Eliminar();
            break;
        }
    }

    if(isset($_GET['ope'])){
        switch($_GET['ope']){
            case "Todos_cargo":
                fn_Consultar_todos();
            break;

            case "Consultar_cargo":
                fn_Consultar_cargo();
            break;
        }
    }

    function fn_Registrar(){
        $model = new m_cargos();
        $model->setDatos($_POST);
        $mensaje = $model->Create();

        header("Location: ".constant("URL")."cargo/form/$mensaje");
    }

    function fn_Actualizar(){
        $model = new m_cargos();
        $model->setDatos($_POST);
        $result = $model->Update();

        print json_encode(["data" => $result]);
    }

    function fn_Desactivar(){
        $model = new m_cargos();
        $model->setDatos(["id_cargo" => $_POST["id_cargo"], "estatus_cargo" => $_POST["estatus_cargo"]]);
        $result = $model->Disable();

        print json_encode(["data" => $result]);
    }

    function fn_Eliminar(){
        $model = new m_cargos();
        $model->setDatos(["id_cargo" => $_POST['id_cargo']]);
        $result = $model->Delete();

        print json_encode(["data" => $result]);
    }

    function fn_Consultar_todos(){
        $model = new m_cargos();
        $results = $model->Get_todos_cargo();

        print json_encode(["data" => $results]);
    }

    function fn_Consultar_cargo(){
        $model = new m_cargos();
        $model->setDatos(["id_cargo" => $_GET["id_cargo"]]);
        $result = $model->Get_cargo();

        print json_encode(["data" => $result]);
    }
?>
