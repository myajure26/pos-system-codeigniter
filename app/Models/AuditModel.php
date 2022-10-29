<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'auditoria';
	protected $primaryKey           = 'identificacion';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = ["usuario", "modulo", "accion", "descripcion", "creado_en"];

	public function createAudit($data)
	{
		$query = $this
				->insert($data);
		return $query;
	}

	public function getAudits()
	{
		$query = $this
			->select('auditoria.identificacion, nombre, modulo, accion, descripcion, auditoria.creado_en')
			->join('usuarios', 'usuarios.identificacion = auditoria.usuario');
		return $query;
	}

}

