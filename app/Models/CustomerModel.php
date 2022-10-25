<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'clientes';
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = ["identificacion", "nombre", "direccion", "telefono", "estado", "actualizado_en", "creado_en"];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'actualizado_en';
	protected $updatedField         = 'creado_en';

	public function createCustomer($data)
	{
		if($this->save($data)){
			return true;
		}
		
		return false;
	}

	public function getCustomers()
	{
		$query = $this
			->select('identificacion, nombre, telefono, estado');
		return $query;
	}

	public function getCustomerById($data)
	{
		$query = $this->where($data);
		return $query->get()->getResultArray();
	}

	public function updateCustomer($data, $identification)
	{
		$query = $this
				->where('identificacion', $identification)
				->set($data)
				->update();
		return $query;	
	}

	public function deleteCustomer($identification)
	{
		$query = $this
				->where('identificacion', $identification)
				->set('estado', 0)
				->update();
		return $query;
	}
	
	public function recoverCustomer($identification)
	{
		$query = $this
				->where('identificacion', $identification)
				->set('estado', 1)
				->update();
		return $query;
	}
}
