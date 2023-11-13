<?php
require_once("../models/config.php");
require_once("../models/m_entrada_salida.php");

if (isset($_POST['ope'])) {
	switch ($_POST['ope']) {
		case "Entrada":
			fn_Entrada();
			break;

		case "Entrada_A":
			fn_Entrada_asincrona();
			break;

		case 'Salida':
			fn_Salida();
			break;
	}
}

if (isset($_GET['ope'])) {
	switch ($_GET['ope']) {
		case "Todos_entradas":
			fn_Consultar_todos_entradas();
			break;

		case "Todos_salidas":
			fn_Consultar_todos_salidas();
			break;

		case "Consultar_invent":
			fn_Consultar_invent();
			break;

		case "next_ope":
			fn_Consultar_nextId();
			break;

		case "menus_recientes":
			fn_consultar_menus_recientes();
			break;
	}
}

function fn_Entrada()
{
	$model = new m_entrada_salida();
	// ESTA OPEACION ORDENA TODOS LOS PRODUCTOS EN UN GRAN ARREGLO PARA UN MEJOR ORDEN EN LA TRANSACCION
	$list_products = [];
	for ($i = 0; $i < sizeof($_POST['id_product']); $i++) {
		array_push($list_products, [
			'id_product' => $_POST['id_product'][$i],
			'precio_product' => $_POST['precio_product'][$i],
			'stock_product' => $_POST['cantidad_product'][$i],
			'fecha_product' => $_POST['fecha_product'][$i]
		]);
	}
	$model->setDatos($_POST, $list_products);
	$mensaje = $model->Entrada_productos();

	header("Location: " . constant("URL") . "entradas/form/$mensaje");
}

function fn_Entrada_asincrona()
{
	$model = new m_entrada_salida();
	// ESTA OPEACION ORDENA TODOS LOS PRODUCTOS EN UN GRAN ARREGLO PARA UN MEJOR ORDEN EN LA TRANSACCION
	$list_products = [];
	for ($i = 0; $i < sizeof($_POST['id_product']); $i++) {
		$id = isset($_POST['id_product'][$i]) ? $_POST['id_product'][$i] : "";
		$precio = isset($_POST['precio_product'][$i]) ? $_POST['precio_product'][$i] : "";
		$cantidad = isset($_POST['cantidad_product'][$i]) ? $_POST['cantidad_product'][$i] : "";
		$fecha = isset($_POST['fecha_product'][$i]) ? $_POST['fecha_product'][$i] : "";

		array_push($list_products, [
			'id_product' => $id,
			'precio_product' => $precio,
			'stock_product' => $cantidad,
			'fecha_product' => $fecha
		]);
	}
	$model->setDatos($_POST, $list_products);
	$mensaje = $model->Entrada_productos();

	if ($mensaje == "msg/01DONE") print json_encode(["data" => ["code" => "success", "message" => "Operación Exitosa"]]);
	else print json_encode(["data" => ["code" => "error", "message" => "Operación Fallida"]]);
}

function fn_Salida()
{
	$model = new m_entrada_salida();
	// ESTA OPEACION ORDENA TODOS LOS PRODUCTOS EN UN GRAN ARREGLO PARA UN MEJOR ORDEN EN LA TRANSACCION
	$list_products = [];
	for ($i = 0; $i < sizeof($_POST['id_product']); $i++) {
		array_push($list_products, [
			'id_product' => $_POST['id_product'][$i],
			'stock_product' => $_POST['cantidad_product'][$i],
		]);
	}
	$model->setDatos($_POST, $list_products);
	$mensage = $model->Salida_productos();

	header("Location: " . constant("URL") . "salidas/form/$mensage");
}

function fn_consultar_menus_recientes(){
	$model = new m_entrada_salida();
	$resultado = $model->menus_recientes();
	print json_encode(['data' => $resultado]);
}

function fn_Consultar_todos_entradas()
{
	$model = new m_entrada_salida();
	$results = $model->Get_todos_invent("E");

	print json_encode(["data" => $results]);
}

function fn_Consultar_nextId()
{
	$model = new m_entrada_salida();
	$results = $model->NextId($_GET['type']);

	print json_encode(["data" => $results]);
}

function fn_Consultar_todos_salidas()
{
	$model = new m_entrada_salida();
	$results = $model->Get_todos_invent("S");

	print json_encode(["data" => $results]);
}

function fn_Consultar_invent()
{
	$model = new m_entrada_salida();
	$model->setDatos(["id_invent" => $_GET["id_invent"]]);
	$result = $model->Get_Consultar_invent();
	echo $result;
}
