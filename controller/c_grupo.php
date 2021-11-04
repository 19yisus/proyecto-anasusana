<?php
    require_once("../models/config.php");
    require_once("../models/m_grupo.php");
    
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
            case "Todos_grupos":
                fn_Consultar_todos();
            break;

            case "Consultar_grupo":
                fn_Consultar_grupo();
            break;
        }
    }

    function fn_Registrar(){
        $model = new m_grupo();
        $model->setDatos($_POST);
        $mensage = $model->Create();

        header("Location: ".constant("URL")."grupos/form/$mensage");
    }

    function fn_Actualizar(){
        $model = new m_grupo();
        $model->setDatos($_POST);
        $result = $model->Update();

        print json_encode(["data" => $result]);
    }

    function fn_Desactivar(){
        $model = new m_grupo();
        $model->setDatos(["id_grupo" => $_POST["id_grupo"], "status_grupo" => $_POST["status_grupo"]]);
        $result = $model->Disable();

        print json_encode(["data" => $result]);
    }

    function fn_Eliminar(){
        $model = new m_grupo();
        $model->setDatos(["id_grupo" => $_POST['id_grupo']]);
        $result = $model->Delete();

        print json_encode(["data" => $result]);
    }

    function fn_Consultar_todos(){
        $model = new m_grupo();
        $results = $model->Get_todos_grupos();

        print json_encode(["data" => $results]);
    }

    function fn_Consultar_grupo(){
        $model = new m_grupo();
        $model->setDatos(["id_grupo" => $_GET["id_grupo"]]);
        $result = $model->Get_grupo();

        print json_encode(["data" => $result]);
    }
?>