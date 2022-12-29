<?php

namespace App\Models;

use CodeIgniter\Model;

class WideRubberModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'ancho_caucho';
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = ["id_ancho_caucho", "ancho_numero", "estado_ancho_caucho", "actualizado_en", "creado_en"];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'creado_en';
	protected $updatedField         = 'actualizado_en';

	public function createWideRubber($data)
	{
		if($this->save($data)){
			return true;
		}
		
		return false;
	}

	public function getWideRubbers()
	{
		$query = $this
			->select('id_ancho_caucho, ancho_numero, estado_ancho_caucho');
		return $query;
	}

	public function getWideRubberById($data)
	{
		$query = $this->where($data);
		return $query->get()->getResultArray();
	}

	public function getLastId()
	{
		return $this->insertID();
	}

	public function updateWideRubber($value, $identification)
	{
		$query = $this
				->where('id_ancho_caucho', $identification)
				->set(["ancho_numero" => $value])
				->update();
		return $query;	
	}

	public function deleteWideRubber($identification)
	{
		$query = $this
				->where('id_ancho_caucho', $identification)
				->set('estado_ancho_caucho', 0)
				->update();
		return $query;
	}

	public function recoverWideRubber($identification)
	{
		$query = $this
				->where('id_ancho_caucho', $identification)
				->set('estado_ancho_caucho', 1)
				->update();
		return $query;
	}
}
