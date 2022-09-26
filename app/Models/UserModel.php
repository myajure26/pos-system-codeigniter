<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'users';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = ["ci","name", "email", "password", "privilege", "photo", "updated_at", "deleted_at", "created_at","last_session"];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	public function signin($data)
	{
		$query = $this->where($data);
		return $query->get()->getResultArray();
	}

	public function createUser($data)
	{
		$query = $this
			->insert($data);
		return $query;
	}

	public function getUsers()
	{
		$query = $this
			->select('id, ci, name, privilege, photo')
			->where('deleted_at', NULL);
		return $query;
	}

	public function getUserById($data)
	{
		$query = $this->where($data);
		return $query->get()->getResultArray();
	}

	public function getLastId()
	{
		return $this->insertID();
	}

	public function updateUser($data, $id)
	{
		$query = $this
				->where('id', $id)
				->set($data)
				->update();
		return $query;
	}

	public function deleteUser($id)
	{
		$query = $this
				->delete($id);
		return $query;
	}
}
