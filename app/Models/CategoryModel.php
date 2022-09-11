<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'categories';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = ["category", "updated_at", "deleted_at", "created_at"];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	public function createCategory($data)
	{
		$query = $this
			->insert($data);
		return $query;
	}

	public function getCategories()
	{
		$query = $this
			->select('id, category, created_at')
			->where('deleted_at', NULL);
		return $query;
	}

	public function getCategoryById($data)
	{
		$query = $this->where($data);
		return $query->get()->getResultArray();
	}

	public function getLastId()
	{
		return $this->insertID();
	}

	public function updateCategory($name, $id)
	{
		$query = $this
				->where('id', $id)
				->set(["category" => $name])
				->update();
		return $query;
		
	}
}
