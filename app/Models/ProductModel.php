<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'productos';
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = ["codigo", "nombre", "marca", "categoria", "moneda", "precio", "impuesto", "estado", "actualizado_en", "creado_en"];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'creado_en';
	protected $updatedField         = 'actualizado_en';

	public function createProduct($data)
	{
		if($this->save($data)){
			return true;
		}
		
		return false;
	}

	public function getProducts()
	{
		$query = $this
			->select('codigo, nombre, marcas.marca, categorias.categoria, monedas.simbolo, precio, impuestos.impuesto, productos.estado')
			->join('marcas', 'marcas.identificacion = productos.marca')
			->join('categorias', 'categorias.identificacion = productos.categoria')
			->join('monedas', 'monedas.identificacion = productos.moneda')
			->join('impuestos', 'impuestos.identificacion = productos.impuesto');
		return $query;
	}

	public function getProductById($data)
	{
		$query = $this->where($data);
		return $query->get()->getResultArray();
	}

	public function updateProduct($data, $code)
	{
		$query = $this
				->where('codigo', $code)
				->set($data)
				->update();
		return $query;
	}

	public function deleteProduct($code)
	{
		$query = $this
				->where('codigo', $code)
				->set('estado', 0)
				->update();
		return $query;
	}

	public function recoverProduct($code)
	{
		$query = $this
				->where('codigo', $code)
				->set('estado', 1)
				->update();
		return $query;
	}
}
