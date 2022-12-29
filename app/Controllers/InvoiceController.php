<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Dompdf\Dompdf;
use Dompdf\Options;

class InvoiceController extends BaseController
{
    public function saleInvoice($id)
    {

        if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

        // TODO:: Arreglar para trabajar con más monedas

        $db     = \Config\Database::connect();
		$venta 	= $db
				->table('ventas')
				->select('ventas.identificacion as idVenta, clientes.identificacion as clienteId, clientes.nombre as clienteNom, clientes.direccion, tasa, impuestos.impuesto, impuestos.porcentaje, monedas.identificacion as idMoneda, monedas.moneda, monedas.simbolo, ventas.actualizado_en, ventas.creado_en, productos.nombre as producto, cantidad, detalle_ventas.precio, productos.codigo, alto_caucho.alto_numero, ancho_caucho.ancho_numero, categorias.categoria, marcas.marca, usuarios.nombre as vendedor, ventas.estado')
				->join('detalle_ventas', 'detalle_ventas.venta = ventas.identificacion')
				->join('productos', 'productos.codigo = detalle_ventas.producto')
				->join('clientes', 'clientes.identificacion = ventas.cliente')
				->join('usuarios', 'usuarios.identificacion = ventas.usuario')
                ->join('ancho_caucho', 'ancho_caucho.id_ancho_caucho = productos.id_ancho_caucho')
			    ->join('alto_caucho', 'alto_caucho.id_alto_caucho = productos.id_alto_caucho')
                ->join('marcas', 'marcas.identificacion = productos.marca')
			    ->join('categorias', 'categorias.identificacion = productos.categoria')
				->join('impuestos', 'impuestos.identificacion = ventas.impuesto')
				->join('monedas', 'monedas.identificacion = ventas.moneda')
				->where('ventas.identificacion', $id)
                ->get()->getResult();
        
        $coin = $db
                ->table('monedas')
                ->select('moneda')
                ->where('identificacion', $this->nationalCoin)
                ->get()
                ->getResult();

        $data = [
            "id"    => $id,
            "venta" => $venta,
            "coin"  => $coin[0],
            "businessName" 			=> $this->businessName,
            "businessIdentification"=> $this->businessIdentification,
            "businessAddress" 		=> $this->businessAddress,
            "businessPhone" 		=> $this->businessPhone,
            "nationalCoinSymbol"    => $this->nationalCoinSymbol,
            "nationalCoin"          => $this->nationalCoin,
            "symbol"                => $this->symbol,
        ];

        // return view('app/invoices/saleInvoice', $data);

        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $html = view('app/invoices/saleInvoice', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter');
        $dompdf->render();
        $dompdf->stream();

    }

    public function orderInvoice($id)
    {

        if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

        $db     = \Config\Database::connect();
		$order = $db
                ->table('pedido')
				->select('pedido.id_pedido, ci_rif_proveedor, proveedores.nombre as proveedor_nombre, proveedores.direccion, monedas.moneda, monedas.simbolo, pedido.creado_en, detalle_pedido.cod_producto, ancho_caucho.ancho_numero, alto_caucho.alto_numero, categorias.categoria, marcas.marca, detalle_pedido.cant_producto, detalle_pedido.precio_producto, productos.nombre, usuarios.nombre as usuario, pedido.estado_pedido')
				->join('detalle_pedido', 'detalle_pedido.id_pedido = pedido.id_pedido')
				->join('productos', 'productos.codigo = detalle_pedido.cod_producto')
				->join('ancho_caucho', 'ancho_caucho.id_ancho_caucho = productos.id_ancho_caucho')
				->join('alto_caucho', 'alto_caucho.id_alto_caucho = productos.id_alto_caucho')
				->join('marcas', 'marcas.identificacion = productos.marca')
				->join('categorias', 'categorias.identificacion = productos.categoria')
				->join('monedas', 'monedas.identificacion = pedido.id_moneda')
				->join('proveedores', 'proveedores.identificacion = pedido.ci_rif_proveedor')
				->join('usuarios', 'usuarios.identificacion = pedido.ci_usuario')
                ->where('pedido.id_pedido', $id)
		        ->get()->getResult();

        $data = [
            "id"    => $id,
            "order" => $order,
            "businessName" 			=> $this->businessName,
            "businessIdentification"=> $this->businessIdentification,
            "businessAddress" 		=> $this->businessAddress,
            "businessPhone" 		=> $this->businessPhone
        ];

        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $html = view('app/invoices/orderInvoice', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter');
        $dompdf->render();
        $dompdf->stream();

    }

    public function purchaseInvoice($id)
    {

        if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

        $db     = \Config\Database::connect();
		$purchase = $db
                ->table('compras')
				->select('compras.identificacion, proveedores.identificacion as ci_rif_proveedor, proveedores.nombre as proveedor_nombre, proveedores.direccion, monedas.moneda, monedas.simbolo, compras.actualizado_en, compras.creado_en, detalle_compra.producto as cod_producto, ancho_caucho.ancho_numero, alto_caucho.alto_numero, categorias.categoria, marcas.marca, detalle_compra.cantidad as cant_producto, detalle_compra.precio as precio_producto, productos.nombre, usuarios.nombre as usuario')
				->join('detalle_compra', 'detalle_compra.compra = compras.identificacion')
				->join('productos', 'productos.codigo = detalle_compra.producto')
				->join('ancho_caucho', 'ancho_caucho.id_ancho_caucho = productos.id_ancho_caucho')
				->join('alto_caucho', 'alto_caucho.id_alto_caucho = productos.id_alto_caucho')
				->join('marcas', 'marcas.identificacion = productos.marca')
				->join('categorias', 'categorias.identificacion = productos.categoria')
				->join('monedas', 'monedas.identificacion = compras.moneda')
				->join('proveedores', 'proveedores.identificacion = compras.proveedor')
				->join('usuarios', 'usuarios.identificacion = compras.usuario')
                ->where('compras.identificacion', $id)
		        ->get()->getResult();

        $data = [
            "id"    => $id,
            "purchase" => $purchase,
            "businessName" 			=> $this->businessName,
            "businessIdentification"=> $this->businessIdentification,
            "businessAddress" 		=> $this->businessAddress,
            "businessPhone" 		=> $this->businessPhone
        ];

        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $html = view('app/invoices/purchaseInvoice', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter');
        $dompdf->render();
        $dompdf->stream();

    }
}
