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
	public function getDetailedPurchases()
	{
        $db      	= \Config\Database::connect();
        
		$db = $db
            ->table('compras')
			->select('referencia, fecha, usuario, proveedor, tipo_documento.nombre as tipo_documento, productos.nombre, detalle_compra.producto, monedas.moneda, detalle_compra.cantidad, detalle_compra.precio ')
			->join('tipo_documento', 'tipo_documento.identificacion = compras.tipo_documento')
			->join('detalle_compra', 'detalle_compra.compra = compras.identificacion')
			->join('productos', 'productos.codigo = detalle_compra.producto')
			->join('monedas', 'monedas.identificacion = compras.moneda')
			->where('compras.estado', 1);
		return $db;
	}

	public function getDetailedSales()
	{
        $db      	= \Config\Database::connect();
        
		$db = $db
            ->table('ventas')
			->select('ventas.identificacion as idVenta, ventas.creado_en, usuario, cliente, tipo_documento.nombre as tipo_documento, productos.nombre, detalle_ventas.producto, monedas.moneda, impuestos.porcentaje, detalle_ventas.cantidad, detalle_ventas.precio ')
			->join('tipo_documento', 'tipo_documento.identificacion = ventas.tipo_documento')
			->join('detalle_ventas', 'detalle_ventas.venta = ventas.identificacion')
			->join('productos', 'productos.codigo = detalle_ventas.producto')
			->join('monedas', 'monedas.identificacion = ventas.moneda')
			->join('impuestos', 'impuestos.identificacion = ventas.impuesto')
			->where('ventas.estado', 1);
		return $db;
	}
}
