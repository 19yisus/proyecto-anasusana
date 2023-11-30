<?php
require_once("m_db.php");

class m_productos extends m_db
{
	private $id_producto, $nom_producto, $status_producto, $med_producto, $valor_producto, $stock_producto, $marca_id_producto, $stock_maximo_producto;

	public function __construct()
	{
		parent::__construct();
		$this->id_producto = $this->nom_producto = $this->status_producto = $this->med_producto = $this->valor_producto = $this->stock_producto = $this->marca_id_producto = $this->stock_maximo_producto = "";
	}

	public function setDatos($d)
	{
		$this->id_producto = isset($d['id_producto']) ? $this->Clean(intval($d['id_producto'])) : null;
		$this->nom_producto = isset($d['nom_producto']) ? $this->Clean($d['nom_producto']) : null;
		$this->status_producto = isset($d['status_producto']) ? $this->Clean(intval($d['status_producto'])) : null;
		$this->med_producto = isset($d['med_producto']) ? $this->Clean($d['med_producto']) : null;
		$this->valor_producto = isset($d['valor_producto']) ? $this->Clean(intval($d['valor_producto'])) : null;
		$this->stock_producto = isset($d['stock_producto']) ? $this->Clean(intval($d['stock_producto'])) : null;
		$this->stock_maximo_producto = isset($d['stock_maximo_producto']) ? $this->Clean(intval($d['stock_maximo_producto'])) : null;
		$this->marca_id_producto = isset($d['marca_id_producto']) ? $this->Clean($d['marca_id_producto']) : null;
	}

	public function Create()
	{
		$sqlVerificar = "SELECT * FROM productos WHERE nom_product = '$this->nom_producto' AND marca_id_product = $this->marca_id_producto;";
		$sqlVerificar=str_replace("AND marca_id_product = ;",";", $sqlVerificar);
		
		$result = $this->Query($sqlVerificar);
		if ($result->num_rows > 0) return "err/02ERR";

		$sql = "INSERT INTO productos(id_product, nom_product, med_product, valor_product, status_product, created_product, stock_product, stock_maximo_product, marca_id_product)
            VALUES(null,'$this->nom_producto', '$this->med_producto', '$this->valor_producto', $this->status_producto, NOW(), 0, $this->stock_maximo_producto, $this->marca_id_producto);";
		$sql=str_replace(", )",",null)", $sql);
		
		$this->Query($sql);

		if (!isset($_SESSION['user_id'])) session_start();

		if ($this->Result_last_query()) {
			$this->reg_bitacora([
				'user_id' => $_SESSION['user_id'],
				'table_name' => "PRODUCTOS",
				'des' => "REGISTRO DE NUEVO PRODUCTO: $this->nom_producto, UNIDAD: $this->med_producto, VALOR: $this->valor_producto, STOCK MAXIMO: $this->stock_maximo_producto"
			]);
			return "msg/01DONE";
		} else return "err/01ERR";
	}

	public function Update()
	{
		$sqlVerificar = "SELECT * FROM productos WHERE nom_product = '$this->nom_producto' AND id_product != $this->id_producto ;";
		$result = $this->Query($sqlVerificar);

		if ($result->num_rows > 0) return ["code" => "error", "message" => "Operación Fallida!, el regitro no se puede duplicar"];
		$sql = "UPDATE productos SET nom_product = '$this->nom_producto', med_product = '$this->med_producto',
            valor_product = '$this->valor_producto', marca_id_product = $this->marca_id_producto ,
            stock_maximo_product = '$this->stock_maximo_producto' WHERE id_product = $this->id_producto ;";
		
		$sql=str_replace(", marca_id_product =  ","", $sql);
				
		$this->Query($sql);

		if (!isset($_SESSION['user_id'])) session_start();

		$this->reg_bitacora([
			'user_id' => $_SESSION['user_id'],
			'table_name' => "PRODUCTOS",
			'des' => "ACTUALIZACIÓN DE PRODUCTO: $this->nom_producto, UNIDAD: $this->med_producto, VALOR: $this->valor_producto, STOCK MAXIMO: $this->stock_maximo_producto"
		]);
		return ["code" => "success", "message" => "Operación Exitosa"];
	}

