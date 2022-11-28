<?php

namespace App\Models;

use CodeIgniter\Model;

class ProviderModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'proveedores';
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = ["identificacion", "nombre", "direccion", "telefono", "estado", "actualizado_en", "creado_en"];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'creado_en';
	protected $updatedField         = 'actualizado_en';

	public function createProvider($data)
	{
		if($this->save($data)){
			return true;
		}

		return false;
	}

	public function getProviders()
	{
		$query = $this
			->select('identificacion, nombre, telefono, direccion, estado');
		return $query;
	}

	public function getProviderById($data)
	{
		$query = $this->where($data);
		return $query->get()->getResultArray();
	}

	public function updateProvider($data, $identification)
	{
		$query = $this
				->where('identificacion', $identification)
				->set($data)
				->update();
		return $query;	
	}

	public function deleteProvider($identification)
	{
		$query = $this
				->where('identificacion', $identification)
				->set('estado', 0)
				->update();
		return $query;
	}

	public function recoverProvider($identification)
	{
		$query = $this
				->where('identificacion', $identification)
				->set('estado', 1)
				->update();
		return $query;
	}
}
