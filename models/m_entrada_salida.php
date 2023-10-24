<?php
require_once("m_db.php");

class m_entrada_salida extends m_db
{
	private $id_invent, $orden_invent, $status_invent, $cantidad_invent, $type_operation_invent, $concept_invent, $person_id_invent, $comedor_id_invent, $user_id_invent, $observacion_invent, $productos,
		$fecha_invent, $recibe_person_id_invent, $if_credito, $jornada_id_invent;

	public function __construct()
	{
		parent::__construct();
		$this->id_invent = $this->orden_invent = $this->jornada_id_invent = $this->status_invent = $this->cantidad_invent = $this->type_operation_invent = $this->concept_invent = $this->person_id_invent = $this->comedor_id_invent = $this->user_id_invent = $this->observacion_invent = $this->productos = $this->fecha_invent = $this->recibe_person_id_invent = $this->if_credito = "";
	}

	public function setDatos($d, $productos = [])
	{
		$this->id_invent = isset($d['id_invent']) ? $d['id_invent'] : null;
		$this->orden_invent = isset($d['orden_invent']) ? $this->Clean(intval($d['orden_invent'])) : null;
		$this->status_invent = isset($d['status_invent']) ? $d['status_invent'] : null;
		$this->type_operation_invent = isset($d['type_operation_invent']) ? $d['type_operation_invent'] : null;
		$this->concept_invent = isset($d['concept_invent']) ? $d['concept_invent'] : null;
		$this->person_id_invent = isset($d['person_id_invent']) ? $d['person_id_invent'] : null;
		$this->recibe_person_id_invent = isset($d['recibe_person_id_invent']) ? $d['recibe_person_id_invent'] : null;
		$this->comedor_id_invent = isset($d['comedor_id_invent']) ? $d['comedor_id_invent'] : null;
		$this->user_id_invent = isset($d['user_id_invent']) ? $d['user_id_invent'] : 1;
		$this->observacion_invent = isset($d['observacion_invent']) ? $this->Clean($d['observacion_invent']) : null;
		$this->cantidad_invent = isset($d['cantidad_invent']) ? $this->Clean(intVal($d['cantidad_invent'])) : null;
		$this->productos = isset($productos) ? $productos : null;
		$this->fecha_invent = isset($d['fecha_invent']) ? $d['fecha_invent'] : null;
		$this->if_credito = isset($d['if_credito']) ? $d['if_credito'] : 0;
		$this->jornada_id_invent = isset($d['jornada_id_invent']) ? $d['jornada_id_invent'] : NULL;
	}

	public function Entrada_productos()
	{
		if(!isset($_SESSION['user_id'])) session_start();
		// TRANSACCTION
		$status_transaccion = true;
		$sql_inventario_insert = "INSERT INTO inventario(id_invent,orden_invent,cantidad_invent,status_invent,created_invent,type_operacion_invent,
            concept_invent,if_credito,jornada_id_invent,person_id_invent,recibe_person_id_invent,comedor_id_invent,user_id_invent,observacion_invent) 
            VALUES (
                '$this->id_invent','$this->orden_invent',$this->cantidad_invent,1,'$this->fecha_invent','E',
                '$this->concept_invent',$this->if_credito,null,$this->person_id_invent,$this->recibe_person_id_invent,
                $this->comedor_id_invent,$this->user_id_invent,'$this->observacion_invent')";

		try {

			$this->Start_transacction();
			$results_invent = $this->Query($sql_inventario_insert);

			if ($this->Result_last_query() || true) {

				foreach ($this->productos as $producto) {
					$id = $producto['id_product'];
					$precio = isset($producto['precio_product']) && $producto['precio_product'] != null ? $producto['precio_product'] : 0;
					$fecha = $producto['fecha_product'];
					$stock = $producto['stock_product'];

					if ($fecha != "") $sql_operacion = "INSERT INTO detalle_inventario(product_id_ope,invent_id_ope,fecha_vencimiento_ope,precio_product_ope,detalle_cantidad) VALUES ($id,'$this->id_invent','$fecha',$precio,$stock)";
					else $sql_operacion = "INSERT INTO detalle_inventario(product_id_ope,invent_id_ope,fecha_vencimiento_ope,precio_product_ope,detalle_cantidad) VALUES ($id,'$this->id_invent',NULL,$precio,$stock)";

					$sql_producto_stock = "UPDATE productos SET productos.stock_product = (SELECT SUM(productos.stock_product + $stock) 
                        WHERE productos.id_product = $id) WHERE productos.id_product = $id";


					$results_operacion = $this->Query($sql_operacion);
					if (!$this->Result_last_query()) {
						$status_transaccion = false;
						break;
					}
					
					$results_producto_stock = $this->Query($sql_producto_stock);
					if (!$this->Result_last_query()) {
						$status_transaccion = false;
						break;
					}
				}
			} else {
				$status_transaccion = false;
				$this->Rollback();
			}

