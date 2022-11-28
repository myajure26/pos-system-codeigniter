<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'usuarios';
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = ["identificacion","nombre", "clave", "privilegio", "foto", "ultima_sesion", "estado", "actualizado_en", "creado_en"];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'creado_en';
	protected $updatedField         = 'actualizado_en';

	public function signin($data)
	{
		$query = $this->where($data);
		return $query->get()->getResultArray();
	}

	public function createUser($data)
	{
		if($this->save($data)){
			return true;
		}
		
		return false;
	}

	public function getUsers()
	{
		$query = $this
			->select('usuarios.identificacion, usuarios.nombre, privilegios.nombre as privilegio, foto, usuarios.estado')
			->join('privilegios', 'privilegios.identificacion = usuarios.privilegio');
		return $query;
	}

	public function getUserById($data)
	{
		$query = $this->where($data);
		return $query->get()->getResultArray();
	}

	public function updateUser($data, $identification)
	{
		$query = $this
				->where('identificacion', $identification)
				->set($data)
				->update();
		return $query;
	}

	public function deleteUser($identification)
	{
		$query = $this
				->where('identificacion', $identification)
				->set('foto', NULL)
				->set('estado', 0)
				->update();
		return $query;
	}

	public function recoverUser($identification)
	{
		$query = $this
				->where('identificacion', $identification)
				->set('estado', 1)
				->update();
		return $query;
	}
}
