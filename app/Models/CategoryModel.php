<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'categorias';
	protected $primaryKey           = 'identificacion';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = ["categoria", "estado", "actualizado_en", "creado_en"];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'creado_en';
	protected $updatedField         = 'actualizado_en';
	protected $deletedField         = 'deleted_at';

	public function createCategory($data)
	{
		if($this->save($data)){
			return true;
		}
		
		return false;
	}

	public function getCategories()
	{
		$query = $this
			->select('identificacion, categoria, estado');
		return $query;
	}

	public function getCategoryById($data)
	{
		$query = $this->where($data);
		return $query->get()->getResultArray();
	}

	public function getLastId()
	{
		return $this->insertID();
	}

	public function updateCategory($name, $identification)
	{
		$query = $this
				->where('identificacion', $identification)
				->set(["categoria" => $name])
				->update();
		return $query;	
	}

	public function deleteCategory($identification)
	{
		$query = $this
				->where('identificacion', $identification)
				->set('estado', 0)
				->update();
		return $query;
	}

	public function recoverCategory($identification)
	{
		$query = $this
				->where('identificacion', $identification)
				->set('estado', 1)
				->update();
		return $query;
	}
}
