<?php

namespace App\Models;

use CodeIgniter\Model;

class ProviderModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'proveedores';
	protected $primaryKey           = 'codigo';
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = ["nombre", "identificacion", "direccion", "telefono", "estado", "actualizado_en", "creado_en"];

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
			->select('codigo, nombre, identificacion, estado');
		return $query;
	}

	public function getProviderById($data)
	{
		$query = $this->where($data);
		return $query->get()->getResultArray();
	}

	public function updateProvider($data, $code)
	{
		$query = $this
				->where('codigo', $code)
				->set($data)
				->update();
		return $query;	
	}

	public function deleteProvider($code)
	{
		$query = $this
				->where('codigo', $code)
				->set('estado', 0)
				->update();
		return $query;
	}

	public function recoverProvider($code)
	{
		$query = $this
				->where('codigo', $code)
				->set('estado', 1)
				->update();
		return $query;
	}
}
