<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'customers';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = ["name", "identification", "address", "phone", "updated_at", "deleted_at", "created_at"];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	public function createCustomer($data)
	{
		$query = $this
			->insert($data);
		return $query;
	}

	public function getCustomers()
	{
		$query = $this
			->select('id, name, identification, phone')
			->where('deleted_at', NULL);
		return $query;
	}

	public function getCustomerById($data)
	{
		$query = $this->where($data);
		return $query->get()->getResultArray();
	}

	public function getLastId()
	{
		return $this->insertID();
	}

	public function updateCustomer($data, $id)
	{
		$query = $this
				->where('id', $id)
				->set($data)
				->update();
		return $query;	
	}

	public function deleteCustomer($id)
	{
		$query = $this
				->delete($id);
		return $query;
	}
}
