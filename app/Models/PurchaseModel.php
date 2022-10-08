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
		$this->transStart();
		$this->insert($purchase);
		$purchaseId = $this->insertID();
		
		//Insertar el ID al arreglo
		for($i = 0; $i < count($purchaseDetails); $i++){
			$purchaseDetails[$i]['purchase'] = $purchaseId;
		}

		$purchaseDetailsDB = \Config\Database::connect();
		$purchaseDetailsDB
			->table('purchase_details')
			->insertBatch($purchaseDetails);

		$this->transComplete();

		if ($this->transStatus() === false) {
			return false;
		}

		return true;
	}

	public function getProviders()
	{
		$query = $this
			->select('id, code, name, rif')
			->where('deleted_at', NULL);
		return $query;
	}

	public function getProviderById($data)
	{
		$query = $this->where($data);
		return $query->get()->getResultArray();
	}

	public function getLastId()
	{
		return $this->insertID();
	}

	public function updateProvider($data, $id)
	{
		$query = $this
				->where('id', $id)
				->set($data)
				->update();
		return $query;	
	}

	public function deleteProvider($id)
	{
		$query = $this
				->delete($id);
		return $query;
	}
}
