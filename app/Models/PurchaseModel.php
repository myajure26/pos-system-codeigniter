<?php

namespace App\Models;

use CodeIgniter\Model;

class ProviderModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'purchases';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = ["code", "name", "rif", "address", "phone", "phone2", "type", "updated_at", "deleted_at", "created_at"];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	public function createProvider($data)
	{
		$query = $this
			->insert($data);
		return $query;
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
