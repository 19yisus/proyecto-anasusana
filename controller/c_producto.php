<?php
    require_once("../models/config.php");
    require_once("../models/m_producto.php");
    
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
            case "Todos_productos":
                fn_Consultar_todos();
            break;

            case "Consultar_producto":
                fn_Consultar_producto();
            break;
        }
    }

    function fn_Registrar(){
        $model = new m_producto();
        $model->setDatos($_POST);
        $mensage = $model->Create();

        $this->Redirect("productos/form",$mensage);
    }

    function fn_Actualizar(){
        $model = new m_producto();
        $model->setDatos($_POST);
        $result = $model->Update();

        print json_encode(["data" => $result]);
    }

    function fn_Desactivar(){
        $model = new m_producto();
        $model->setDatos(["id_producto" => $_POST["id_producto"], "status_producto" => $_POST["status_producto"]]);
        $result = $model->Disable();

        print json_encode(["data" => $result]);
    }

    function fn_Eliminar(){
        $model = new m_producto();
        $model->setDatos(["id_producto" => $_POST['id_producto']]);
        $result = $model->Delete();

        print json_encode(["data" => $result]);
    }

    function fn_Consultar_todos(){
        $model = new m_producto();
        $results = $model->Get_todos_productos();

        print json_encode(["data" => $results]);
    }

    function fn_Consultar_producto(){
        $model = new m_producto();
        $model->setDatos(["id_producto" => $_GET["id_producto"]]);
        $result = $model->Get_producto();

        print json_encode(["data" => $result]);
    }
?>