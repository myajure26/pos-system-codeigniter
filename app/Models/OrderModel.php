<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'pedido';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = ["id_pedido","ci_rif_proveedor", "ci_usuario", "id_tipo_documento", "id_moneda", "estado_pedido", "actualizado_en", "creado_en"];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'creado_en';
	protected $updatedField         = 'actualizado_en';

	public function createOrder($order, $orderDetails)
	{

		$db = \Config\Database::connect();
		$db->transStart();
		
		$db->table('pedido')->insert($order);
		
		//Obtener ID del pedido
		$orderId = $order['id_pedido'];

		//Insertar el ID al arreglo
		for($i = 0; $i < count($orderDetails); $i++){
			$orderDetails[$i]['id_pedido'] = $orderId;
		}

		$db->table('detalle_pedido')->insertBatch($orderDetails);

		$db->transComplete();

		if ($db->transStatus() === false) {
			return false;
		}

		return $orderId;
	}

	public function verifyProviderOrder($id)
	{
		$query = $this
			->select()
			->where('ci_rif_proveedor', $id)
			->where('estado_pedido', 2)
			->get()->getResult();
		return $query;
	}

	public function getOrders()
	{
		$query = $this
			->select('pedido.id_pedido, ci_rif_proveedor, pedido.creado_en as fecha, pedido.estado_pedido, monedas.simbolo')
			->join('monedas', 'monedas.identificacion = pedido.id_moneda');
		return $query;
	}

	public function getOrderById($data)
	{
		$query = $this
				->select('pedido.id_pedido, id_detalle_pedido, ci_rif_proveedor, proveedores.nombre as proveedor_nombre, id_tipo_documento, pedido.id_moneda, pedido.actualizado_en, pedido.creado_en, detalle_pedido.cod_producto, ancho_caucho.ancho_numero, alto_caucho.alto_numero, categorias.categoria, marcas.marca, detalle_pedido.cant_producto, detalle_pedido.precio_producto, productos.nombre, usuarios.nombre as usuario, pedido.estado_pedido')
				->join('detalle_pedido', 'detalle_pedido.id_pedido = pedido.id_pedido')
				->join('productos', 'productos.codigo = detalle_pedido.cod_producto')
				->join('ancho_caucho', 'ancho_caucho.id_ancho_caucho = productos.id_ancho_caucho')
				->join('alto_caucho', 'alto_caucho.id_alto_caucho = productos.id_alto_caucho')
				->join('marcas', 'marcas.identificacion = productos.marca')
				->join('categorias', 'categorias.identificacion = productos.categoria')
				->join('proveedores', 'proveedores.identificacion = pedido.ci_rif_proveedor')
				->join('usuarios', 'usuarios.identificacion = pedido.ci_usuario')
				->where($data);
		return $query->get()->getResultArray();
	}

	public function getLastId()
	{
		return $this->insertID();
	}

	public function acceptOrder($id)
	{
		helper('generateCode');
		$db = \Config\Database::connect();
		$db->transStart();

		$purchaseCode = generateCode('CM', 'compras', 'identificacion');
		
		$db->query("INSERT INTO `compras`(`proveedor`, `usuario`, `tipo_documento`, `moneda`, `id_pedido`) SELECT ci_rif_proveedor, ci_usuario, id_tipo_documento, id_moneda, id_pedido from pedido where id_pedido = '$id'");
		
		$db->query("UPDATE compras SET identificacion = '$purchaseCode' WHERE id_pedido = '$id'");

		$db->query("INSERT INTO `detalle_compra`(`producto`, `cantidad`, `precio`, `compra`) SELECT cod_producto, cant_producto, precio_producto, '$purchaseCode' from detalle_pedido where id_pedido = '$id'");

		$stock = $db
				->table('detalle_compra')
				->select('producto, cantidad')
				->where('compra', $purchaseCode)
				->get()->getResult();
		
		foreach($stock as $row){
			$db->query("UPDATE productos SET cant_producto = cant_producto + $row->cantidad  WHERE codigo = '$row->producto'");
		}

		$db->query("UPDATE pedido SET estado_pedido = 1 WHERE id_pedido = '$id'");
		
		$db->transComplete();

		if ($db->transStatus() === false) {
			return false;
		}

		return true;
	}

	public function updateOrder($order, $orderDetails, $identification)
	{
		$db = \Config\Database::connect();
		$db->transStart();
		
		$db
			->table('pedido')
			->where('id_pedido', $identification)
			->set($order)
			->update();
		
		$db
			->table('detalle_pedido')
			->updateBatch($orderDetails, 'id_detalle_pedido');
		

		$db->transComplete();

		if ($db->transStatus() === false) {
			return false;
		}

		return true;
	}


	public function deleteOrder($identification)
	{

		$query = $this
			->where('id_pedido', $identification)
			->set('estado_pedido', 0)
			->update();

		return $query;
	}

	public function deleteProductOrder($order, $product)
	{
		$db = \Config\Database::connect();
		$db = $db
			->query('DELETE FROM detalle_pedido WHERE cod_producto = "' . $product . '" AND id_pedido = "'.$order.'"');
		return $db;
	}

}