			if ($status_transaccion) {
				$this->End_transacction();
				$this->reg_bitacora([
					'user_id' => $_SESSION['user_id'],
					'table_name'=> "INVENTARIO-DETALLE_INVENTARIO",
					'des' => "TRANSACCIÓN DE ENTRADA DE PRODUCTOS| ID INVENTARIO: $this->id_invent, CANTIDAD: $this->cantidad_invent, OBSERVACIÓN: $this->observacion_invent"
				]);
				return "msg/01DONE";
			} else {
				$this->Rollback();
				return "err/01ERR";
			}
		} catch (Exception $e) {
			die("AH OCURRIDO UN ERROR: " . $e->getMessage());
		}
	}

	public function Salida_productos()
	{
		// TRANSACCTION
		$status_transaccion = true;
		$sql_inventario_insert = "INSERT INTO inventario(
                id_invent,orden_invent,cantidad_invent,status_invent,created_invent,type_operacion_invent,
                concept_invent,if_credito,jornada_id_invent,person_id_invent,recibe_person_id_invent,
                comedor_id_invent,user_id_invent,observacion_invent) 
            VALUES (
                '$this->id_invent','$this->orden_invent',$this->cantidad_invent,1,'$this->fecha_invent','S',
                '$this->concept_invent',null,'$this->jornada_id_invent',null,$this->recibe_person_id_invent,
                $this->comedor_id_invent,$this->user_id_invent,'$this->observacion_invent')";

		try {
			$sql_inventario_insert = str_ireplace("''", "NULL", $sql_inventario_insert);
			$this->Start_transacction();
			$results_invent = $this->Query($sql_inventario_insert);

			if ($this->Result_last_query()) {

				foreach ($this->productos as $producto) {
					$id = $producto['id_product'];
					$stock = $producto['stock_product'];

					$sql_operacion = "INSERT INTO detalle_inventario(product_id_ope,invent_id_ope,fecha_vencimiento_ope,precio_product_ope,detalle_cantidad) 
                        VALUES ($id,'$this->id_invent',null,null,$stock)";

					$IN_stock = $this->Get_array($this->Query("SELECT productos.stock_product FROM productos WHERE productos.id_product = $id"))[0];
					$sql_producto_stock = "UPDATE productos SET productos.stock_product =( $IN_stock - $stock) WHERE productos.id_product = $id;";

					$results_operacion = $this->Query($sql_operacion);
					if (!$this->Result_last_query()) {
						$status_transaccion = false;
						break;
					}

					$results_producto_stock = $this->Query($sql_producto_stock);
					if (!$this->Result_last_query()) {
						$status_transaccion = false;
						break;
					}
				}
			} else {
				$status_transaccion = false;
				$this->Rollback();
			}

			if ($status_transaccion) {
				$this->End_transacction();
				$this->reg_bitacora([
					'user_id' => $_SESSION['user_id'],
					'table_name'=> "INVENTARIO - DETALLE_INVENTARIO",
					'des' => "TRANSACCIÓN DE SALIDA DE PRODUCTOS| ID INVENTARIO: $this->id_invent, CANTIDAD: $this->cantidad_invent, OBSERVACIÓN: $this->observacion_invent"
				]);
				return "msg/01DONE";
			} else {
				$this->Rollback();
				return "err/01ERR";
			}
		} catch (Exception $e) {
			die("AH OCURRIDO UN ERROR: " . $e->getMessage());
		}
	}

	public function Get_todos_invent($type_operacion)
	{
		$second_inner = $select_person = "";
		if ($type_operacion == "E") $second_inner = "INNER JOIN personas ON personas.id_person = inventario.person_id_invent";
		if ($type_operacion == "E") $select_person = "personas.nom_person,";

		$sql = "SELECT inventario.id_invent, inventario.orden_invent, inventario.concept_invent, inventario.status_invent, inventario.created_invent,
            $select_person cantidad_invent FROM inventario 
            INNER JOIN detalle_inventario ON detalle_inventario.invent_id_ope = inventario.id_invent $second_inner WHERE
            inventario.type_operacion_invent = '$type_operacion' GROUP BY inventario.id_invent;";

		return $this->Get_todos_array($this->query($sql));
	}

	public function Get_Consultar_invent()
	{
		$persona = [];
		$sql_inventario = "SELECT * FROM inventario INNER JOIN comedor ON inventario.comedor_id_invent = comedor.id_comedor 
            WHERE inventario.id_invent = '$this->id_invent' ;";

		$sql_productos = "SELECT * FROM detalle_inventario 
            INNER JOIN productos ON productos.id_product = detalle_inventario.product_id_ope 
            INNER JOIN marca ON marca.id_marca = productos.marca_id_product
            WHERE detalle_inventario.invent_id_ope = '$this->id_invent'";

		$datos_inventario = $this->Get_array($this->Query($sql_inventario));
		$datos_productos = $this->Get_todos_array($this->Query($sql_productos));

		$sql_encargado = "SELECT * FROM personas WHERE id_person = " . $datos_inventario['encargado_comedor'];
		$sql_usuario = "SELECT * FROM usuarios 
            INNER JOIN roles_usuario ON roles_usuario.id = usuarios.id_rol
            INNER JOIN personas ON usuarios.person_id_user = personas.id_person WHERE usuarios.id_user = " . $datos_inventario['user_id_invent'];

		$datos_usuario = $this->Get_array($this->Query($sql_usuario));
		$datos_encargado = $this->Get_array($this->Query($sql_encargado));

		if ($datos_inventario['type_operacion_invent'] == "S") {
			$datos_persona2 = $this->BuscarPersona($this->id_invent, "recibe_person_id_invent");
			$persona = [
				'persona' => [
					'tipo_persona' => $datos_persona2['tipo_person'],
					'cedula' => $datos_persona2['cedula_person'],
					'nom' => $datos_persona2['nom_person'],
					'telf' => $datos_persona2['telefono_movil_person'],
				]
			];
		} else {
			$datos_persona = $this->BuscarPersona($this->id_invent, "person_id_invent");
			$persona = [
				'persona' => [
					'tipo_persona' => $datos_persona['tipo_person'],
					'cedula' => $datos_persona['cedula_person'],
					'nom' => $datos_persona['nom_person'],
					'telf' => $datos_persona['telefono_movil_person'],
				]
			];
		}

		require_once("table_content_inventario.php");
	}

	public function ExistProducts()
	{
		$sql = "SELECT productos.id_product,productos.nom_product,productos.med_product,productos.valor_product,
                inventario.id_invent,inventario.created_invent,detalle_inventario.detalle_cantidad,detalle_inventario.fecha_vencimiento_ope,
                detalle_inventario.precio_product_ope,grupo.nom_grupo FROM detalle_inventario
                INNER JOIN inventario ON inventario.id_invent = detalle_inventario.invent_id_ope
                INNER JOIN productos ON productos.id_product = detalle_inventario.product_id_ope
                INNER JOIN grupo ON grupo.id_grupo = productos.grupo_id_product WHERE
                detalle_inventario.fecha_vencimiento_ope != '' GROUP BY detalle_inventario.fecha_vencimiento_ope";
		return $this->Get_todos_array($this->query($sql));
	}

	public function NextId($tipo)
	{
		$count = 1;
		$digits = 8;
		$result = $this->Query("SELECT MAX(id_invent) AS id_invent FROM inventario WHERE type_operacion_invent = '$tipo' ;");
		if ($result->num_rows == 0) return "$tipo-00000001";
		$valor = $this->Get_array($result)['id_invent'];
		if ($valor == null) return "$tipo-00000001";
		$start = (intval(explode("-", $valor)[1]) + 1);

		for ($n = $start; $n < $start + $count; $n++) $new_code = str_pad($n, $digits, "0", STR_PAD_LEFT);
		if (strlen($new_code) < 8) return "$tipo-0" . $new_code;
		else return  "$tipo-$new_code";
	}

	public function GetPdf($codigo)
	{
		$datos_pdf = [];
		$persona = [];
		$sql_inventario = "SELECT * FROM inventario 
		INNER JOIN comedor ON inventario.comedor_id_invent = comedor.id_comedor 
		LEFT JOIN jornada ON jornada.id_jornada = inventario.jornada_id_invent
		LEFT JOIN menu ON menu.id_menu = jornada.menu_id_jornada
		WHERE inventario.id_invent = '$codigo' ;";
		$sql_productos = "SELECT * FROM detalle_inventario 
            INNER JOIN productos ON productos.id_product = detalle_inventario.product_id_ope 
            WHERE detalle_inventario.invent_id_ope = '$codigo'";

		$datos_inventario = $this->Get_array($this->Query($sql_inventario));
		$datos_productos = $this->Get_todos_array($this->Query($sql_productos));

		if ($datos_inventario['type_operacion_invent'] == "S") {
			$datos_persona2 = $this->BuscarPersona($codigo, "recibe_person_id_invent");
			$persona = [
				'quien_recibe' => [
					'tipo_persona' => $datos_persona2['tipo_person'],
					'cedula' => $datos_persona2['cedula_person'],
					'nom' => $datos_persona2['nom_person'],
					'telf' => $datos_persona2['telefono_movil_person'],
				]
			];
		} else {
			$datos_persona = $this->BuscarPersona($codigo, "person_id_invent");
			$persona = [
				'proveedor' => [
					'tipo_persona' => $datos_persona['tipo_person'],
					'cedula' => $datos_persona['cedula_person'],
					'nom' => $datos_persona['nom_person'],
					'telf' => $datos_persona['telefono_movil_person'],
				]
			];
		}

		array_push($datos_pdf, [
			'doc' => [
				'id' => $datos_inventario['id_invent'],
				'fecha' => $datos_inventario['created_invent'],
				'orden' => $datos_inventario['orden_invent'],
				'concepto' => $datos_inventario['concept_invent'],
				'observacion' => $datos_inventario['observacion_invent'],
				'id_jornada' => $datos_inventario['id_jornada'],
				'titulo_jornada' => $datos_inventario['titulo_jornada'],
				'des_jornada' => $datos_inventario['des_jornada'],
				'cant_aproximada' => $datos_inventario['cant_aproximada'],
				'des_menu' => $datos_inventario['des_menu'],
			],
			'comedor' => [
				'nom' => $datos_inventario['nom_comedor'],
				'direccion' => $datos_inventario['direccion_comedor']
			],
			'productos' => [$datos_productos],
			'persona' => [$persona],
		]);

		// var_dump($datos_pdf[0]['productos']);

		return $datos_pdf;
	}
	public function GetPdfWithFiltros($filtro, $desde = '', $hasta = '')
	{
		$persona = [];

		if ($desde == '') {
			$sql_inventario = "SELECT * FROM inventario 
					INNER JOIN comedor ON inventario.comedor_id_invent = comedor.id_comedor 
					LEFT JOIN jornada ON jornada.id_jornada = inventario.jornada_id_invent
					LEFT JOIN menu ON menu.id_menu = jornada.menu_id_jornada
					WHERE inventario.concept_invent = '$filtro' GROUP BY inventario.id_invent;";
		} else {
			$hasta = date("Y-m-d h:i:s",strtotime($hasta. "+ 1 days"));
			$desde = date("Y-m-d h:i:s",strtotime($desde. "- 1 days"));
			$sql_inventario = "SELECT * FROM inventario 
					INNER JOIN comedor ON inventario.comedor_id_invent = comedor.id_comedor 
					LEFT JOIN jornada ON jornada.id_jornada = inventario.jornada_id_invent
					LEFT JOIN menu ON menu.id_menu = jornada.menu_id_jornada
					WHERE inventario.concept_invent = '$filtro'AND inventario.created_invent BETWEEN '$desde' AND '$hasta' GROUP BY inventario.id_invent;";
		}

		$datos_inventario = $this->Get_todos_array($this->Query($sql_inventario));
		$datos = [];

		foreach ($datos_inventario as $item_i) {
			$code = $item_i['id_invent'];
			$sql_productos = "SELECT * FROM detalle_inventario 
					INNER JOIN productos ON productos.id_product = detalle_inventario.product_id_ope 
					INNER JOIN marca ON marca.id_marca = productos.marca_id_product
					WHERE detalle_inventario.invent_id_ope = '$code';";
			// GROUP BY detalle_inventario.invent_id_ope					

			$datos_productos = $this->Get_todos_array($this->Query($sql_productos));

			if ($item_i['type_operacion_invent'] == "S") {
				$datos_persona2 = $this->BuscarPersona($code, "recibe_person_id_invent");
				$persona = [
					'quien_recibe' => [
						'tipo_persona' => $datos_persona2['tipo_person'],
						'cedula' => $datos_persona2['cedula_person'],
						'nom' => $datos_persona2['nom_person'],
						'telf' => $datos_persona2['telefono_movil_person'],
					]
				];
			} else {
				$datos_persona = $this->BuscarPersona($code, "person_id_invent");
				$persona = [
					'proveedor' => [
						'tipo_persona' => $datos_persona['tipo_person'],
						'cedula' => $datos_persona['cedula_person'],
						'nom' => $datos_persona['nom_person'],
						'telf' => $datos_persona['telefono_movil_person'],
					]
				];
			}

			array_push($datos, [
				'invent' => $item_i,
				'persona' => $persona,
				'comedor' => [
					'nom' => $item_i['nom_comedor'],
					'direccion' => $item_i['direccion_comedor']
				],
				'products' => $datos_productos
			]);
		}

		return $datos;
	}

	private function BuscarPersona($id_invent, $column_table)
	{
		$sql = "SELECT * FROM inventario INNER JOIN personas ON personas.id_person = inventario.$column_table WHERE inventario.id_invent = '$id_invent' ;";
		return $this->Get_array($this->Query($sql));
	}
}
