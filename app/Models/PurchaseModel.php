<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'purchases';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = ["provider", "date", "receipt", "reference", "tax", "coin", "updated_at", "deleted_at", "created_at"];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	public function createPurchase($purchase, $purchaseDetails)
	{

		$db = \Config\Database::connect();
		$db->transStart();
		
		$db->table('purchases')->insert($purchase);
		
		//Obtener ID de la compra
		$purchaseId = $db->insertID();

		//Insertar el ID al arreglo
		for($i = 0; $i < count($purchaseDetails); $i++){
			$purchaseDetails[$i]['purchase'] = $purchaseId;
		}

		$db->table('purchase_details')->insertBatch($purchaseDetails);

		$db->transComplete();

		if ($db->transStatus() === false) {
			return false;
		}

		return $purchaseId;
	}

	public function getPurchases()
	{
		$query = $this
			->select('purchases.id, providers.name, date, reference')
			->join('providers', 'providers.id = purchases.provider')
			->where('purchases.deleted_at', NULL);
		return $query;
	}

	public function getPurchaseById($data)
	{
		$query = $this
				->select('purchases.id as purchaseId, date, purchases.provider, providers.name as providerName, receipt, reference, purchases.tax, purchases.coin, purchases.updated_at, purchases.created_at, purchase_details.id as purchaseDetailsId, purchase_details.product, quantity, purchase_details.price, products.code, products.name')
				->join('purchase_details', 'purchase_details.purchase = purchases.id')
				->join('products', 'products.id = purchase_details.product')
				->join('providers', 'providers.id = purchases.provider')
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
			->table('purchases')
			->where('id', $id)
			->set($purchase)
			->update();
		
		$db
			->table('purchase_details')
			->updateBatch($purchaseDetails, 'id');
		
		$db->transComplete();

		if ($db->transStatus() === false) {
			return false;
		}

		return true;
	}

	public function deletePurchase($id)
	{
		$query = $this
				->delete($id);
		return $query;
	}
}
