<?php
    require_once("../models/config.php");
    require_once("../models/m_marca.php");
    
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
            case "Todos_marcas":
                fn_Consultar_todos();
            break;

            case "Consultar_marca":
                fn_Consultar_marca();
            break;
        }
    }

    function fn_Registrar(){
        $model = new m_marca();
        $model->setDatos($_POST);
        $mensage = $model->Create();

        header("Location: ".constant("URL")."marcas/form/$mensage");
    }

    function fn_Actualizar(){
        $model = new m_marca();
        $model->setDatos($_POST);
        $result = $model->Update();

        print json_encode(["data" => $result]);
    }

    function fn_Desactivar(){
        $model = new m_marca();
        $model->setDatos(["id_marca" => $_POST["id_marca"], "status_marca" => $_POST["status_marca"]]);
        $result = $model->Disable();

        print json_encode(["data" => $result]);
    }

    function fn_Eliminar(){
        $model = new m_marca();
        $model->setDatos(["id_marca" => $_POST['id_marca']]);
        $result = $model->Delete();

        print json_encode(["data" => $result]);
    }

    function fn_Consultar_todos(){
        $model = new m_marca();
        $results = $model->Get_todos_marcas();

        print json_encode(["data" => $results]);
    }

    function fn_Consultar_marca(){
        $model = new m_marca();
        $model->setDatos(["id_marca" => $_GET["id_marca"]]);
        $result = $model->Get_marca();

        print json_encode(["data" => $result]);
    }
?>