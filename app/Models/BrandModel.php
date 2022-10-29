<?php

namespace App\Models;

use CodeIgniter\Model;

class BrandModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'marcas';
	protected $primaryKey           = 'identificacion';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = ["marca", "estado", "actualizado_en", "creado_en"];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'creado_en';
	protected $updatedField         = 'actualizado_en';

	public function createBrand($data)
	{
		if($this->save($data)){
			return true;
		}
		
		return false;
	}

	public function getBrands()
	{
		$query = $this
			->select('identificacion, marca, estado');
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

	public function updateBrand($name, $identification)
	{
		$query = $this
				->where('identificacion', $identification)
				->set(["marca" => $name])
				->update();
		return $query;	
	}

	public function deleteBrand($identification)
	{
		$query = $this
				->where('identificacion', $identification)
				->set('estado', 0)
				->update();
		return $query;
	}

	public function recoverBrand($identification)
	{
		$query = $this
				->where('identificacion', $identification)
				->set('estado', 1)
				->update();
		return $query;
	}
}
