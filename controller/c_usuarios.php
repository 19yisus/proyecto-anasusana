<?php
    require_once("../models/config.php");
    require_once("../models/m_usuarios.php");
    
    if(isset($_POST['ope'])){
        switch($_POST['ope']){
            // case "Registrar":
            //     fn_Registrar();
            // break;

            case "Actualizar":
                fn_Actualizar();
            break;

            case "Desactivar":
                fn_Desactivar();
            break;

            // case "Eliminar":
            //     fn_Eliminar();
            // break;
        }
    }

    if(isset($_GET['ope'])){
        switch($_GET['ope']){
            case "Todos_users":
                fn_Consultar_todos();
            break;

            case "Consultar_user":
                fn_Consultar_user();
            break;
        }
    }

    // function fn_Registrar(){
    //     $model = new m_usuarios();
    //     $model->setDatos($_POST);
    //     $mensaje = $model->Create();

    //     header("Location: ".constant("URL")."grupos/form/$mensaje");
    // }

    function fn_Actualizar(){
        $model = new m_usuarios();
        $model->setDatos($_POST);
        $result = $model->Update();

        print json_encode(["data" => $result]);
    }

    function fn_Desactivar(){
        $model = new m_usuarios();
        $model->setDatos(["id_user" => $_POST["id_user"], "status_user" => $_POST["status_user"]]);
        $result = $model->Disable();

        print json_encode(["data" => $result]);
    }

    // function fn_Eliminar(){
    //     $model = new m_usuarios();
    //     $model->setDatos(["id_user" => $_POST['id_user']]);
    //     $result = $model->Delete();

    //     print json_encode(["data" => $result]);
    // }

    function fn_Consultar_todos(){
        $model = new m_usuarios();
        $results = $model->Get_todos_users();

        print json_encode(["data" => $results]);
    }

    function fn_Consultar_user(){
        $model = new m_usuarios();
        $model->setDatos(["id_user" => $_GET["id_user"]]);
        $result = $model->Get_user();

        print json_encode(["data" => $result]);
    }
?>