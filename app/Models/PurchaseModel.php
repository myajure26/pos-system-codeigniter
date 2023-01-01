<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'compras';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = ["identificacion", "proveedor", "usuario", "tipo_documento", "moneda", "actualizado_en", "creado_en"];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'creado_en';
	protected $updatedField         = 'actualizado_en';


	public function getPurchases()
	{
		$query = $this
			->select('compras.identificacion, proveedor, DATE_FORMAT(compras.creado_en, "%d-%m-%Y"), monedas.simbolo')
			->join('monedas', 'monedas.identificacion = compras.moneda');
		return $query;
	}

	

}
