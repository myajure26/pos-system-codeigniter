<?php

namespace App\Models;

use CodeIgniter\Model;

class PrivilegeModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'privilegios';
	protected $primaryKey           = 'identificacion';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = ["nombre", "permisos", "estado", "actualizado_en", "creado_en"];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'creado_en';
	protected $updatedField         = 'actualizado_en';

	public function createPrivilege($data)
	{
		if($this->save($data)){
			return true;
		}
		
		return false;
	}

	public function getPrivileges()
	{
		$query = $this
			->select('identificacion, nombre, permisos, estado');
		return $query;
	}

	public function getPrivilegeById($data)
	{
		$query = $this->where($data);
		return $query->get()->getResultArray();
	}

	public function getLastId()
	{
		return $this->insertID();
	}

	public function updatePrivilege($data, $identification)
	{
		$query = $this
				->where('identificacion', $identification)
				->set($data)
				->update();
		return $query;	
	}

	public function deletePrivilege($identification)
	{
		$query = $this
				->where('identificacion', $identification)
				->set('estado', 0)
				->update();
		return $query;
	}

	public function recoverPrivilege($identification)
	{
		$query = $this
				->where('identificacion', $identification)
				->set('estado', 1)
				->update();
		return $query;
	}
}
