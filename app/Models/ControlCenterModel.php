<?php

namespace App\Models;

use CodeIgniter\Model;

class ControlCenterModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'precio_monedas';
	protected $primaryKey           = 'identificacion';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = ["moneda_principal", "moneda_secundaria", "precio", "estado", "actualizado_en", "creado_en"];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'creado_en';
	protected $updatedField         = 'actualizado_en';

	public function createCoinPrice($data)
	{
		return $this
			->table('precio_monedas')
			->insert($data);

	}

	public function getCoinPrices()
	{
		$query = $this
			->select('precio_monedas.identificacion, a.moneda as moneda_principal, b.moneda as moneda_secundaria, precio, precio_monedas.estado, precio_monedas.creado_en')
			->join('monedas a', 'a.identificacion = precio_monedas.moneda_principal')
			->join('monedas b', 'b.identificacion = precio_monedas.moneda_secundaria');
		return $query;
	}

	public function getCoinPriceById($data)
	{
		$query = $this->where($data);
		return $query->get()->getResultArray();
	}

	public function getLastId()
	{
		return $this->insertID();
	}

	public function updateCoinPrice($data, $identification)
	{
		$query = $this
				->where('identificacion', $identification)
				->set($data)
				->update();
		return $query;	
	}

	public function deleteCoinPrice($identification)
	{
		$query = $this
				->where('identificacion', $identification)
				->set('estado', 0)
				->update();
		return $query;
	}

	public function recoverCoinPrice($identification)
	{
		$query = $this
				->where('identificacion', $identification)
				->set('estado', 1)
				->update();
		return $query;
	}
}
