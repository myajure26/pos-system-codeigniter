<?php

namespace App\Models;

use CodeIgniter\Model;

class BrandModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'brands';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = ["brand", "updated_at", "deleted_at", "created_at"];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	public function createBrand($data)
	{
		$query = $this
			->insert($data);
		return $query;
	}

	public function getBrands()
	{
		$query = $this
			->select('id, brand, created_at')
			->where('deleted_at', NULL);
		return $query;
	}

	public function getBrandById($data)
	{
		$query = $this->where($data);
		return $query->get()->getResultArray();
	}

	public function getLastId()
	{
		return $this->insertID();
	}

	public function updateBrand($name, $id)
	{
		$query = $this
				->where('id', $id)
				->set(["brand" => $name])
				->update();
		return $query;	
	}

	public function deleteBrand($id)
	{
		$query = $this
				->delete($id);
		return $query;
	}
}
