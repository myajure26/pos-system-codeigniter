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
	protected $allowedFields        = ["codigo", "nombre", "id_ancho_caucho", "id_alto_caucho", "marca", "categoria", "precio", "stock_maximo", "stock_minimo", "estado", "actualizado_en", "creado_en"];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'creado_en';
	protected $updatedField         = 'actualizado_en';

	public function createProduct($data)
	{
		$query = $this
				->select()
				->where('nombre', $data['nombre'])
				->where('id_ancho_caucho', $data['id_ancho_caucho'])
				->where('id_alto_caucho', $data['id_alto_caucho'])
				->where('marca', $data['marca'])
				->where('categoria', $data['categoria'])
				->get()->getResult();

		if( $query ){
			return false;
		}

		if($this->save($data)){
			return true;
		}
		
		return false;
	}

	public function verifyProduct($product)
	{
		$db = \Config\Database::connect();
		$db = $db
			->table('producto_proveedor')
			->select()
			->where('ci_rif_proveedor', $provider)
			->where('cod_producto', $product)
			->get()->getResult();
		return $db;
	}

	public function getProducts()
	{
		$query = $this
			->select('codigo, nombre, ancho_caucho.ancho_numero, alto_caucho.alto_numero, categorias.categoria, marcas.marca, precio, productos.estado')
			->join('ancho_caucho', 'ancho_caucho.id_ancho_caucho = productos.id_ancho_caucho')
			->join('alto_caucho', 'alto_caucho.id_alto_caucho = productos.id_alto_caucho')
			->join('marcas', 'marcas.identificacion = productos.marca')
			->join('categorias', 'categorias.identificacion = productos.categoria');
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

	public function getProductsAssign($id)
	{
		$db = \Config\Database::connect();
		$db = $db
			->table('producto_proveedor')
			->select('productos.codigo, productos.nombre, ancho_caucho.ancho_numero, alto_caucho.alto_numero, categorias.categoria, marcas.marca')
			->join('proveedores', 'proveedores.identificacion = producto_proveedor.ci_rif_proveedor')
			->join('productos', 'productos.codigo = producto_proveedor.cod_producto')
			->join('ancho_caucho', 'ancho_caucho.id_ancho_caucho = productos.id_ancho_caucho')
			->join('alto_caucho', 'alto_caucho.id_alto_caucho = productos.id_alto_caucho')
			->join('marcas', 'marcas.identificacion = productos.marca')
			->join('categorias', 'categorias.identificacion = productos.categoria')
			->where('productos.estado', 1)
			->where('producto_proveedor.ci_rif_proveedor', $id)
			->get()->getResult();
		return $db;
	}

	public function verifyProviderAssignInfo($provider, $product)
	{
		$db = \Config\Database::connect();
		$db = $db
			->table('producto_proveedor')
			->select()
			->where('ci_rif_proveedor', $provider)
			->where('cod_producto', $product)
			->get()->getResult();
		return $db;
	}

	public function setProviderAssignInfo($data)
	{
		$db = \Config\Database::connect();
		$db = $db
			->table('producto_proveedor')
			->insert($data);
		return $db;
	}

	public function deleteProviderAssignInfo($provider, $product)
	{
		$db = \Config\Database::connect();
		$db = $db
			->query('DELETE FROM producto_proveedor WHERE cod_producto = "' . $product . '" AND ci_rif_proveedor = "'.$provider.'"');
		return $db;
	}
}
