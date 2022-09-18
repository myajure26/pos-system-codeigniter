<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'products';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = ["code", "name", "brand", "category", "coin", "price", "tax", "updated_at", "deleted_at", "created_at"];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	public function createProduct($data)
	{
		$query = $this
			->insert($data);
		return $query;
	}

	public function getProducts()
	{
		$query = $this
			->select('products.id, code, name, brands.brand, categories.category, coins.symbol, price, taxes.tax, products.created_at')
			->join('brands', 'brands.id = products.brand')
			->join('categories', 'categories.id = products.category')
			->join('coins', 'coins.id = products.coin')
			->join('taxes', 'taxes.id = products.tax')
			->where('products.deleted_at', NULL);
		return $query;
	}

	public function getProductById($data)
	{
		$query = $this->where($data);
		return $query->get()->getResultArray();
	}

	public function getLastId()
	{
		return $this->insertID();
	}

	public function updateProduct($data, $id)
	{
		$query = $this
				->where('id', $id)
				->set($data)
				->update();
		return $query;	
	}

	public function deleteProduct($id)
	{
		$query = $this
				->delete($id);
		return $query;
	}
}
