<?php

namespace App\Models;

use CodeIgniter\Model;

class HighRubberModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'alto_caucho';
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = ["id_alto_caucho", "alto_numero", "estado_alto_caucho", "actualizado_en", "creado_en"];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'creado_en';
	protected $updatedField         = 'actualizado_en';

	public function createHighRubber($data)
	{
		if($this->save($data)){
			return true;
		}
		
		return false;
	}

	public function getHighRubbers()
	{
		$query = $this
			->select('id_alto_caucho, alto_numero, estado_alto_caucho');
		return $query;
	}

	public function getHighRubberById($data)
	{
		$query = $this->where($data);
		return $query->get()->getResultArray();
	}

	

	public function updateHighRubber($value, $identification)
	{
		$query = $this
				->where('id_alto_caucho', $identification)
				->set(["alto_numero" => $value])
				->update();
		return $query;	
	}

	public function deleteHighRubber($identification)
	{
		$query = $this
				->where('id_alto_caucho', $identification)
				->set('estado_alto_caucho', 0)
				->update();
		return $query;
	}

	public function recoverHighRubber($identification)
	{
		$query = $this
				->where('id_alto_caucho', $identification)
				->set('estado_alto_caucho', 1)
				->update();
		return $query;
	}
}
