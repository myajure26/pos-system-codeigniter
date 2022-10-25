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

		$db->transComplete();

		if ($db->transStatus() === false) {
			return false;
		}

		return $purchaseId;
	}

	public function getPurchases()
	{
		$query = $this
			->select('compras.identificacion, proveedores.nombre, fecha, referencia, compras.estado')
			->join('proveedores', 'proveedores.codigo = compras.proveedor');
		return $query;
	}

	public function getPurchaseById($data)
	{
		$query = $this
				->select('compras.identificacion as idCompra, fecha, compras.proveedor, proveedores.nombre as nombreProveedor, tipo_documento, referencia, compras.moneda, compras.actualizado_en, compras.creado_en, detalle_compra.identificacion as idDetalleCompra, detalle_compra.producto, cantidad, detalle_compra.precio, productos.codigo, productos.nombre, usuarios.nombre as usuario, compras.estado')
				->join('detalle_compra', 'detalle_compra.compra = compras.identificacion')
				->join('productos', 'productos.codigo = detalle_compra.producto')
				->join('proveedores', 'proveedores.codigo = compras.proveedor')
				->join('usuarios', 'usuarios.identificacion = compras.usuario')
				->where($data);
		return $query->get()->getResultArray();
	}

	public function getLastId()
	{
		return $this->insertID();
	}

	public function updatePurchase($purchase, $purchaseDetails, $id)
	{
		$db = \Config\Database::connect();
		$db->transStart();
		
		$db
			->table('compras')
			->where('identificacion', $id)
			->set($purchase)
			->update();
		
		$db
			->table('detalle_compra')
			->updateBatch($purchaseDetails, 'identificacion');
		
		$db->transComplete();

		if ($db->transStatus() === false) {
			return false;
		}

		return true;
	}

	public function deletePurchase($identification)
	{
		$query = $this
				->where('identificacion', $identification)
				->set('estado', 0)
				->update();
		return $query;
	}

	public function recoverPurchase($identification)
	{
		$query = $this
				->where('identificacion', $identification)
				->set('estado', 1)
				->update();
		return $query;
	}
}
