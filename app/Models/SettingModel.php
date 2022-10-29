<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
	public function createCoinPrice($data)
	{
		$db = \Config\Database::connect();
	
		$db
			->table('coin_prices')
			->insert($data);

		return $db;
	}

	public function getCoins()
	{
		$query = $this
			->select('id, coin, symbol, created_at')
			->where('deleted_at', NULL);
		return $query;
	}

	public function getCoinById($data)
	{
		$query = $this->where($data);
		return $query->get()->getResultArray();
	}

	public function getLastId()
	{
		return $this->insertID();
	}

	public function updateSetting($data, $name)
	{
		$query = $this
				->where('name', $name)
				->set($data)
				->update();
		return $query;	
	}

	public function deleteCoin($id)
	{
		$query = $this
				->delete($id);
		return $query;
	}
}
