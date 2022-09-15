<?php

namespace App\Models;

use CodeIgniter\Model;

class TaxModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'taxes';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = ["tax", "percentage", "updated_at", "deleted_at", "created_at"];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	public function createTax($data)
	{
		$query = $this
			->insert($data);
		return $query;
	}

	public function getTaxes()
	{
		$query = $this
			->select('id, tax, percentage, created_at')
			->where('deleted_at', NULL);
		return $query;
	}

	public function getTaxById($data)
	{
		$query = $this->where($data);
		return $query->get()->getResultArray();
	}

	public function getLastId()
	{
		return $this->insertID();
	}

	public function updateTax($data, $id)
	{
		$query = $this
				->where('id', $id)
				->set($data)
				->update();
		return $query;	
	}

	public function deleteTax($id)
	{
		$query = $this
				->delete($id);
		return $query;
	}
}
