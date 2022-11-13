<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'ventas';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = ["proveedor", "usuario", "fecha", "tipo_documento", "referencia", "moneda", "estado", "actualizado_en", "creado_en"];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'creado_en';
	protected $updatedField         = 'actualizado_en';

	public function createSale($sale, $saleDetails)
	{

		$db = \Config\Database::connect();
		$db->transStart();
		
		$db->table('ventas')->insert($sale);
		
		//Obtener ID de la compra
		$saleId = $db->insertID();

		//Insertar el ID al arreglo
		for($i = 0; $i < count($saleDetails); $i++){
			$saleDetails[$i]['venta'] = $saleId;
		}

		$db->table('detalle_ventas')->insertBatch($saleDetails);

		// Restar al stock
		foreach($saleDetails as $saleDetail){

			$code = $saleDetail['producto'];
			$quantity = $saleDetail['cantidad'];

			$db 
			->query("UPDATE productos SET cant_producto = cant_producto - $quantity  WHERE codigo = '$code'");
		
		}

		$db->transComplete();

		if ($db->transStatus() === false) {
			return false;
		}

		return $saleId;
	}

	public function getSales()
	{
		$query = $this
			->select('ventas.identificacion, clientes.identificacion as cliente, usuarios.nombre as vendedor, ventas.creado_en AS fecha, ventas.estado, monedas.simbolo, impuestos.porcentaje as impuesto')
			->join('clientes', 'clientes.identificacion = ventas.cliente')
			->join('usuarios', 'usuarios.identificacion = ventas.usuario')
			->join('monedas', 'monedas.identificacion = ventas.moneda')
			->join('impuestos', 'impuestos.identificacion = ventas.impuesto');
		return $query;
	}

	public function getSaleById($data)
	{
		$query = $this
				->select('ventas.identificacion as idVenta, clientes.identificacion as clienteId, tipo_documento, tasa, impuesto, id_metodo_pago as metodoPago, ventas.moneda, ventas.actualizado_en, ventas.creado_en, detalle_ventas.identificacion as idDetalleVenta, detalle_ventas.producto, cantidad, detalle_ventas.precio, productos.codigo, productos.nombre, usuarios.nombre as vendedor, ventas.estado')
				->join('detalle_ventas', 'detalle_ventas.venta = ventas.identificacion')
				->join('productos', 'productos.codigo = detalle_ventas.producto')
				->join('clientes', 'clientes.identificacion = ventas.cliente')
				->join('usuarios', 'usuarios.identificacion = ventas.usuario')
				->where($data);
		return $query->get()->getResultArray();
	}

	public function getRate($identification){
		
		$db = \Config\Database::connect();

		$where = "DATE_FORMAT(creado_en, '%Y-%m-%d') = CURDATE()";

		$db = $db
				->table('precio_monedas')
				->select('precio, creado_en')
				->where('moneda_secundaria', $identification)
				->where($where)
				->orderBy('creado_en', 'DESC');
		return $db->get()->getResultArray();
		
	}

	public function getLastId()
	{
		return $this->insertID();
	}


	public function deleteSale($identification)
	{

		$db = \Config\Database::connect();
		$db->transStart();

		$stock = $db
				->table('detalle_ventas')
				->select('producto, cantidad')
				->where('venta', $identification)
				->get()->getResult();

		foreach($stock as $row){
			$db->query("UPDATE productos SET cant_producto = cant_producto + $row->cantidad  WHERE codigo = '$row->producto'");
		}

		$db->table('ventas')
			->where('identificacion', $identification)
			->set('estado', 0)
			->update();

		$db->transComplete();

		if ($db->transStatus() === false) {
			return false;
		}

		return true;
		
	}

}
