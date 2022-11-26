<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportModel extends Model
{
	public function getInventory()
	{
        $db = \Config\Database::connect();
        
		$db = $db
            ->table('productos')
			->select('codigo, nombre, marcas.marca, categorias.categoria, cant_producto')
			->join('marcas', 'marcas.identificacion = productos.marca')
			->join('categorias', 'categorias.identificacion = productos.categoria');
		return $db;
	}
	public function getDetailedPurchases()
	{
        $db = \Config\Database::connect();
        
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

	public function getSalesPerCustomer()
	{
        $db = \Config\Database::connect();
		$db = $db
            ->table('ventas')
			->select('ventas.identificacion, ventas.creado_en as fecha, cliente, usuario, impuestos.porcentaje as impuesto, SUM(detalle_ventas.cantidad * detalle_ventas.precio) as subtotal')
			->join('detalle_ventas', 'detalle_ventas.venta = ventas.identificacion')
			->join('impuestos', 'impuestos.identificacion = ventas.impuesto')
			->where('ventas.estado', 1)
			->groupBy('ventas.identificacion');
		return $db;
	}

	public function getSalesPerProduct()
	{
        $db = \Config\Database::connect();
		$db = $db
            ->table('ventas')
			->select('ventas.identificacion, ventas.creado_en as fecha, detalle_ventas.producto as codigo, productos.nombre as producto, detalle_ventas.cantidad, detalle_ventas.precio, (detalle_ventas.cantidad*detalle_ventas.precio) as total')
			->join('detalle_ventas', 'detalle_ventas.venta = ventas.identificacion')
			->join('productos', 'productos.codigo = detalle_ventas.producto')
			->where('ventas.estado', 1)
			->orderBy('ventas.identificacion');
		return $db;
	}

	public function generalPurchase($from, $to)
	{
        $db = \Config\Database::connect();
		$where = "fecha BETWEEN '$from' AND '$to'";
		$db = $db
			->table('compras')
			->select('COUNT(*) as total, fecha')
			->where($where)
			->where('estado', 1)
			->groupBy('fecha')
			->get()->getResult();
		return $db;

		// ->select('SUM(detalle_compra.precio * detalle_compra.cantidad) as total, fecha')
	}

	public function generalProvidersPurchase($from, $to)
	{
        $db = \Config\Database::connect();
		$where = "fecha BETWEEN '$from' AND '$to'";
		$db = $db
			->table('compras')
			->select('COUNT(*) as total, proveedor')
			->where($where)
			->where('estado', 1)
			->groupBy('proveedor')
			->orderBy('total', 'DESC')
			->limit(10)
			->get()->getResult();
		return $db;
	}

	public function generalNegativeProvidersPurchase($from, $to)
	{
        $db = \Config\Database::connect();
		$where = "fecha BETWEEN '$from' AND '$to'";
		$db = $db
			->table('compras')
			->select('COUNT(*) as total, proveedor')
			->where($where)
			->where('estado', 1)
			->groupBy('proveedor')
			->orderBy('total', 'ASC')
			->limit(10)
			->get()->getResult();
		return $db;
	}

	public function generalSale($from, $to)
	{
        $db = \Config\Database::connect();
		$where = "creado_en BETWEEN '$from' AND '$to 23:59:59'";
		$db = $db
			->table('ventas')
			->select("COUNT(*) as total, DATE_FORMAT(creado_en, '%Y-%m-%d') as fecha")
			->where($where)
			->where('estado', 1)
			->groupBy('fecha')
			->get()->getResult();
		return $db;
	}

	public function generalProductsSale($from, $to)
	{
        $db = \Config\Database::connect();
		$where = "creado_en BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
		$db = $db
			->table('detalle_ventas')
			->select('producto, SUM(cantidad) as total')
			->join('ventas', 'ventas.identificacion = detalle_ventas.venta')
			->where($where)
			->where('estado', 1)
			->groupBy('producto')
			->orderBy('total', 'DESC')
			->limit(10)
			->get()->getResult();
		return $db;
	}

	public function generalNegativeProductsSale($from, $to)
	{
        $db = \Config\Database::connect();
		$where = "creado_en BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
		$db = $db
			->table('detalle_ventas')
			->select('producto, SUM(cantidad) as total')
			->join('ventas', 'ventas.identificacion = detalle_ventas.venta')
			->where($where)
			->where('estado', 1)
			->groupBy('producto')
			->orderBy('total', 'ASC')
			->limit(10)
			->get()->getResult();
		return $db;
	}

	/**
	 * GENERAR REPORTES EN EXCEL
	 */

	public function getPurchaseReportExcel($from, $to)
	{
        $db = \Config\Database::connect();
		$where = "fecha BETWEEN '$from' AND '$to'";
		$db = $db
            ->table('compras')
			->select('compras.identificacion, referencia, fecha, usuario, proveedor, tipo_documento.nombre as tipo_documento, monedas.moneda')
			->join('tipo_documento', 'tipo_documento.identificacion = compras.tipo_documento')
			->join('monedas', 'monedas.identificacion = compras.moneda')
			->where($where)
			->where('compras.estado', 1)
			->orderBy('fecha', 'ASC')
			->get()->getResult();
		return $db;
	}

	public function getPurchaseDetailReportExcel($id)
	{
        $db = \Config\Database::connect();
		$db = $db
            ->table('detalle_compra')
			->select('productos.codigo as codigo, productos.nombre as nombreProducto, detalle_compra.cantidad, detalle_compra.precio')
			->join('productos', 'productos.codigo = detalle_compra.producto')
			->where('compra', $id)
			->get()->getResult();
		return $db;
	}

	public function getSaleReportExcel($from, $to)
	{
        $db = \Config\Database::connect();
		$where = "ventas.creado_en BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
		$db = $db
            ->table('ventas')
			->select('ventas.identificacion, cliente, usuario, tipo_documento.nombre as tipo_documento, monedas.moneda, tasa, impuestos.porcentaje as impuesto, metodo_pago.nombre as metodo_pago, ventas.creado_en as fecha')
			->join('tipo_documento', 'tipo_documento.identificacion = ventas.tipo_documento')
			->join('monedas', 'monedas.identificacion = ventas.moneda')
			->join('impuestos', 'impuestos.identificacion = ventas.impuesto')
			->join('metodo_pago', 'metodo_pago.id_metodo_pago = ventas.id_metodo_pago')
			->where($where)
			->where('ventas.estado', 1)
			->orderBy('fecha', 'ASC')
			->get()->getResult();
		return $db;
	}

	public function getSaleDetailReportExcel($id)
	{
        $db = \Config\Database::connect();
		$db = $db
            ->table('detalle_ventas')
			->select('productos.codigo as codigo, productos.nombre as nombreProducto, detalle_ventas.cantidad, detalle_ventas.precio')
			->join('productos', 'productos.codigo = detalle_ventas.producto')
			->where('venta', $id)
			->get()->getResult();
		return $db;
	}
}
