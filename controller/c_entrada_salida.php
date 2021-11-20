<?php
    require_once("../models/config.php");
    require_once("../models/m_entrada_salida.php");
    
    if(isset($_POST['ope'])){
        switch($_POST['ope']){
            case "Entrada":
                fn_Entrada();
            break;

            case 'Salida': 
                fn_Salida();
            break;

            // case "Actualizar":
            //     fn_Actualizar();
            // break;

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
            case "Todos_entradas":
                fn_Consultar_todos_entradas();
            break;

            case "Todos_salidas":
                fn_Consultar_todos_salidas();
            break;

            case "Consultar_invent":
                fn_Consultar_invent();
            break;
        }
    }

    function fn_Entrada(){
        $model = new m_entrada_salida();
        $model->setDatos($_POST);
        $mensage = $model->Entrada_productos();

        header("Location: ".constant("URL")."entradas/form/$mensage");
    }

    function fn_Salida(){
        $model = new m_entrada_salida();
        $model->setDatos($_POST);
        $mensage = $model->Salida_productos();

        header("Location: ".constant("URL")."salidas/form/$mensage");
    }

    // function fn_Actualizar(){
    //     $model = new m_entrada_salida();
    //     $model->setDatos($_POST);
    //     $result = $model->Update();

    //     print json_encode(["data" => $result]);
    // }

    // function fn_Desactivar(){
    //     $model = new m_entrada_salida();
    //     $model->setDatos(["id_entrada_salida" => $_POST["id_entrada_salida"], "status_entrada_salida" => $_POST["status_entrada_salida"]]);
    //     $result = $model->Disable();

    //     print json_encode(["data" => $result]);
    // }

    // function fn_Eliminar(){
    //     $model = new m_entrada_salida();
    //     $model->setDatos(["id_entrada_salida" => $_POST['id_entrada_salida']]);
    //     $result = $model->Delete();

    //     print json_encode(["data" => $result]);
    // }

    function fn_Consultar_todos_entradas(){
        $model = new m_entrada_salida();
        $results = $model->Get_todos_invent("E");

        print json_encode(["data" => $results]);
    }

    function fn_Consultar_todos_salidas(){
        $model = new m_entrada_salida();
        $results = $model->Get_todos_invent("S");

        print json_encode(["data" => $results]);
    }

    function fn_Consultar_invent(){
        $model = new m_entrada_salida();
        $model->setDatos(["id_invent" => $_GET["id_invent"]]);
        $result = $model->Get_Consultar_invent();

        print json_encode(["data" => $result]);
    }
?>