	public function Disable()
	{
		if ($this->status_producto == 0) $sqlConsulta = "SELECT * FROM productos WHERE stock_product > 0 AND id_product = $this->id_producto ;";
		else $sqlConsulta = "SELECT * FROM productos WHERE status_product = $this->status_producto AND id_product = $this->id_producto ;";

		$result = $this->Query($sqlConsulta);

		if ($result->num_rows > 0) return ["code" => "error", "message" => "NO es posible cambiar el estado de este producto o alimento"];

		$sql = "UPDATE productos SET status_product = $this->status_producto WHERE id_product = $this->id_producto ;";
		$this->Query($sql);

		if (!isset($_SESSION['user_id'])) session_start();

		if ($this->Result_last_query()) {
			if ($this->status_producto == 0) $des_estatus = "DESACTIVACIÓN";
			else $des_estatus = "ACTIVACIÓN";
			$this->reg_bitacora([
				'user_id' => $_SESSION['user_id'],
				'table_name' => "PRODUCTO",
				'des' => "$des_estatus DEL PRODUCTO: ID => $this->id_producto"
			]);

			return ["code" => "success", "message" => "Operación Exitosa"];
		} else return ["code" => "error", "message" => "Operación Fallida"];
	}

	public function Delete()
	{
		$sqlConsulta = "SELECT * FROM detalle_inventario WHERE product_id_ope = $this->id_producto ;";
		$result = $this->Query($sqlConsulta);

		if ($result->num_rows > 0) return ["code" => "error", "message" => "No es posible eliminar este producto, ya que esta registrado en el inventario"];

		$sql = "DELETE FROM productos WHERE id_product = $this->id_producto AND status_product = '0' ;";
		$this->Query($sql);

		if (!isset($_SESSION['user_id'])) session_start();

		if ($this->Result_last_query()) {
			$this->reg_bitacora([
				'user_id' => $_SESSION['user_id'],
				'table_name' => "PRODUCTOS",
				'des' => "ELIMINACIÓN DEL PRODUCTO: ID => $this->id_producto"
			]);

			return ["code" => "success", "message" => "Operación Exitosa"];
		} else return ["code" => "error", "message" => "Operación Fallida"];
	}

	public function Get_todos_productos($status = '')
	{
		if ($status != '') $condition = "WHERE productos.status_product = '1' ";
		else $condition = "";
		$sql = "SELECT * FROM productos LEFT JOIN marca ON marca.id_marca = productos.marca_id_product $condition ORDER BY productos.nom_product ASC;";

		if ($status === 2) {
			$sql = "SELECT DISTINCT productos.id_product, productos.*, marca.* FROM productos 
				LEFT JOIN marca ON marca.id_marca = productos.marca_id_product
				INNER JOIN detalle_inventario ON detalle_inventario.product_id_ope = productos.id_product $condition ORDER BY productos.nom_product ASC;";
		}

		// GROUP BY productos.id_product
		$results = $this->query($sql);
		if ($results->num_rows > 0) return $this->Get_todos_array($results);
		else return [];
	}

	public function Get_producto()
	{
		$sql = "SELECT * FROM productos WHERE id_product = $this->id_producto ;";
		$results = $this->Query($sql);
		return $this->Get_array($results);
	}

	public function Get_productos_minimos()
	{
		$sql = "SELECT * FROM productos LEFT JOIN marca ON marca.id_marca = productos.marca_id_product WHERE productos.stock_product < 5 ORDER BY productos.stock_product ASC LIMIT 0,7";
		$results = $this->Query($sql);
		if ($results->num_rows > 0) return $this->Get_todos_array($results); else return [];
	}

	public function GetPdf($filtro, $id = "")
	{
		if ($filtro == "Todos") $sql = "SELECT * FROM productos LEFT JOIN marca ON marca.id_marca = productos.marca_id_product";
		if ($filtro == "Marcas") $sql = "SELECT * FROM productos INNER JOIN marca ON marca.id_marca = productos.marca_id_product WHERE marca.id_marca = $id;";
		if ($filtro == "Unidades") $sql = "SELECT * FROM productos LEFT JOIN marca ON marca.id_marca = productos.marca_id_product WHERE productos.med_product = '$id';";
		if ($filtro == "Stock_max") $sql = "SELECT * FROM productos LEFT JOIN marca ON marca.id_marca = productos.marca_id_product WHERE productos.stock_product = productos.stock_maximo_product;";
		$results = $this->query($sql);
		if ($results->num_rows > 0) return $this->Get_todos_array($results);
		else return [];
	}
}
