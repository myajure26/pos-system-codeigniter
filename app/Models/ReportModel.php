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
			->select('codigo, nombre, ancho_caucho.ancho_numero, alto_caucho.alto_numero, categorias.categoria, marcas.marca, cant_producto, stock_minimo, stock_maximo')
			->join('ancho_caucho', 'ancho_caucho.id_ancho_caucho = productos.id_ancho_caucho')
			->join('alto_caucho', 'alto_caucho.id_alto_caucho = productos.id_alto_caucho')
			->join('marcas', 'marcas.identificacion = productos.marca')
			->join('categorias', 'categorias.identificacion = productos.categoria');
		return $db;
	}
	public function getPurchasesPerProvider()
	{
        $db = \Config\Database::connect();
        
		$db = $db
            ->table('compras')
			->select('compras.identificacion, DATE_FORMAT(compras.creado_en, "%d-%m-%Y") as fecha, proveedores.nombre, proveedores.identificacion as idProveedor, proveedores.direccion, proveedores.telefono, usuario')
			->join('detalle_compra', 'detalle_compra.compra = compras.identificacion')
			->join('proveedores', 'proveedores.identificacion = compras.proveedor')
			->groupBy('compras.identificacion');
		return $db;
	}

	public function getBestProviders()
	{
        $db = \Config\Database::connect();
		$db = $db
            ->table('detalle_compra')
			->select('proveedores.identificacion, proveedores.nombre, proveedores.telefono, proveedores.direccion, SUM(detalle_compra.cantidad) as cantidad, SUM(detalle_compra.cantidad*detalle_compra.precio) as total')
			->join('compras', 'compras.identificacion = detalle_compra.compra')
			->join('proveedores', 'proveedores.identificacion = compras.proveedor')
			->groupBy('proveedores.identificacion')
			->orderBy('cantidad', 'DESC')
			->limit(10);
		return $db;
	}

	public function getSalesPerCustomer()
	{
        $db = \Config\Database::connect();
		$db = $db
            ->table('ventas')
			->select('ventas.identificacion, ventas.creado_en as fecha, clientes.nombre as cliente, clientes.identificacion as idCliente, clientes.telefono as tlfCliente, clientes.direccion as direcCliente, usuario, metodo_pago.nombre as metodo_pago, impuestos.porcentaje as impuesto')
			->join('detalle_ventas', 'detalle_ventas.venta = ventas.identificacion')
			->join('clientes', 'clientes.identificacion = ventas.cliente')
			->join('impuestos', 'impuestos.identificacion = ventas.impuesto')
			->join('metodo_pago', 'metodo_pago.id_metodo_pago = ventas.id_metodo_pago')
			->where('ventas.estado', 1)
			->groupBy('ventas.identificacion');
		return $db;
	}

	public function getSalesPerProduct()
	{
        $db = \Config\Database::connect();
		$db = $db
            ->table('ventas')
			->select('ventas.identificacion, ventas.creado_en as fecha, detalle_ventas.producto as codigo, productos.nombre as producto, ancho_caucho.ancho_numero, alto_caucho.alto_numero, marcas.marca, categorias.categoria, detalle_ventas.cantidad, detalle_ventas.precio, (detalle_ventas.cantidad*detalle_ventas.precio) as total')
			->join('detalle_ventas', 'detalle_ventas.venta = ventas.identificacion')
			->join('productos', 'productos.codigo = detalle_ventas.producto')
			->join('marcas', 'marcas.identificacion = productos.marca')
			->join('ancho_caucho', 'ancho_caucho.id_ancho_caucho = productos.id_ancho_caucho')
			->join('alto_caucho', 'alto_caucho.id_alto_caucho = productos.id_alto_caucho')
			->join('categorias', 'categorias.identificacion = productos.categoria')
			->where('ventas.estado', 1)
			->orderBy('ventas.identificacion');
		return $db;
	}

	public function getSalesPerPaymentMethod()
	{
        $db = \Config\Database::connect();
		$db = $db
            ->table('ventas')
			->select('ventas.identificacion, ventas.creado_en as fecha, usuario, clientes.identificacion as cliente, impuestos.porcentaje as impuesto, SUM(detalle_ventas.cantidad*detalle_ventas.precio) as total, tasa, metodo_pago.nombre as metodo_pago, monedas.identificacion as idMoneda, monedas.moneda as moneda')
			->join('detalle_ventas', 'detalle_ventas.venta = ventas.identificacion')
			->join('clientes', 'clientes.identificacion = ventas.cliente')
			->join('impuestos', 'impuestos.identificacion = ventas.impuesto')
			->join('metodo_pago', 'metodo_pago.id_metodo_pago = ventas.id_metodo_pago')
			->join('monedas', 'monedas.identificacion = ventas.moneda')
			->where('ventas.estado', 1)
			->orderBy('ventas.identificacion', 'DESC')
			->groupBy('ventas.identificacion');
		return $db;
	}

	public function getMostSelledProducts()
	{
        $db = \Config\Database::connect();
		$db = $db
            ->table('detalle_ventas')
			->select('productos.codigo, productos.nombre, ancho_caucho.ancho_numero, alto_caucho.alto_numero, categorias.categoria, marcas.marca, SUM(detalle_ventas.cantidad) as cantidad, SUM(detalle_ventas.cantidad*detalle_ventas.precio) as total')
			->join('productos', 'productos.codigo = detalle_ventas.producto')
			->join('categorias', 'categorias.identificacion = productos.categoria')
			->join('marcas', 'marcas.identificacion = productos.marca')
			->join('ventas', 'ventas.identificacion = detalle_ventas.venta')
			->join('ancho_caucho', 'ancho_caucho.id_ancho_caucho = productos.id_ancho_caucho')
			->join('alto_caucho', 'alto_caucho.id_alto_caucho = productos.id_alto_caucho')
			->where('ventas.estado', 1)
			->groupBy('productos.codigo')
			->orderBy('cantidad', 'DESC')
			->limit(10);
		return $db;
	}

	public function getLessSoldProducts()
	{
        $db = \Config\Database::connect();
		$db = $db
            ->table('detalle_ventas')
			->select('productos.codigo, productos.nombre, ancho_caucho.ancho_numero, alto_caucho.alto_numero, categorias.categoria, marcas.marca, SUM(detalle_ventas.cantidad) as cantidad, SUM(detalle_ventas.cantidad*detalle_ventas.precio) as total')
			->join('productos', 'productos.codigo = detalle_ventas.producto')
			->join('categorias', 'categorias.identificacion = productos.categoria')
			->join('marcas', 'marcas.identificacion = productos.marca')
			->join('ventas', 'ventas.identificacion = detalle_ventas.venta')
			->join('ancho_caucho', 'ancho_caucho.id_ancho_caucho = productos.id_ancho_caucho')
			->join('alto_caucho', 'alto_caucho.id_alto_caucho = productos.id_alto_caucho')
			->where('ventas.estado', 1)
			->groupBy('productos.codigo')
			->orderBy('cantidad', 'ASC')
			->limit(10);
		return $db;
	}

	public function getBestCustomers()
	{
        $db = \Config\Database::connect();
		$db = $db
            ->table('detalle_ventas')
			->select('clientes.identificacion, clientes.nombre, clientes.telefono, clientes.direccion, SUM(detalle_ventas.cantidad) as cantidad, SUM(detalle_ventas.cantidad*detalle_ventas.precio) as total')
			->join('ventas', 'ventas.identificacion = detalle_ventas.venta')
			->join('clientes', 'clientes.identificacion = ventas.cliente')
			->where('ventas.estado', 1)
			->groupBy('clientes.identificacion')
			->orderBy('total', 'DESC')
			->limit(10);
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
	 * * GENERAR REPORTES EN EXCEL
	 */

	public function getPurchaseReportExcel()
	{
        $db = \Config\Database::connect();
		$db = $db
            ->table('compras')
			->select('compras.identificacion as idCompra, DATE_FORMAT(compras.creado_en, "%d-%m-%Y") as fecha, usuario, proveedores.identificacion, proveedores.nombre, tipo_documento.nombre as tipo_documento, monedas.moneda')
			->join('tipo_documento', 'tipo_documento.identificacion = compras.tipo_documento')
			->join('monedas', 'monedas.identificacion = compras.moneda')
			->join('proveedores', 'proveedores.identificacion = compras.proveedor')
			->orderBy('fecha', 'ASC');
		return $db;
	}

	public function getPurchaseDetailReportExcel($id)
	{
        $db = \Config\Database::connect();
		$db = $db
            ->table('detalle_compra')
			->select('productos.codigo as codigo, productos.nombre as nombreProducto, ancho_caucho.ancho_numero, alto_caucho.alto_numero, categorias.categoria, marcas.marca, detalle_compra.cantidad, detalle_compra.precio')
			->join('productos', 'productos.codigo = detalle_compra.producto')
			->join('ancho_caucho', 'ancho_caucho.id_ancho_caucho = productos.id_ancho_caucho')
			->join('alto_caucho', 'alto_caucho.id_alto_caucho = productos.id_alto_caucho')
			->join('marcas', 'marcas.identificacion = productos.marca')
			->join('categorias', 'categorias.identificacion = productos.categoria')
			->where('compra', $id)
			->get()->getResult();
		return $db;
	}

	public function getOrderReportExcel()
	{
        $db = \Config\Database::connect();
		$db = $db
            ->table('pedido')
			->select('pedido.id_pedido, DATE_FORMAT(pedido.creado_en, "%d-%m-%Y") as fecha, ci_usuario, proveedores.identificacion, proveedores.nombre, monedas.moneda, estado_pedido')
			->join('tipo_documento', 'tipo_documento.identificacion = pedido.id_tipo_documento')
			->join('monedas', 'monedas.identificacion = pedido.id_moneda')
			->join('proveedores', 'proveedores.identificacion = pedido.ci_rif_proveedor')
			->orderBy('fecha', 'ASC')
			->orderBy('id_pedido', 'ASC');
		return $db;
	}

	public function getOrderDetailReportExcel($id)
	{
        $db = \Config\Database::connect();
		$db = $db
            ->table('detalle_pedido')
			->select('productos.codigo as codigo, productos.nombre as nombreProducto, ancho_caucho.ancho_numero, alto_caucho.alto_numero, categorias.categoria, marcas.marca, detalle_pedido.cant_producto as cantidad, detalle_pedido.precio_producto as precio')
			->join('productos', 'productos.codigo = detalle_pedido.cod_producto')
			->join('ancho_caucho', 'ancho_caucho.id_ancho_caucho = productos.id_ancho_caucho')
			->join('alto_caucho', 'alto_caucho.id_alto_caucho = productos.id_alto_caucho')
			->join('marcas', 'marcas.identificacion = productos.marca')
			->join('categorias', 'categorias.identificacion = productos.categoria')
			->where('id_pedido', $id)
			->get()->getResult();
		return $db;
	}

	public function getSaleReportExcel()
	{
        $db = \Config\Database::connect();
		$db = $db
            ->table('ventas')
			->select('ventas.identificacion, clientes.identificacion as cliente, clientes.nombre, usuario, tipo_documento.nombre as tipo_documento, monedas.moneda, tasa, impuestos.porcentaje as impuesto, metodo_pago.nombre as metodo_pago, ventas.creado_en as fecha')
			->join('tipo_documento', 'tipo_documento.identificacion = ventas.tipo_documento')
			->join('clientes', 'clientes.identificacion = ventas.cliente')
			->join('monedas', 'monedas.identificacion = ventas.moneda')
			->join('impuestos', 'impuestos.identificacion = ventas.impuesto')
			->join('metodo_pago', 'metodo_pago.id_metodo_pago = ventas.id_metodo_pago')
			->where('ventas.estado', 1)
			->orderBy('fecha', 'ASC');
		return $db;
	}

	public function getSaleDetailReportExcel($id)
	{
        $db = \Config\Database::connect();
		$db = $db
            ->table('detalle_ventas')
			->select('productos.codigo as codigo, productos.nombre as nombreProducto, ancho_caucho.ancho_numero, alto_caucho.alto_numero, categorias.categoria, marcas.marca, detalle_ventas.cantidad, detalle_ventas.precio')
			->join('productos', 'productos.codigo = detalle_ventas.producto')
			->join('ancho_caucho', 'ancho_caucho.id_ancho_caucho = productos.id_ancho_caucho')
			->join('alto_caucho', 'alto_caucho.id_alto_caucho = productos.id_alto_caucho')
			->join('marcas', 'marcas.identificacion = productos.marca')
			->join('categorias', 'categorias.identificacion = productos.categoria')
			->where('venta', $id)
			->get()->getResult();
		return $db;
	}
}
