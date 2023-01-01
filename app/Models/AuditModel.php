<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'auditoria';
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = ["identificacion", "usuario", "modulo", "accion", "descripcion", "creado_en"];

	public function createAudit($data)
	{
		helper('generateCode');

		$data = [
			"identificacion" => generateCode('AU', 'auditoria', 'identificacion'),
			"usuario"		=> $data['usuario'],
			"modulo"		=> $data['modulo'],
			"accion"		=> $data['accion'],
			"descripcion"	=> $data['descripcion']
		];	
		
		$query = $this
				->save($data);
		
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

