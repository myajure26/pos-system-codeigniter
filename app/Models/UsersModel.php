<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'users';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = ["ci","name", "email", "password", "privilege", "photo", "last_session", "created_at"];

	// Dates
	// protected $useTimestamps        = false;
	// protected $dateFormat           = 'datetime';
	// protected $createdField         = 'created_at';
	// protected $updatedField         = 'updated_at';
	// protected $deletedField         = 'deleted_at';

	// // Validation
	// protected $validationRules      = [];
	// protected $validationMessages   = [];
	// protected $skipValidation       = false;
	// protected $cleanValidationRules = true;

	// // Callbacks
	// protected $allowCallbacks       = true;
	// protected $beforeInsert         = [];
	// protected $afterInsert          = [];
	// protected $beforeUpdate         = [];
	// protected $afterUpdate          = [];
	// protected $beforeFind           = [];
	// protected $afterFind            = [];
	// protected $beforeDelete         = [];
	// protected $afterDelete          = [];

	public function signin($data)
	{
		$query = $this->where($data);
		return $query->get()->getResultArray();
	}

	public function getUsers()
	{
		$query = $this
			->select('id, ci, name, email, photo, privilege, last_session')
			->where('deleted_at', NULL);
		return $query;
	}

	public function createUser($data)
	{
		$query = $this
			->insert($data);
		return $query;
	}
}
