<?php
    require_once("../models/config.php");
    
    require_once("../models/m_usuarios.php");
    require_once("../models/m_auth.php");
    
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

            case "Save":
                fn_Save_pregunta();
            break;

            case "Actualizar_preguntas":
                fn_Update_pregunta();
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

            case "Todos_preguntas":
                fn_Consultar_preguntas();
            break;

            case "Consultar_pregunta":
                fn_Consultar_pregunta();
            break;

            case "All_bitacora":
                fn_bitacora_all();
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

    function fn_Consultar_preguntas(){
        $model = new m_auth();
        $result = $model->Get_Preguntas();
        print json_encode(["data" => $result]);
    }

    function fn_Consultar_pregunta(){
        $model = new m_usuarios();
        $result = $model->Get_Pregunta($_GET['id_pregun']);
        print json_encode(["data" => $result]);
    }

    function fn_Save_pregunta(){
        $model = new m_usuarios();
        $mensaje = $model->Save_pregunta($_POST['des_pregun']);
        print json_encode(["data" => $result]);
    }

    function fn_Update_pregunta(){
        $model = new m_usuarios();
        $mensaje = $model->Update_pregunta($_POST);
        print json_encode(["data" => $result]);
    }

    function fn_bitacora_all(){
        $model = new m_usuarios();
        $results = $model->Get_All_bitacora();

        print json_encode(["data" => $results]);
    }
?>