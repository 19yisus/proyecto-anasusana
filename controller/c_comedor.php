<?php
    require_once("../models/config.php");
    require_once("../models/m_comedor.php");
    
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
            case "Todos_comedor":
                fn_Consultar_todos();
            break;

            case "Consultar_comedor":
                fn_Consultar_comedor();
            break;
        }
    }

    function fn_Registrar(){
        $model = new m_comedor();
        $model->setDatos($_POST);
        $mensaje = $model->Create();

        header("Location: ".constant("URL")."comedor/form/$mensaje");
    }

    function fn_Actualizar(){
        $model = new m_comedor();
        $model->setDatos($_POST);
        $result = $model->Update();

        print json_encode(["data" => $result]);
    }

    function fn_Desactivar(){
        $model = new m_comedor();
        $model->setDatos(["id_comedor" => $_POST["id_comedor"], "status_comedor" => $_POST["status_comedor"]]);
        $result = $model->Disable();

        print json_encode(["data" => $result]);
    }

    function fn_Eliminar(){
        $model = new m_comedor();
        $model->setDatos(["id_comedor" => $_POST['id_comedor']]);
        $result = $model->Delete();

        print json_encode(["data" => $result]);
    }

    function fn_Consultar_todos(){
        $model = new m_comedor();
        $results = $model->Get_todos_comedor();

        print json_encode(["data" => $results]);
    }

    function fn_Consultar_comedor(){
        $model = new m_comedor();
        $model->setDatos(["id_comedor" => $_GET["id_comedor"]]);
        $result = $model->Get_comedor();

        print json_encode(["data" => $result]);
    }
?>