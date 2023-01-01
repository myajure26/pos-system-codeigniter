<?php

namespace App\Models;

use CodeIgniter\Model;

class CoinModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'monedas';
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = ["identificacion", "moneda", "simbolo", "estado", "actualizado_en", "creado_en"];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'creado_en';
	protected $updatedField         = 'actualizado_en';

	public function createCoin($data)
	{
		if($this->save($data)){
			return true;
		}
		
		return false;
	}

	public function getCoins()
	{
		$query = $this
			->select('identificacion, moneda, simbolo, estado');
		return $query;
	}

	public function getCoinById($data)
	{
		$query = $this->where($data);
		return $query->get()->getResultArray();
	}
	

	public function updateCoin($data, $identification)
	{
		$query = $this
				->where('identificacion', $identification)
				->set($data)
				->update();
		return $query;	
	}

	public function deleteCoin($identification)
	{
		$query = $this
				->where('identificacion', $identification)
				->set('estado', 0)
				->update();
		return $query;
	}

	public function recoverCoin($identification)
	{
		$query = $this
				->where('identificacion', $identification)
				->set('estado', 1)
				->update();
		return $query;
	}
}
