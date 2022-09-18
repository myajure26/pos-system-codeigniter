<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'settings';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = ["code", "name", "value", "table_id", "updated_at"];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	public function createCoin($data)
	{
		$query = $this
			->insert($data);
		return $query;
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
