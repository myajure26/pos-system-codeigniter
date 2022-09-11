<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'audits';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = ["user_id", "module", "action", "description"];

	public function createAudit($data)
	{
		$query = $this
				->insert($data);
		return $query;
	}

	public function getAudits()
	{
		$query = $this
			->select('audits.id, name, module, action, description, audits.created_at')
			->join('users', 'users.id = audits.user_id');
		return $query;
	}

}

