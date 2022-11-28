<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'compras';
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

	public function createPurchase($purchase, $purchaseDetails)
	{

		$db = \Config\Database::connect();
		$db->transStart();
		
		$db->table('compras')->insert($purchase);
		
		//Obtener ID de la compra
		$purchaseId = $db->insertID();

		//Insertar el ID al arreglo
		for($i = 0; $i < count($purchaseDetails); $i++){
			$purchaseDetails[$i]['compra'] = $purchaseId;
		}

		$db->table('detalle_compra')->insertBatch($purchaseDetails);

		// Agregar al stock
		foreach($purchaseDetails as $purchaseDetail){

			$code = $purchaseDetail['producto'];
			$quantity = $purchaseDetail['cantidad'];

			$db 
			->query("UPDATE productos SET cant_producto = cant_producto + $quantity  WHERE codigo = '$code'");
		
		}

		$db->transComplete();

		if ($db->transStatus() === false) {
			return false;
		}

		return $purchaseId;
	}

	public function getPurchases()
	{
		$query = $this
			->select('compras.identificacion, proveedor, fecha, referencia, compras.estado, monedas.simbolo')
			->join('monedas', 'monedas.identificacion = compras.moneda');
		return $query;
	}

	public function getPurchaseById($data)
	{
		$query = $this
				->select('fecha, proveedor, tipo_documento, referencia, compras.moneda, compras.actualizado_en, compras.creado_en, detalle_compra.producto, ancho_caucho.ancho_numero, alto_caucho.alto_numero, categorias.categoria, marcas.marca, cantidad, detalle_compra.precio, productos.codigo, productos.nombre, usuarios.nombre as usuario, compras.estado')
				->join('detalle_compra', 'detalle_compra.compra = compras.identificacion')
				->join('productos', 'productos.codigo = detalle_compra.producto')
				->join('ancho_caucho', 'ancho_caucho.id_ancho_caucho = productos.id_ancho_caucho')
				->join('alto_caucho', 'alto_caucho.id_alto_caucho = productos.id_alto_caucho')
				->join('marcas', 'marcas.identificacion = productos.marca')
				->join('categorias', 'categorias.identificacion = productos.categoria')
				->join('usuarios', 'usuarios.identificacion = compras.usuario')
				->where($data);
		return $query->get()->getResultArray();
	}

	public function getLastId()
	{
		return $this->insertID();
	}


	public function deletePurchase($identification)
	{
		$db = \Config\Database::connect();
		$db->transStart();

		$stock = $db
				->table('detalle_compra')
				->select('producto, cantidad')
				->where('compra', $identification)
				->get()->getResult();

		foreach($stock as $row){
			$db->query("UPDATE productos SET cant_producto = cant_producto - $row->cantidad  WHERE codigo = '$row->producto'");
		}

		$db->table('compras')
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
