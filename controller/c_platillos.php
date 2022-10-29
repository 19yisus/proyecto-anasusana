<?php
    require_once("../models/config.php");
    require_once("../models/m_platillos.php");

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
            case "Todos_platillo":
                fn_Consultar_todos();
            break;

            case "Consultar_platillo":
                fn_Consultar_platillo();
            break;
        }
    }

    function fn_Registrar(){
        $model = new m_platillos();
        $model->setDatos($_POST);
        $mensaje = $model->Create();

        header("Location: ".constant("URL")."platillo/form/$mensaje");
    }

    function fn_Actualizar(){
        $model = new m_platillos();
        $model->setDatos($_POST);
        $result = $model->Update();

        print json_encode(["data" => $result]);
    }

    function fn_Desactivar(){
        $model = new m_platillos();
        $model->setDatos(["id_plat" => $_POST["id_plat"], "estatus_plat" => $_POST["estatus_plat"]]);
        $result = $model->Disable();

        print json_encode(["data" => $result]);
    }

    function fn_Eliminar(){
        $model = new m_platillos();
        $model->setDatos(["id_plat" => $_POST['id_plat']]);
        $result = $model->Delete();

        print json_encode(["data" => $result]);
    }

    function fn_Consultar_todos(){
        $model = new m_platillos();
        $results = $model->Get_todos_plat();

        print json_encode(["data" => $results]);
    }

    function fn_Consultar_platillo(){
        $model = new m_platillos();
        $model->setDatos(["id_plat" => $_GET["id_plat"]]);
        $result = $model->Get_plat();

        print json_encode(["data" => $result]);
    }
