<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportModel extends Model
{
	public function getInventory()
	{
        $db      	= \Config\Database::connect();
        
		$db = $db
            ->table('productos')
			->select('codigo, nombre, marcas.marca, categorias.categoria, cant_producto')
			->join('marcas', 'marcas.identificacion = productos.marca')
			->join('categorias', 'categorias.identificacion = productos.categoria');
		return $db;
	}
}
