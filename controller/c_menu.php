<?php
    require_once("../models/config.php");
    require_once("../models/m_menu.php");

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
            case "Todos_menu":
                fn_Consultar_todos();
            break;

            case "Consultar_menu":
                fn_Consultar_menu();
            break;
        }
    }

    function fn_Registrar(){
        $model = new m_menu();
        $model->setDatos($_POST);
        $mensaje = $model->Create();

        header("Location: ".constant("URL")."menu/form/$mensaje");
    }

    function fn_Actualizar(){
        $model = new m_menu();
        $model->setDatos($_POST);
        $result = $model->Update();

        print json_encode(["data" => $result]);
    }

    function fn_Desactivar(){
        $model = new m_menu();
        $model->setDatos(["id_menu" => $_POST["id_menu"], "estatus_menu" => $_POST["estatus_menu"]]);
        $result = $model->Disable();

        print json_encode(["data" => $result]);
    }

    function fn_Eliminar(){
        $model = new m_menu();
        $model->setDatos(["id_menu" => $_POST['id_menu']]);
        $result = $model->Delete();

        print json_encode(["data" => $result]);
    }

    function fn_Consultar_todos(){
        $model = new m_menu();
        $results = $model->Get_todos_menu();

        print json_encode(["data" => $results]);
    }

    function fn_Consultar_menu(){
        $model = new m_menu();
        $model->setDatos(["id_menu" => $_GET["id_menu"]]);
        $result = $model->Get_menu();

        print json_encode(["data" => $result]);
    }