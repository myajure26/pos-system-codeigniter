<?php 
namespace App\Controllers;
use App\Models\ReportModel;
use App\Models\AuditModel;
use \Hermawan\DataTables\DataTable;

class ReportController extends BaseController
{
	protected $errorMessage = [
		"alert" => "simple",
		"type" => "error",
		"title" => "Alerta",
		"text" => ""
	];

	protected $successMessage = [
		"alert" => "simple",
		"type" => "success",
		"title" => "¡Éxito!",
		"text" => ""
	];

	protected $auditContent = [
		"usuario"		=> "",
		"modulo"		=> "Reportes",
		"accion"		=> "",
		"descripcion"	=> ""
	];


	public function getInventory()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ReportModel = new ReportModel();
				
		return DataTable::of($ReportModel->getInventory())
			->hide('ancho_numero')
			->hide('alto_numero')
			->edit('nombre', function($row){
				return "$row->nombre $row->ancho_numero/$row->alto_numero";
			})
			->edit('stock_minimo', function($row){
				return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-danger text-dark p-2 px-3">'.$row->stock_minimo.'</a></div>';
			})
			->edit('stock_maximo', function($row){
				return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-warning text-dark p-2 px-3">'.$row->stock_maximo.'</a></div>';
			})
			->edit('cant_producto', function($row){
							
				if($row->cant_producto <= $row->stock_minimo){
					return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-danger text-dark p-2 px-3">'.$row->cant_producto.'</a></div>';
				}
				
				if($row->cant_producto <= ($row->stock_minimo + 10)){
					return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-warning text-dark p-2 px-3">'.$row->cant_producto.'</a></div>';
				}

				return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-success text-dark p-2 px-3">'.$row->cant_producto.'</a></div>';
			})
			->filter(function ($builder, $request) {
		

				if($request->wideFilter != ''){
					$builder->where('productos.id_ancho_caucho', $request->wideFilter);
				}
				
				if($request->highFilter != ''){
					$builder->where('productos.id_alto_caucho', $request->highFilter);
				}
				
				if($request->categoryFilter != ''){
					$builder->where('productos.categoria', $request->categoryFilter);
				}
				
				if($request->brandFilter != ''){
					$builder->where('productos.marca', $request->brandFilter);
				}
		
			})
			->toJson();
	}

	public function getPurchasesPerProvider()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ReportModel = new ReportModel();
				
		return DataTable::of($ReportModel->getPurchasesPerProvider())
			->hide('nombre')
			->hide('direccion')
			->hide('telefono')
			->hide('idProveedor')
			->add('productos', function($row){
				$products = '';

				$ReportModel = new ReportModel();
				$detail = $ReportModel->getPurchaseDetailReportExcel($row->identificacion);

				foreach($detail as $item){
					$products = $products . "$item->nombreProducto $item->ancho_numero/$item->alto_numero $item->categoria Marca $item->marca<br>";
				}

				return $products;

			})
			->add('cantidad', function($row){
				$quantity = '';

				$ReportModel = new ReportModel();
				$detail = $ReportModel->getPurchaseDetailReportExcel($row->identificacion);

				foreach($detail as $item){
					$quantity = $quantity . "$item->cantidad <br>";
				}

				return $quantity;
			})
			->add('precio', function($row){
				$price = '';

				$ReportModel = new ReportModel();
				$detail = $ReportModel->getPurchaseDetailReportExcel($row->identificacion);

				foreach($detail as $item){
					$price = $price . number_format($item->precio, 2) . "<br>";
				}

				return $price;
			})
			->add('total', function($row){
				$total = 0;

				$ReportModel = new ReportModel();
				$detail = $ReportModel->getPurchaseDetailReportExcel($row->identificacion);

				foreach($detail as $item){
					$total += $item->precio * $item->cantidad;
				}

				return number_format($total, 2);
			})
			->filter(function ($builder, $request) {
        
				if($request->range != ''){

					if(!empty(explode(' a ', $request->range)[1])){
						$from = explode(' a ', $request->range)[0];
						$to = explode(' a ', $request->range)[1];
						$where = "DATE_FORMAT(compras.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
						$builder->where($where);
					}else{
						$where = "DATE_FORMAT(compras.creado_en, '%Y-%m-%d') = '$request->range'";
						$builder->where($where);
					}
					
				}

				if($request->searchById != ''){

					$builder->where('compras.proveedor', $request->searchById);

				}
		
			})
			->toJson();
	}

	public function getBestProviders()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ReportModel = new ReportModel();
				
		return DataTable::of($ReportModel->getBestProviders())
			->edit('total', function($row){
				
				return '$ ' . number_format($row->total, 2);

			})
			->filter(function ($builder, $request) {
        
				if($request->range != ''){

					if(!empty(explode(' a ', $request->range)[1])){
						$from = explode(' a ', $request->range)[0];
						$to = explode(' a ', $request->range)[1];
						$where = "DATE_FORMAT(compras.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
						$builder->where($where);
					}else{
						$where = "DATE_FORMAT(compras.creado_en, '%Y-%m-%d') = '$request->range'";
						$builder->where($where);
					}
					
				}
		
			})
			->toJson();
	}

	public function getSalesPerCustomer()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ReportModel = new ReportModel();
				
		return DataTable::of($ReportModel->getSalesPerCustomer())
			->hide('cliente')
			->hide('tlfCliente')
			->hide('direcCliente')
			->hide('idCliente')
			->edit('fecha', function($row){
				return date('Y-m-d', strtotime($row->fecha));
			})
			->add('productos', function($row){
				$products = '';

				$ReportModel = new ReportModel();
				$detail = $ReportModel->getSaleDetailReportExcel($row->identificacion);

				foreach($detail as $item){
					$products = $products . "$item->nombreProducto $item->ancho_numero/$item->alto_numero $item->categoria Marca $item->marca <br>";
				}

				return $products;
			})
			->add('cantidad', function($row){
				$quantity = '';

				$ReportModel = new ReportModel();
				$detail = $ReportModel->getSaleDetailReportExcel($row->identificacion);

				foreach($detail as $item){
					$quantity = $quantity . "$item->cantidad <br>";
				}

				return $quantity;
			})
			->add('precio', function($row){
				$price = '';

				$ReportModel = new ReportModel();
				$detail = $ReportModel->getSaleDetailReportExcel($row->identificacion);

				foreach($detail as $item){
					$price = $price . number_format($item->precio, 2) . "<br>";
				}

				return $price;
			})
			->add('subtotal', function($row){
				$subtotal = 0;

				$ReportModel = new ReportModel();
				$detail = $ReportModel->getSaleDetailReportExcel($row->identificacion);

				foreach($detail as $item){
					$subtotal += $item->precio * $item->cantidad;
				}

				return number_format($subtotal, 2);
			})
			->add('total_impuesto', function($row){
				$subtotal = 0;

				$ReportModel = new ReportModel();
				$detail = $ReportModel->getSaleDetailReportExcel($row->identificacion);

				foreach($detail as $item){
					$subtotal += $item->precio * $item->cantidad;
				}

				$tax = ($subtotal * $row->impuesto)/100;

				return number_format($tax, 2);
			})
			->add('total', function($row){
				$subtotal = 0;

				$ReportModel = new ReportModel();
				$detail = $ReportModel->getSaleDetailReportExcel($row->identificacion);

				foreach($detail as $item){
					$subtotal += $item->precio * $item->cantidad;
				}

				$tax = ($subtotal * $row->impuesto)/100;
				$total = $subtotal + $tax;

				return number_format($total, 2);
				

			}, 'last')
			->filter(function ($builder, $request) {
        
				if($request->range != ''){

					if(!empty(explode(' a ', $request->range)[1])){
						$from = explode(' a ', $request->range)[0];
						$to = explode(' a ', $request->range)[1];
						$where = "DATE_FORMAT(ventas.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
						$builder->where($where);
					}else{
						$where = "DATE_FORMAT(ventas.creado_en, '%Y-%m-%d') = '$request->range'";
						$builder->where($where);
					}
					
				}

				if($request->searchById != ''){

					$builder->where('ventas.cliente', $request->searchById);

				}
		
			})
			->toJson();
	}

	public function getSalesPerProduct()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ReportModel = new ReportModel();
				
		return DataTable::of($ReportModel->getSalesPerProduct())
			->hide('codigo')
			->hide('producto')
			->hide('categoria')
			->hide('marca')
			->edit('fecha', function($row){
				return date('Y-m-d', strtotime($row->fecha));
			})
			->edit('precio', function($row){
				return number_format($row->precio, 2);
			})
			->edit('total', function($row){
				
				return '$ ' . number_format($row->total, 2);

			})
			->filter(function ($builder, $request) {
        
				if($request->range != ''){

					if(!empty(explode(' a ', $request->range)[1])){
						$from = explode(' a ', $request->range)[0];
						$to = explode(' a ', $request->range)[1];
						$where = "DATE_FORMAT(ventas.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
						$builder->where($where);
					}else{
						$where = "DATE_FORMAT(ventas.creado_en, '%Y-%m-%d') = '$request->range'";
						$builder->where($where);
					}
					
				}

				if($request->searchById != ''){

					$builder->where('detalle_ventas.producto', $request->searchById);

				}
		
			})
			->toJson();
	}

	public function getSalesPerPaymentMethod()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ReportModel = new ReportModel();
				
		return DataTable::of($ReportModel->getSalesPerPaymentMethod())
			->edit('fecha', function($row){
				return date('d-m-Y', strtotime($row->fecha));
			})
			->hide('impuesto')
			->hide('tasa')
			->hide('metodo_pago')
			->hide('moneda')
			->edit('total', function($row){

				$tax = ($row->total * $row->impuesto)/100;
				$total = $row->total + $tax;

				$total = $total * $row->tasa;

				return number_format($total, 2);
				

			})
			->filter(function ($builder, $request) {
        
				if($request->range != ''){

					if(!empty(explode(' a ', $request->range)[1])){
						$from = explode(' a ', $request->range)[0];
						$to = explode(' a ', $request->range)[1];
						$where = "DATE_FORMAT(ventas.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
						$builder->where($where);
					}else{
						$where = "DATE_FORMAT(ventas.creado_en, '%Y-%m-%d') = '$request->range'";
						$builder->where($where);
					}
					
				}

				if($request->paymentMethod != '' && $request->coin != ''){

					$builder->where('ventas.id_metodo_pago', $request->paymentMethod);
					$builder->where('ventas.moneda', $request->coin);

				}
		
			})
			->toJson();
	}

	public function getMostSelledProducts()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ReportModel = new ReportModel();
				
		return DataTable::of($ReportModel->getMostSelledProducts())
			->hide('ancho_numero')
			->hide('alto_numero')
			->edit('nombre', function($row){
				return "$row->nombre $row->ancho_numero/$row->alto_numero";
			})
			->edit('total', function($row){
				
				return '$ ' . number_format($row->total, 2);

			})
			->filter(function ($builder, $request) {
        
				if($request->range != ''){

					if(!empty(explode(' a ', $request->range)[1])){
						$from = explode(' a ', $request->range)[0];
						$to = explode(' a ', $request->range)[1];
						$where = "DATE_FORMAT(ventas.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
						$builder->where($where);
					}else{
						$where = "DATE_FORMAT(ventas.creado_en, '%Y-%m-%d') = '$request->range'";
						$builder->where($where);
					}
					
				}
		
			})
			->toJson();
	}

	public function getLessSoldProducts()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ReportModel = new ReportModel();
				
		return DataTable::of($ReportModel->getLessSoldProducts())
			->hide('ancho_numero')
			->hide('alto_numero')
			->edit('nombre', function($row){
				return "$row->nombre $row->ancho_numero/$row->alto_numero";
			})
			->edit('total', function($row){
				
				return '$ ' . number_format($row->total, 2);

			})
			->filter(function ($builder, $request) {
        
				if($request->range != ''){

					if(!empty(explode(' a ', $request->range)[1])){
						$from = explode(' a ', $request->range)[0];
						$to = explode(' a ', $request->range)[1];
						$where = "DATE_FORMAT(ventas.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
						$builder->where($where);
					}else{
						$where = "DATE_FORMAT(ventas.creado_en, '%Y-%m-%d') = '$request->range'";
						$builder->where($where);
					}
					
				}
		
			})
			->toJson();
	}

	public function getBestCustomers()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ReportModel = new ReportModel();
				
		return DataTable::of($ReportModel->getBestCustomers())
			->edit('total', function($row){
				
				return '$ ' . number_format($row->total, 2);

			})
			->filter(function ($builder, $request) {
        
				if($request->range != ''){

					if(!empty(explode(' a ', $request->range)[1])){
						$from = explode(' a ', $request->range)[0];
						$to = explode(' a ', $request->range)[1];
						$where = "DATE_FORMAT(ventas.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
						$builder->where($where);
					}else{
						$where = "DATE_FORMAT(ventas.creado_en, '%Y-%m-%d') = '$request->range'";
						$builder->where($where);
					}
					
				}
		
			})
			->toJson();
	}

	public function getGeneralPurchaseReports(){

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$range = $this->request->getPost('range');

		$ReportModel = new ReportModel();
		$generalReports = [];
		
		if(!empty(explode(' a ', $range)[1])){
			
			$from = explode(' a ', $range)[0];
			$to	= explode(' a ', $range)[1];

			// Total compras
			$generalPurchase = $ReportModel->generalPurchase($from, $to);
			$generalReports[0] = $generalPurchase;

			// Proveedores más comprados
			$generalProvidersPurchase = $ReportModel->generalProvidersPurchase($from, $to);
			$generalReports[1] = $generalProvidersPurchase;

			// Proveedores menos comprados
			$generalNegativeProvidersPurchase = $ReportModel->generalNegativeProvidersPurchase($from, $to);
			$generalReports[2] = $generalNegativeProvidersPurchase;

			

		}else{
		
			return false;
		
		}
		

		echo json_encode($generalReports);

	}

	public function getGeneralSaleReports(){

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$range = $this->request->getPost('range');

		$ReportModel = new ReportModel();
		$generalReports = [];
		
		if(!empty(explode(' a ', $range)[1])){
			
			$from = explode(' a ', $range)[0];
			$to	= explode(' a ', $range)[1];

			// Total ventas
			$generalSale = $ReportModel->generalSale($from, $to);
			$generalReports[0] = $generalSale;

			// Productos más comprados
			$generalProductsSale = $ReportModel->generalProductsSale($from, $to);
			$generalReports[1] = $generalProductsSale;

			// Productos menos comprados
			$generalNegativeProductsSale = $ReportModel->generalNegativeProductsSale($from, $to);
			$generalReports[2] = $generalNegativeProductsSale;

			

		}else{
		
			return false;
		
		}
		

		echo json_encode($generalReports);

	}

	/** 
	 * * OBTENER LOS DATOS DE SELECCIÓN
	 */

	public function getPurchasesProvider()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$db      	= \Config\Database::connect();
		$providers 	= $db
						->table('proveedores')
						->select('identificacion, nombre, direccion, telefono')
						->where('estado', 1);
				
		return DataTable::of($providers)
			->add('Seleccionar', function($row){
				return '<div class="btn-list"> 
							<button type="button" class="btn-select-prov btn btn-sm btn-primary waves-effect" data-id="'.$row->identificacion.'" data-type="providers">
                                <i class="fas fa-check"></i>
                            </button>
                        </div>';
			}, 'first') 
			->toJson();
	}

	public function getSalesCustomer()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$db      	= \Config\Database::connect();
		$customers 	= $db
						->table('clientes')
						->select('identificacion, nombre, direccion, telefono')
						->where('estado', 1);
				
		return DataTable::of($customers)
			->add('Seleccionar', function($row){
				return '<div class="btn-list"> 
							<button type="button" class="btn-select-customer btn btn-sm btn-primary waves-effect" data-id="'.$row->identificacion.'" data-type="customers">
                                <i class="fas fa-check"></i>
                            </button>
                        </div>';
			}, 'first') 
			->toJson();

	}

	public function getSalesProducts()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$db      	= \Config\Database::connect();
		$products 	= $db
						->table('productos')
						->select('productos.codigo, nombre, ancho_caucho.ancho_numero, alto_caucho.alto_numero, marcas.marca, categorias.categoria')
						->join('marcas', 'marcas.identificacion = productos.marca')
						->join('categorias', 'categorias.identificacion = productos.categoria')
						->join('ancho_caucho', 'ancho_caucho.id_ancho_caucho = productos.id_ancho_caucho')
						->join('alto_caucho', 'alto_caucho.id_alto_caucho = productos.id_alto_caucho')
						->where('productos.estado', 1);
				
		return DataTable::of($products)
			->hide('ancho_numero')
			->hide('alto_numero')
			->edit('nombre', function($row){
				return "$row->nombre $row->ancho_numero/$row->alto_numero";
			})
			->add('Seleccionar', function($row){
				return '<div class="btn-list"> 
							<button type="button" class="btn-select-product btn btn-sm btn-primary waves-effect" data-id="'.$row->codigo.'" data-type="products">
                                <i class="fas fa-check"></i>
                            </button>
                        </div>';
			}, 'first') 
			->toJson();
	}

	/** 
	 * * GENERAR REPORTES EN EXCEL
	 */

	public function getPurchaseReportExcel($range = NULL)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ReportModel = new ReportModel();
		$getPurchaseReportExcel = $ReportModel->getPurchaseReportExcel();

		$name = "reporte-compras.xls";
		$nameHeader = "Todas las compras realizadas en el sistema";

		if ( $range != NULL && $range != ''){
			
			if(!empty(explode('a', $range)[1])){
				$from = explode('a', $range)[0];
				$to = explode('a', $range)[1];
				$where = "DATE_FORMAT(compras.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
				$getPurchaseReportExcel = $getPurchaseReportExcel->where($where);
				$name = "reporte-compras-$from-$to.xls";
				$nameHeader = "Desde $from hasta $to";
			}else{
				$where = "DATE_FORMAT(compras.creado_en, '%Y-%m-%d') = '$range'";
				$getPurchaseReportExcel = $getPurchaseReportExcel->where($where);
				$name = "reporte-compras-$range.xls";
				$nameHeader = "Del día $range";
			}

		}

		$getPurchaseReportExcel = $getPurchaseReportExcel->get()->getResult();

		if(!$getPurchaseReportExcel){
			return "Error";
		}

		header("Pragma: public");
		header("Expires: 0");
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=$name");
		header("Pragma: no-cache");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

		echo utf8_decode("
		
		<table>
			<tr>

				<td style='background-color:white; width:350px'>
					
					<div style='font-size:12px; text-align:left; line-height:15px; margin-left: 20px'>
						
						<br>
						<strong style='font-size: 22px'>Reporte general de compras</strong>
						<br>
						<strong>$nameHeader</strong>

					</div>

				</td>

				<td style='width:150px;'>
					
				</td>

				<td style='background-color:white; width:140px'>

				
					
				</td>

				<td style='background-color:white; width:140px'>

					<div style='font-size:12px; text-align:right; margin-left: 50px'>
						<br>
						<strong style='font-size: 18px'>Generado:</strong>
						<br>
						". date('d-m-Y H:i') . "

					</div>
					
				</td>

			</tr>
		</table>
		
		");

		echo utf8_decode("
		
		<table>
		
		<tr>
			
			<td style='width:150px; margin-left: 20px'>
				<div style='font-size:12px; text-align: center; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong style='font-size: 20px'>$this->businessName</strong>
					
					<br>

				</div>

            </td>

			<td style='background-color:white; width:210px'>
				
				<div style='font-size:12px; text-align:right; line-height:15px;'>
					
					<br>
					<strong>RIF:</strong> $this->businessIdentification

					<br>
					<strong>Dirección:</strong> $this->businessAddress

				</div>

			</td>

			<td style='background-color:white; width:140px'>

				<div style='font-size:12px; text-align:right; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong>Teléfono:</strong> $this->businessPhone
					
					<br>
					

				</div>
				
			</td>

		</tr>

	</table>

		");
		
		echo "<br>";

		echo utf8_decode("<table border='0'> 

		<tr> 
			<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>		
			<td style='font-weight:bold; border:1px solid #eee;'>NÚMERO DE COMPRA</td>
			<td style='font-weight:bold; border:1px solid #eee;'>IDENTIFICACIÓN PROVEEDOR</td>
			<td style='font-weight:bold; border:1px solid #eee;'>NOMBRE PROVEEDOR</td>
			<td style='font-weight:bold; border:1px solid #eee;'>USUARIO</td>
			<td style='font-weight:bold; border:1px solid #eee;'>MONEDA</td>
			<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>			
		</tr>");

			$totalPurchase = 0;
			foreach ($getPurchaseReportExcel as $row => $item){


				echo utf8_decode("<tr>
							<td style='border:1px solid #eee;'>".$item->fecha."</td>	
							<td style='border:1px solid #eee;'>".$item->idCompra."</td>
							<td style='border:1px solid #eee;'>".$item->identificacion."</td>
							<td style='border:1px solid #eee;'>".$item->nombre."</td>
							<td style='border:1px solid #eee;'>".$item->usuario."</td>
							<td style='border:1px solid #eee;'>".$item->moneda."</td>");


				$getPurchaseDetailReportExcel = $ReportModel->getPurchaseDetailReportExcel($item->idCompra);

				$total = 0;

				foreach ($getPurchaseDetailReportExcel as $row2 => $item2){

					$total = $total + ($item2->cantidad * $item2->precio);
				}
				$totalPurchase += $total;

			echo utf8_decode("</td>	
					<td style='border:1px solid #eee;'>".number_format($total, 2)."</td>
						
						</tr>");
			
			
		}

		echo utf8_decode("</td>	
			<td style='border:1px solid #eee;'></td>
			<td style='border:1px solid #eee;'></td>
			<td style='border:1px solid #eee;'></td>
			<td style='border:1px solid #eee;'></td>
			<td style='border:1px solid #eee;'></td>
			<td style='border:1px solid #eee;'>Total</td>
			<td style='border:1px solid #eee;'>".number_format($totalPurchase, 2)."</td>	
			</tr>");

			echo "</table>";

	}

	public function getOrderReportExcel($range = NULL)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ReportModel = new ReportModel();
		$getOrderReportExcel = $ReportModel->getOrderReportExcel();

		$name = "reporte-pedidos.xls";
		$nameHeader = "Todos los pedidos realizados en el sistema";

		if ( $range != NULL && $range != ''){
			
			if(!empty(explode('a', $range)[1])){
				$from = explode('a', $range)[0];
				$to = explode('a', $range)[1];
				$where = "DATE_FORMAT(pedido.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
				$getOrderReportExcel = $getOrderReportExcel->where($where);
				$name = "reporte-pedidos-$from-$to.xls";
				$nameHeader = "Desde $from hasta $to";
			}else{
				$where = "DATE_FORMAT(pedido.creado_en, '%Y-%m-%d') = '$range'";
				$getOrderReportExcel = $getOrderReportExcel->where($where);
				$name = "reporte-pedidos-$range.xls";
				$nameHeader = "Del día $range";
			}

		}

		$getOrderReportExcel = $getOrderReportExcel->get()->getResult();

		if(!$getOrderReportExcel){
			return "Error";
		}

		header("Pragma: public");
		header("Expires: 0");
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=$name");
		header("Pragma: no-cache");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

		echo utf8_decode("
		
		<table>
			<tr>

				<td style='background-color:white; width:350px'>
					
					<div style='font-size:12px; text-align:left; line-height:15px; margin-left: 20px'>
						
						<br>
						<strong style='font-size: 22px'>Reporte general de pedidos</strong>
						<br>
						<strong>$nameHeader</strong>

					</div>

				</td>

				<td style='width:150px;'>
					
				</td>

				<td style='background-color:white; width:140px'>

				
					
				</td>

				<td style='background-color:white; width:140px'>

					<div style='font-size:12px; text-align:right; margin-left: 50px'>
						<br>
						<strong style='font-size: 18px'>Generado:</strong>
						<br>
						". date('d-m-Y H:i') . "

					</div>
					
				</td>

			</tr>
		</table>
		
		");

		echo utf8_decode("
		
		<table>
		
		<tr>
			
			<td style='width:150px; margin-left: 20px'>
				<div style='font-size:12px; text-align: center; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong style='font-size: 20px'>$this->businessName</strong>
					
					<br>

				</div>

            </td>

			<td style='background-color:white; width:210px'>
				
				<div style='font-size:12px; text-align:right; line-height:15px;'>
					
					<br>
					<strong>RIF:</strong> $this->businessIdentification

					<br>
					<strong>Dirección:</strong> $this->businessAddress

				</div>

			</td>

			<td style='background-color:white; width:140px'>

				<div style='font-size:12px; text-align:right; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong>Teléfono:</strong> $this->businessPhone
					
					<br>
					

				</div>
				
			</td>

		</tr>

	</table>

		");
		
		echo "<br>";

		echo utf8_decode("<table border='0'> 

		<tr> 
			<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>		
			<td style='font-weight:bold; border:1px solid #eee;'>NÚMERO DE COMPRA</td>
			<td style='font-weight:bold; border:1px solid #eee;'>IDENTIFICACIÓN PROVEEDOR</td>
			<td style='font-weight:bold; border:1px solid #eee;'>NOMBRE PROVEEDOR</td>
			<td style='font-weight:bold; border:1px solid #eee;'>USUARIO</td>
			<td style='font-weight:bold; border:1px solid #eee;'>ESTADO</td>
			<td style='font-weight:bold; border:1px solid #eee;'>MONEDA</td>
			<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>			
		</tr>");

			$totalPurchase = 0;
			foreach ($getOrderReportExcel as $row => $item){

				switch($item->estado_pedido){
					case 0:
						$estado = 'Anulado';
						break;
					case 1:
						$estado = 'Aprobado';
						break;
					case 2:
						$estado = 'Pendiente';
						break;
				}


				echo utf8_decode("<tr>
							<td style='border:1px solid #eee;'>".$item->fecha."</td>	
							<td style='border:1px solid #eee;'>".$item->id_pedido."</td>
							<td style='border:1px solid #eee;'>".$item->identificacion."</td>
							<td style='border:1px solid #eee;'>".$item->nombre."</td>
							<td style='border:1px solid #eee;'>".$estado."</td>
							<td style='border:1px solid #eee;'>".$item->ci_usuario."</td>
							<td style='border:1px solid #eee;'>".$item->moneda."</td>");


				$getOrderDetailReportExcel = $ReportModel->getOrderDetailReportExcel($item->id_pedido);

				$total = 0;

				foreach ($getOrderDetailReportExcel as $row2 => $item2){

					$total = $total + ($item2->cantidad * $item2->precio);
				}
				$totalPurchase += $total;

			echo utf8_decode("</td>	
					<td style='border:1px solid #eee;'>".number_format($total, 2)."</td>
						
						</tr>");
			
			
		}

		echo utf8_decode("</td>	
			<td style='border:1px solid #eee;'></td>
			<td style='border:1px solid #eee;'></td>
			<td style='border:1px solid #eee;'></td>
			<td style='border:1px solid #eee;'></td>
			<td style='border:1px solid #eee;'></td>
			<td style='border:1px solid #eee;'></td>
			<td style='border:1px solid #eee;'>Total</td>
			<td style='border:1px solid #eee;'>".number_format($totalPurchase, 2)."</td>	
			</tr>");

			echo "</table>";

	}

	public function getSaleReportExcel($range = NULL)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ReportModel = new ReportModel();
		$getSaleReportExcel = $ReportModel->getSaleReportExcel();

		$name = "reporte-ventas.xls";
		$nameHeader = "Reporte de todas las ventas del sistema";

		if ( $range != NULL && $range != ''){
			
			if(!empty(explode('a', $range)[1])){
				$from = explode('a', $range)[0];
				$to = explode('a', $range)[1];
				$where = "DATE_FORMAT(ventas.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
				$getSaleReportExcel = $getSaleReportExcel->where($where);
				$name = "reporte-ventas-$from-$to.xls";
				$nameHeader = "Desde $from hasta $to";
			}else{
				$where = "DATE_FORMAT(ventas.creado_en, '%Y-%m-%d') = '$range'";
				$getSaleReportExcel = $getSaleReportExcel->where($where);
				$name = "reporte-ventas-$range.xls";
				$nameHeader = "Del día $range";
			}

		}

		$getSaleReportExcel = $getSaleReportExcel->get()->getResult();

		if(!$getSaleReportExcel){
			return "Error";
		}

		header("Pragma: public");
		header("Expires: 0");
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=$name");
		header("Pragma: no-cache");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

		echo utf8_decode("
		
		<table>
			<tr>

				<td style='background-color:white; width:350px'>
					
					<div style='font-size:12px; text-align:left; line-height:15px; margin-left: 20px'>
						
						<br>
						<strong style='font-size: 22px'>Reporte general de ventas</strong>
						<br>
						<strong>$nameHeader</strong>

					</div>

				</td>

				<td style='width:150px;'>
					
				</td>

				<td style='background-color:white; width:140px'>

				
					
				</td>

				<td style='background-color:white; width:140px'>

					<div style='font-size:12px; text-align:right; margin-left: 50px'>
						<br>
						<strong style='font-size: 18px'>Generado:</strong>
						<br>
						". date('d-m-Y H:i') . "

					</div>
					
				</td>

			</tr>
		</table>
		
		");

		echo utf8_decode("
		
		<table>
		
		<tr>
			
			<td style='width:150px; margin-left: 20px'>
				<div style='font-size:12px; text-align: center; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong style='font-size: 20px'>$this->businessName</strong>
					
					<br>

				</div>

            </td>

			<td style='background-color:white; width:210px'>
				
				<div style='font-size:12px; text-align:right; line-height:15px;'>
					
					<br>
					<strong>RIF:</strong> $this->businessIdentification

					<br>
					<strong>Dirección:</strong> $this->businessAddress

				</div>

			</td>

			<td style='background-color:white; width:140px'>

				<div style='font-size:12px; text-align:right; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong>Teléfono:</strong> $this->businessPhone
					
					<br>
					

				</div>
				
			</td>

		</tr>

	</table>

		");
		echo "<br>";

		echo utf8_decode("<table border='0'> 

		<tr> 
			<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>		
			<td style='font-weight:bold; border:1px solid #eee;'>FACTURA</td> 
			<td style='font-weight:bold; border:1px solid #eee;'>IDENTIFICACIÓN DEL CLIENTE</td>
			<td style='font-weight:bold; border:1px solid #eee;'>NOMBRE DEL CLIENTE</td>
			<td style='font-weight:bold; border:1px solid #eee;'>VENDEDOR</td>
			<td style='font-weight:bold; border:1px solid #eee;'>MÉTODO DE PAGO</td>
			<td style='font-weight:bold; border:1px solid #eee;'>IMPUESTO</td>	
			<td style='font-weight:bold; border:1px solid #eee;'>SUBTOTAL</td>
			<td style='font-weight:bold; border:1px solid #eee;'>IMPUESTO</td>
			<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>			
		</tr>");

		$grandTotal = 0;
			foreach ($getSaleReportExcel as $row => $item){


				echo utf8_decode("<tr>
							<td style='border:1px solid #eee;'>".date('d-m-Y', strtotime($item->fecha))."</td>		
							<td style='border:1px solid #eee;'>".$item->identificacion."</td> 
							<td style='border:1px solid #eee;'>".$item->cliente."</td>
							<td style='border:1px solid #eee;'>".$item->nombre."</td>
							<td style='border:1px solid #eee;'>".$item->usuario."</td>
							<td style='border:1px solid #eee;'>".$item->metodo_pago."</td>
							<td style='border:1px solid #eee;'>");


				$getSaleDetailReportExcel = $ReportModel->getSaleDetailReportExcel($item->identificacion);

				$subtotal = 0;

				foreach ($getSaleDetailReportExcel as $row2 => $item2){

					$subtotal = $subtotal + ($item2->cantidad * $item2->precio);
				}

				$tax = ($subtotal * $item->impuesto) / 100;
				$total = $subtotal + $tax;
				$grandTotal += $total;

			echo utf8_decode("</td>	
					<td style='border:1px solid #eee;'>".number_format($subtotal, 2)."</td>
					<td style='border:1px solid #eee;'>".number_format($tax, 2)."</td>
					<td style='border:1px solid #eee;'>".number_format($total, 2)."</td>
						</tr>");
		}

		echo utf8_decode("

		<tr> 
			<td style='font-weight:regular; border:1px solid #eee;'></td>
			<td style='font-weight:regular; border:1px solid #eee;'></td>		
			<td style='font-weight:regular; border:1px solid #eee;'></td>		
			<td style='font-weight:regular; border:1px solid #eee;'></td>		
			<td style='font-weight:regular; border:1px solid #eee;'></td>		
			<td style='font-weight:regular; border:1px solid #eee;'></td>		
			<td style='font-weight:regular; border:1px solid #eee;'></td>		
			<td style='font-weight:regular; border:1px solid #eee;'></td>		
			<td style='font-weight:regular; border:1px solid #eee;'>Total</td>		
			<td style='font-weight:regular; border:1px solid #eee;'>".number_format($grandTotal, 2)."</td>		
					
		</tr>");


			echo "</table>";

	}

	public function getSalePerCustomerReportExcel($customer, $range = NULL)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ReportModel = new ReportModel();
		$ReportModel = $ReportModel->getSalesPerCustomer();

		$ReportModel = $ReportModel->where('cliente', $customer);

		$name = "reporte-ventas-por-cliente.xls";
		$nameHeader = "Todas las ventas por cliente";

		if ( $range != NULL ){
			
			if(!empty(explode('a', $range)[1])){
				$from = explode('a', $range)[0];
				$to = explode('a', $range)[1];
				$where = "DATE_FORMAT(ventas.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
				$ReportModel = $ReportModel->where($where);
				$name = "reporte-ventas-por-cliente-$from-$to.xls";
				$nameHeader = "Desde $from hasta $to";
			}else{
				$where = "DATE_FORMAT(ventas.creado_en, '%Y-%m-%d') = '$range'";
				$ReportModel = $ReportModel->where($where);
				$name = "reporte-ventas-por-cliente-$range.xls";
				$nameHeader = "Del día $range";
			}

		}

		$ReportModel = $ReportModel->get()->getResult();

		if(!$ReportModel){
			return "Error";
		}

		header("Pragma: public");
		header("Expires: 0");
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=$name");
		header("Pragma: no-cache");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

		echo utf8_decode("
		
		<table>
			<tr>

				<td style='background-color:white; width:350px'>
					
					<div style='font-size:12px; text-align:left; line-height:15px; margin-left: 20px'>
						
						<br>
						<strong style='font-size: 22px'>Reporte de ventas por cliente</strong>
						<br>
						<strong>$nameHeader</strong>

					</div>

				</td>

				<td style='width:150px;'>
					
				</td>

				<td style='background-color:white; width:140px'>

				
					
				</td>

				<td style='background-color:white; width:140px'>

					<div style='font-size:12px; text-align:right; margin-left: 50px'>
						<br>
						<strong style='font-size: 18px'>Generado:</strong>
						<br>
						". date('d-m-Y H:i') . "

					</div>
					
				</td>

			</tr>
		</table>
		
		");

		echo utf8_decode("
		
		<table>
		
		<tr>
			
			<td style='width:150px; margin-left: 20px'>
				<div style='font-size:12px; text-align: center; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong style='font-size: 20px'>$this->businessName</strong>
					
					<br>

				</div>

            </td>

			<td style='background-color:white; width:210px'>
				
				<div style='font-size:12px; text-align:right; line-height:15px;'>
					
					<br>
					<strong>RIF:</strong> $this->businessIdentification

					<br>
					<strong>Dirección:</strong> $this->businessAddress

				</div>

			</td>

			<td style='background-color:white; width:140px'>

				<div style='font-size:12px; text-align:right; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong>Teléfono:</strong> $this->businessPhone
					
					<br>
					

				</div>
				
			</td>

		</tr>

	</table>

		");

		echo utf8_decode("
		
		<table>
		
		<tr>
			
			<td style='width:150px; margin-left: 20px'>
				<div style='font-size:12px; text-align: center; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong style='font-size: 20px'>Cliente</strong>
					
					<br>

				</div>

            </td>

			<td style='background-color:white; width:210px'>
				
				<div style='font-size:12px; text-align:right; line-height:15px;'>
				
					<br>
					<strong>Identificación:</strong> ".$ReportModel[0]->idCliente."

					<br>
					<strong>Nombre:</strong> ".$ReportModel[0]->cliente."


				</div>

			</td>

			<td style='background-color:white; width:140px'>

				<div style='font-size:12px; text-align:right; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong>Teléfono:</strong> ".$ReportModel[0]->tlfCliente."
					
					<br>
					<strong>Dirección:</strong> ".$ReportModel[0]->direcCliente."
					

				</div>
				
			</td>

		</tr>

	</table>

		");
		
		echo "<br>";
		echo utf8_decode("<table border='0'> 

		<tr> 
			<td style='font-weight:bold; border:1px solid #eee; width: 50px;'>FACTURA</td> 
			<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>		
			<td style='font-weight:bold; border:1px solid #eee;'>VENDEDOR</td>
			<td style='font-weight:bold; border:1px solid #eee;'>MÉTODO DE PAGO</td>
			<td style='font-weight:bold; border:1px solid #eee;'>IMPUESTO</td>
			<td style='font-weight:bold; border:1px solid #eee;'>PRODUCTOS</td>
			<td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD</td>
			<td style='font-weight:bold; border:1px solid #eee;'>PRECIO PRODUCTO</td>
			<td style='font-weight:bold; border:1px solid #eee;'>SUBTOTAL</td>
			<td style='font-weight:bold; border:1px solid #eee;'>TOTAL IMPUESTO</td>
			<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>			
		</tr>");

		$grandSubTotal = 0;
		$grandTax = 0;
		$grandTotal = 0;
		foreach ($ReportModel as $row => $item){

			$detail = new ReportModel();
			$detail = $detail->getSaleDetailReportExcel($item->identificacion);
			$subtotal = 0;
			

			echo utf8_decode("<tr>
						<td style='border:1px solid #eee;'>".$item->identificacion."</td>
						<td style='border:1px solid #eee;'>".date('Y-m-d', strtotime($item->fecha))."</td>
						<td style='border:1px solid #eee;'>".$item->usuario."</td>
						<td style='border:1px solid #eee;'>".$item->metodo_pago."</td>
						<td style='border:1px solid #eee;'>".$item->impuesto."</td>
						<td style='border:1px solid #eee;'>");

			
			foreach($detail as $row){
				echo utf8_decode("<br> $row->nombreProducto $row->ancho_numero/$row->alto_numero $row->categoria Marca $row->marca <br>");
				$subtotal += $row->precio * $row->cantidad;
			}

			$grandSubTotal += $subtotal;

			$tax = ($subtotal * $item->impuesto) / 100;
			$grandTax += $tax;
			$total = $subtotal + $tax;
			$grandTotal += $total;


			echo utf8_decode("</td>");
			echo utf8_decode("<td style='border:1px solid #eee;'>");
			foreach($detail as $row){
				echo utf8_decode("<br>".$row->cantidad."<br>");
			}

			echo utf8_decode("</td>");

			echo utf8_decode("<td style='border:1px solid #eee;'>");
			
			foreach($detail as $row){
				
				echo utf8_decode("<br>".$row->precio."<br>");
			}

			echo utf8_decode("</td>");

			echo utf8_decode("
				<td style='border:1px solid #eee;'>".number_format($subtotal, 2)."</td>
				<td style='border:1px solid #eee;'>".number_format($tax, 2)."</td>
				<td style='border:1px solid #eee;'>".number_format($total, 2)."</td>
			</tr>
			");

		}

		
		echo utf8_decode("<tr>
					<td style='border:1px solid #eee;'></td>
					<td style='border:1px solid #eee;'></td> 
					<td style='border:1px solid #eee;'></td>
					<td style='border:1px solid #eee;'></td>
					<td style='border:1px solid #eee;'></td>
					<td style='border:1px solid #eee;'></td>
					<td style='border:1px solid #eee;'></td>
					<td style='border:1px solid #eee;'>Total</td>
					<td style='border:1px solid #eee;'>".number_format($grandSubTotal, 2)."</td>
					<td style='border:1px solid #eee;'>".number_format($grandTax, 2)."</td>
					<td style='border:1px solid #eee;'>".number_format($grandTotal, 2)."</td>
					</tr>");
		
		echo "</table>";
	}

	public function getSalePerProductReportExcel($product, $range = NULL)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ReportModel = new ReportModel();
		$ReportModel = $ReportModel->getSalesPerProduct();

		$ReportModel = $ReportModel->where('detalle_ventas.producto', $product);

		$name = "reporte-ventas-por-producto.xls";
		$nameHeader = "Todas las ventas por producto";

		if ( $range != NULL ){
			
			if(!empty(explode('a', $range)[1])){
				$from = explode('a', $range)[0];
				$to = explode('a', $range)[1];
				$where = "DATE_FORMAT(ventas.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
				$ReportModel = $ReportModel->where($where);
				$name = "reporte-ventas-por-producto-$from-$to.xls";
				$nameHeader = "Desde $from hasta $to";
			}else{
				$where = "DATE_FORMAT(ventas.creado_en, '%Y-%m-%d') = '$range'";
				$ReportModel = $ReportModel->where($where);
				$name = "reporte-ventas-por-producto-$range.xls";
				$nameHeader = "Del día $range";
			}

		}

		$ReportModel = $ReportModel->get()->getResult();
		
		if(!$ReportModel){
			return "Error";
		}

		header("Pragma: public");
		header("Expires: 0");
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=$name");
		header("Pragma: no-cache");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

		echo utf8_decode("
		
		<table>
			<tr>

				<td style='background-color:white; width:350px'>
					
					<div style='font-size:12px; text-align:left; line-height:15px; margin-left: 20px'>
						
						<br>
						<strong style='font-size: 22px'>Reporte de ventas por producto</strong>
						<br>
						<strong>$nameHeader</strong>

					</div>

				</td>

				<td style='width:150px;'>
					
				</td>

				<td style='background-color:white; width:140px'>

				
					
				</td>

				<td style='background-color:white; width:140px'>

					<div style='font-size:12px; text-align:right; margin-left: 50px'>
						<br>
						<strong style='font-size: 18px'>Generado:</strong>
						<br>
						". date('d-m-Y H:i') . "

					</div>
					
				</td>

			</tr>
		</table>
		
		");

		echo utf8_decode("
		
		<table>
		
		<tr>
			
			<td style='width:150px; margin-left: 20px'>
				<div style='font-size:12px; text-align: center; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong style='font-size: 20px'>$this->businessName</strong>
					
					<br>

				</div>

            </td>

			<td style='background-color:white; width:210px'>
				
				<div style='font-size:12px; text-align:right; line-height:15px;'>
					
					<br>
					<strong>RIF:</strong> $this->businessIdentification

					<br>
					<strong>Dirección:</strong> $this->businessAddress

				</div>

			</td>

			<td style='background-color:white; width:140px'>

				<div style='font-size:12px; text-align:right; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong>Teléfono:</strong> $this->businessPhone
					
					<br>
					

				</div>
				
			</td>

		</tr>

	</table>

		");

	echo utf8_decode("
		
		<table>
		
		<tr>
			
			<td style='width:150px; margin-left: 20px'>
				<div style='font-size:12px; text-align: center; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong style='font-size: 20px'>Producto</strong>
					
					<br>

				</div>

            </td>

			<td style='background-color:white; width:210px'>
				
				<div style='font-size:12px; text-align:right; line-height:15px;'>
				
					<br>
					<strong>Código:</strong> ".$ReportModel[0]->codigo."

					<br>
					<strong>Categoría:</strong> ".$ReportModel[0]->categoria."


				</div>

			</td>

			<td style='background-color:white; width:140px'>

				<div style='font-size:12px; text-align:right; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong>Descripción:</strong> ".$ReportModel[0]->producto . " ". $ReportModel[0]->ancho_numero."/". $ReportModel[0]->alto_numero."
					
					<br>
					<strong>Marca:</strong> ".$ReportModel[0]->marca."
					

				</div>
				
			</td>

		</tr>

	</table>

		");
		
		echo "<br>";

		echo utf8_decode("<table border='0'> 

		<tr> 
			<td style='font-weight:bold; border:1px solid #eee;'>FACTURA</td> 
			<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>		
			<td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD</td>
			<td style='font-weight:bold; border:1px solid #eee;'>PRECIO UNITARIO</td>
			<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>			
		</tr>");

		$cantidad = 0;
		$total = 0;

		foreach ($ReportModel as $row => $item){

			echo utf8_decode("<tr>
						<td style='border:1px solid #eee;'>".$item->identificacion."</td>
						<td style='border:1px solid #eee;'>".date('Y-m-d', strtotime($item->fecha))."</td> 
						<td style='border:1px solid #eee;'>".$item->cantidad."</td>
						<td style='border:1px solid #eee;'>".number_format($item->precio, 2)."</td>
						<td style='border:1px solid #eee;'>".number_format($item->total, 2)."</td>
						</tr>");

			$cantidad += $item->cantidad;
			$total += $item->total;

		}

		echo utf8_decode("<tr>
						<td style='border:1px solid #eee;'></td>
						<td style='border:1px solid #eee; text-align: right'>Total</td>
						<td style='border:1px solid #eee;'>".$cantidad."</td>
						<td style='border:1px solid #eee;'></td>
						<td style='border:1px solid #eee;'>".number_format($total, 2)."</td>
						</tr>");
		
		echo "</table>";
	}

	public function getSalePerPaymentMethodReportExcel($paymentMethod, $coin, $range = NULL)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ReportModel = new ReportModel();
		$ReportModel = $ReportModel->getSalesPerPaymentMethod();

		$ReportModel = $ReportModel->where('ventas.id_metodo_pago', $paymentMethod);
		$ReportModel = $ReportModel->where('ventas.moneda', $coin);

		$name = "reporte-ventas-por-metodo-pago.xls";
		$nameHeader = "Todas las ventas por método de pago";

		if ( $range != NULL ){
			
			if(!empty(explode('a', $range)[1])){
				$from = explode('a', $range)[0];
				$to = explode('a', $range)[1];
				$where = "DATE_FORMAT(ventas.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
				$ReportModel = $ReportModel->where($where);
				$name = "reporte-ventas-por-metodo-pago-$from-$to.xls";
				$nameHeader = "Desde $from hasta $to";
			}else{
				$where = "DATE_FORMAT(ventas.creado_en, '%Y-%m-%d') = '$range'";
				$ReportModel = $ReportModel->where($where);
				$name = "reporte-ventas-por-metodo-pago-$range.xls";
				$nameHeader = "Del día $range";
			}

		}

		$ReportModel = $ReportModel->get()->getResult();
		
		if(!$ReportModel){
			return "Error";
		}

		header("Pragma: public");
		header("Expires: 0");
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=$name");
		header("Pragma: no-cache");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

		echo utf8_decode("
		
		<table>
			<tr>

				<td style='background-color:white; width:350px'>
					
					<div style='font-size:12px; text-align:left; line-height:15px; margin-left: 20px'>
						
						<br>
						<strong style='font-size: 22px'>Reporte de ventas por método de pago</strong>
						<br>
						<strong>$nameHeader</strong>

					</div>

				</td>

				<td style='width:150px;'>
					
				</td>

				<td style='background-color:white; width:140px'>

				
					
				</td>

				<td style='background-color:white; width:140px'>

					<div style='font-size:12px; text-align:right; margin-left: 50px'>
						<br>
						<strong style='font-size: 18px'>Generado:</strong>
						<br>
						". date('d-m-Y H:i') . "

					</div>
					
				</td>

			</tr>
		</table>
		
		");

		echo utf8_decode("
		
		<table>
		
		<tr>
			
			<td style='width:150px; margin-left: 20px'>
				<div style='font-size:12px; text-align: center; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong style='font-size: 20px'>$this->businessName</strong>
					
					<br>

				</div>

            </td>

			<td style='background-color:white; width:210px'>
				
				<div style='font-size:12px; text-align:right; line-height:15px;'>
					
					<br>
					<strong>RIF:</strong> $this->businessIdentification

					<br>
					<strong>Dirección:</strong> $this->businessAddress

				</div>

			</td>

			<td style='background-color:white; width:140px'>

				<div style='font-size:12px; text-align:right; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong>Teléfono:</strong> $this->businessPhone
					
					<br>
					

				</div>
				
			</td>

		</tr>

	</table>

		");

	echo utf8_decode("
		
		<table>
		
		<tr>
			
			<td style='width:150px; margin-left: 20px'>
				<div style='font-size:12px; text-align: center; line-height:15px; margin-left: 50px'>

				</div>

            </td>

			<td style='background-color:white; width:210px'>
				
				<div style='font-size:12px; text-align:right; line-height:15px;'>
				
					<br>
					<strong>Método de pago:</strong> ".$ReportModel[0]->metodo_pago."
					<br>

				</div>

			</td>

			<td style='background-color:white; width:140px'>

				<div style='font-size:12px; text-align:right; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong>Moneda:</strong> ".$ReportModel[0]->moneda."
					<br>

				</div>
				
			</td>

		</tr>

	</table>

		");
		
		echo "<br>";

		echo utf8_decode("<table border='0'> 

		<tr> 
			<td style='font-weight:bold; border:1px solid #eee;'>FACTURA</td> 
			<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>		
			<td style='font-weight:bold; border:1px solid #eee;'>USUARIO</td>
			<td style='font-weight:bold; border:1px solid #eee;'>Cliente</td>
			<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>			
		</tr>");

		$total = 0;

		foreach ($ReportModel as $row => $item){

			$subtotal = (($item->total * $item->impuesto) / 100) + $item->total;

			echo utf8_decode("<tr>
						<td style='border:1px solid #eee;'>".$item->identificacion."</td>
						<td style='border:1px solid #eee;'>".date('d-m-Y', strtotime($item->fecha))."</td> 
						<td style='border:1px solid #eee;'>".$item->usuario."</td>
						<td style='border:1px solid #eee;'>".$item->cliente."</td>
						<td style='border:1px solid #eee;'>".number_format($subtotal, 2)."</td>
						</tr>");

			
			$total += $subtotal;

		}

		echo utf8_decode("<tr>
						<td style='border:1px solid #eee;'></td>
						<td style='border:1px solid #eee;'></td>
						<td style='border:1px solid #eee;'></td>
						<td style='border:1px solid #eee; text-align: right'>Total</td>
						<td style='border:1px solid #eee;'>".number_format($total, 2)."</td>
						</tr>");
		
		echo "</table>";
	}

	public function getPurchasePerProviderReportExcel($provider, $range = NULL)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ReportModel = new ReportModel();
		$ReportModel = $ReportModel->getPurchasesPerProvider();

		$ReportModel = $ReportModel->where('compras.proveedor', $provider);

		$name = "reporte-compras-por-proveedor.xls";
		$nameHeader = "Todas las compras por proveedor";

		if ( $range != NULL ){
			
			if(!empty(explode('a', $range)[1])){
				$from = explode('a', $range)[0];
				$to = explode('a', $range)[1];
				$where = "DATE_FORMAT(compras.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
				$ReportModel = $ReportModel->where($where);
				$name = "reporte-compras-por-proveedor-$from-$to.xls";
				$nameHeader = "Desde $from hasta $to";
			}else{
				$where = "DATE_FORMAT(compras.creado_en, '%Y-%m-%d') = '$range'";
				$ReportModel = $ReportModel->where($where);
				$name = "reporte-compras-por-proveedor-$range.xls";
				$nameHeader = "Del día $range";
			}

		}

		$ReportModel = $ReportModel->get()->getResult();

		if(!$ReportModel){
			return "Error";
		}


		// header("Pragma: public");
		// header("Expires: 0");
		// header("Content-type: application/x-msdownload");
		// header("Content-Disposition: attachment; filename=$name");
		// header("Pragma: no-cache");
		// header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

		echo utf8_decode("
		
		<table>
			<tr>

				<td style='background-color:white; width:350px'>
					
					<div style='font-size:12px; text-align:left; line-height:15px; margin-left: 20px'>
						
						<br>
						<strong style='font-size: 22px'>Reporte de compras por proveedor</strong>
						<br>
						<strong>$nameHeader</strong>

					</div>

				</td>

				<td style='width:150px;'>
					
				</td>

				<td style='background-color:white; width:140px'>

				
					
				</td>

				<td style='background-color:white; width:140px'>

					<div style='font-size:12px; text-align:right; margin-left: 50px'>
						<br>
						<strong style='font-size: 18px'>Generado:</strong>
						<br>
						". date('d-m-Y H:i') . "

					</div>
					
				</td>

			</tr>
		</table>
		
		");

		echo utf8_decode("
		
		<table>
		
		<tr>
			
			<td style='width:150px; margin-left: 20px'>
				<div style='font-size:12px; text-align: center; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong style='font-size: 20px'>$this->businessName</strong>
					
					<br>

				</div>

            </td>

			<td style='background-color:white; width:210px'>
				
				<div style='font-size:12px; text-align:right; line-height:15px;'>
					
					<br>
					<strong>RIF:</strong> $this->businessIdentification

					<br>
					<strong>Dirección:</strong> $this->businessAddress

				</div>

			</td>

			<td style='background-color:white; width:140px'>

				<div style='font-size:12px; text-align:right; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong>Teléfono:</strong> $this->businessPhone
					
					<br>
					

				</div>
				
			</td>

		</tr>

	</table>

		");

		echo utf8_decode("
		
		<table>
		
		<tr>
			
			<td style='width:150px; margin-left: 20px'>
				<div style='font-size:12px; text-align: center; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong style='font-size: 20px'>Proveedor</strong>
					
					<br>

				</div>

            </td>

			<td style='background-color:white; width:210px'>
				
				<div style='font-size:12px; text-align:right; line-height:15px;'>
				
					<br>
					<strong>Identificación:</strong> ".$ReportModel[0]->idProveedor."

					<br>
					<strong>Nombre:</strong> ".$ReportModel[0]->nombre."


				</div>

			</td>

			<td style='background-color:white; width:140px'>

				<div style='font-size:12px; text-align:right; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong>Teléfono:</strong> ".$ReportModel[0]->telefono."
					
					<br>
					<strong>Dirección:</strong> ".$ReportModel[0]->direccion."
					

				</div>
				
			</td>

		</tr>

	</table>

		");
		
		echo "<br>";
		echo utf8_decode("<table border='0'> 

		<tr> 
			<td style='font-weight:bold; border:1px solid #eee; width: 50px;'>NÚMERO DE COMPRA</td>
			<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>		
			<td style='font-weight:bold; border:1px solid #eee;'>USUARIO</td>
			<td style='font-weight:bold; border:1px solid #eee;'>PRODUCTOS</td>
			<td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD</td>
			<td style='font-weight:bold; border:1px solid #eee;'>PRECIO PRODUCTO</td>
			<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>			
		</tr>");

		
		$total = 0;
		foreach ($ReportModel as $row => $item){
			$detail = new ReportModel();
			$detail = $detail->getPurchaseDetailReportExcel($item->identificacion);
			
			$totalPurchase = 0;

			echo utf8_decode("<tr>
						<td style='border:1px solid #eee;'>".$item->identificacion."</td>
						<td style='border:1px solid #eee;'>".date('Y-m-d', strtotime($item->fecha))."</td>
						<td style='border:1px solid #eee;'>".$item->usuario."</td>
						<td style='border:1px solid #eee;'>");
			

			foreach($detail as $row){
				echo utf8_decode("<br> $row->nombreProducto $row->ancho_numero/$row->alto_numero $row->categoria Marca $row->marca <br>");
				$totalPurchase += $row->precio * $row->cantidad;
			}
			
			$total += $totalPurchase;

			echo utf8_decode("</td>");
			echo utf8_decode("<td style='border:1px solid #eee;'>");
			foreach($detail as $row){
				echo utf8_decode("<br>".$row->cantidad."<br>");
			}

			echo utf8_decode("</td>");

			echo utf8_decode("<td style='border:1px solid #eee;'>");
			
			foreach($detail as $row){
				
				echo utf8_decode("<br>".$row->precio."<br>");
			}

			echo utf8_decode("</td>");

			echo utf8_decode("
				<td style='border:1px solid #eee;'>".number_format($totalPurchase, 2)."</td>
			</tr>
			");

		}
		echo utf8_decode("<tr>
					<td style='border:1px solid #eee;'></td>
					<td style='border:1px solid #eee;'></td>
					<td style='border:1px solid #eee;'></td>
					<td style='border:1px solid #eee;'></td>
					<td style='border:1px solid #eee;'></td>
					<td style='border:1px solid #eee;'></td>
					<td style='border:1px solid #eee;'>".number_format($total, 2)."</td>
					</tr>");
		
		echo "</table>";
	}

	public function getBestProvidersReportExcel($range = NULL)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ReportModel = new ReportModel();
		$ReportModel = $ReportModel->getBestProviders();

		$name = "reporte-mejores-proveedores.xls";
		$nameHeader = "Mejores proveedores";

		if ( $range != NULL && $range != ''){
			
			if(!empty(explode('a', $range)[1])){
				$from = explode('a', $range)[0];
				$to = explode('a', $range)[1];
				$where = "DATE_FORMAT(compras.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
				$ReportModel = $ReportModel->where($where);
				$name = "reporte-mejores-proveedores-$from-$to.xls";
				$nameHeader = "Desde $from hasta $to";
			}else{
				$where = "DATE_FORMAT(compras.creado_en, '%Y-%m-%d') = '$range'";
				$ReportModel = $ReportModel->where($where);
				$name = "reporte-mejores-proveedores-$range.xls";
				$nameHeader = "Del día $range";
			}

		}

		$ReportModel = $ReportModel->get()->getResult();

		if(!$ReportModel){
			var_dump($ReportModel);
		}


		// header("Pragma: public");
		// header("Expires: 0");
		// header("Content-type: application/x-msdownload");
		// header("Content-Disposition: attachment; filename=$name");
		// header("Pragma: no-cache");
		// header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

		echo utf8_decode("
		
		<table>
			<tr>

				<td style='background-color:white; width:350px'>
					
					<div style='font-size:12px; text-align:left; line-height:15px; margin-left: 20px'>
						
						<br>
						<strong style='font-size: 22px'>Reporte de mejores proveedores</strong>
						<br>
						<strong>$nameHeader</strong>

					</div>

				</td>

				<td style='width:150px;'>
					
				</td>

				<td style='background-color:white; width:140px'>

				
					
				</td>

				<td style='background-color:white; width:140px'>

					<div style='font-size:12px; text-align:right; margin-left: 50px'>
						<br>
						<strong style='font-size: 18px'>Generado:</strong>
						<br>
						". date('d-m-Y H:i') . "

					</div>
					
				</td>

			</tr>
		</table>
		
		");

		echo utf8_decode("
		
		<table>
		
		<tr>
			
			<td style='width:150px; margin-left: 20px'>
				<div style='font-size:12px; text-align: center; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong style='font-size: 20px'>$this->businessName</strong>
					
					<br>

				</div>

            </td>

			<td style='background-color:white; width:210px'>
				
				<div style='font-size:12px; text-align:right; line-height:15px;'>
					
					<br>
					<strong>RIF:</strong> $this->businessIdentification

					<br>
					<strong>Dirección:</strong> $this->businessAddress

				</div>

			</td>

			<td style='background-color:white; width:140px'>

				<div style='font-size:12px; text-align:right; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong>Teléfono:</strong> $this->businessPhone
					
					<br>
					

				</div>
				
			</td>

		</tr>

	</table>

		");
		
		echo "<br>";
		echo utf8_decode("<table border='0'> 

		<tr> 
			<td style='font-weight:bold; border:1px solid #eee;'>IDENTIFICACIÓN</td> 
			<td style='font-weight:bold; border:1px solid #eee;'>NOMBRE</td>
			<td style='font-weight:bold; border:1px solid #eee;'>TELÉFONO</td>		
			<td style='font-weight:bold; border:1px solid #eee;'>DIRECCIÓN</td>		
			<td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD DE PRODUCTOS</td>
			<td style='font-weight:bold; border:1px solid #eee;'>TOTAL PAGADO</td>		
		</tr>");

		$total = 0;

		foreach ($ReportModel as $row => $item){


			echo utf8_decode("<tr>
						<td style='border:1px solid #eee;'>".$item->identificacion."</td>
						<td style='border:1px solid #eee;'>".$item->nombre."</td>
						<td style='border:1px solid #eee;'>".$item->telefono."</td>
						<td style='border:1px solid #eee;'>".$item->direccion."</td>
						<td style='border:1px solid #eee;'>".$item->cantidad."</td>
						<td style='border:1px solid #eee;'>".number_format($item->total, 2)."</td></tr>");
			$total += $item->total;
		}

		echo utf8_decode("<tr>
						<td style='border:1px solid #eee;'></td>
						<td style='border:1px solid #eee;'></td>
						<td style='border:1px solid #eee;'></td>
						<td style='border:1px solid #eee;'></td>
						<td style='border:1px solid #eee;'>Total</td>
						<td style='border:1px solid #eee;'>".number_format($total, 2)."</td></tr>");

		
		echo "</table>";
	}

	public function getMostSelledProductsReportExcel($range = NULL)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ReportModel = new ReportModel();
		$ReportModel = $ReportModel->getMostSelledProducts();

		$name = "reporte-productos-más-vendidos.xls";
		$nameHeader = "Todas los productos más vendidos";

		if ( $range != NULL && $range != ''){
			
			if(!empty(explode('a', $range)[1])){
				$from = explode('a', $range)[0];
				$to = explode('a', $range)[1];
				$where = "DATE_FORMAT(ventas.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
				$ReportModel = $ReportModel->where($where);
				$name = "reporte-productos-más-vendidos-$from-$to.xls";
				$nameHeader = "Desde $from hasta $to";
			}else{
				$where = "DATE_FORMAT(ventas.creado_en, '%Y-%m-%d') = '$range'";
				$ReportModel = $ReportModel->where($where);
				$name = "reporte-productos-más-vendidos-$range.xls";
				$nameHeader = "Del día $range";
			}

		}

		$ReportModel = $ReportModel->get()->getResult();

		if(!$ReportModel){
			return "Error";
		}


		header("Pragma: public");
		header("Expires: 0");
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=$name");
		header("Pragma: no-cache");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

		echo utf8_decode("
		
		<table>
			<tr>

				<td style='background-color:white; width:350px'>
					
					<div style='font-size:12px; text-align:left; line-height:15px; margin-left: 20px'>
						
						<br>
						<strong style='font-size: 22px'>Reporte de productos más vendidos</strong>
						<br>
						<strong>$nameHeader</strong>

					</div>

				</td>

				<td style='width:150px;'>
					
				</td>

				<td style='background-color:white; width:140px'>

				
					
				</td>

				<td style='background-color:white; width:140px'>

					<div style='font-size:12px; text-align:right; margin-left: 50px'>
						<br>
						<strong style='font-size: 18px'>Generado:</strong>
						<br>
						". date('d-m-Y H:i') . "

					</div>
					
				</td>

			</tr>
		</table>
		
		");

		echo utf8_decode("
		
		<table>
		
		<tr>
			
			<td style='width:150px; margin-left: 20px'>
				<div style='font-size:12px; text-align: center; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong style='font-size: 20px'>$this->businessName</strong>
					
					<br>

				</div>

            </td>

			<td style='background-color:white; width:210px'>
				
				<div style='font-size:12px; text-align:right; line-height:15px;'>
					
					<br>
					<strong>RIF:</strong> $this->businessIdentification

					<br>
					<strong>Dirección:</strong> $this->businessAddress

				</div>

			</td>

			<td style='background-color:white; width:140px'>

				<div style='font-size:12px; text-align:right; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong>Teléfono:</strong> $this->businessPhone
					
					<br>
					

				</div>
				
			</td>

		</tr>

	</table>

		");
		
		echo "<br>";
		echo utf8_decode("<table border='0'> 

		<tr> 
			<td style='font-weight:bold; border:1px solid #eee;'>CÓDIGO</td> 
			<td style='font-weight:bold; border:1px solid #eee;'>NOMBRE</td>
			<td style='font-weight:bold; border:1px solid #eee;'>CATEGORÍA</td>
			<td style='font-weight:bold; border:1px solid #eee;'>MARCA</td>			
			<td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD</td>
			<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>		
		</tr>");

		foreach ($ReportModel as $row => $item){


			echo utf8_decode("<tr>
						<td style='border:1px solid #eee;'>".$item->codigo."</td>
						<td style='border:1px solid #eee;'>$item->nombre $item->ancho_numero/$item->alto_numero</td>
						<td style='border:1px solid #eee;'>".$item->categoria."</td>
						<td style='border:1px solid #eee;'>".$item->marca."</td>
						<td style='border:1px solid #eee;'>".$item->cantidad."</td>
						<td style='border:1px solid #eee;'>".number_format($item->total, 2)."</td></tr>");
		}

		
		echo "</table>";
	}

	public function getLessSoldProductsReportExcel($range = NULL)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ReportModel = new ReportModel();
		$ReportModel = $ReportModel->getLessSoldProducts();

		$name = "reporte-productos-menos-vendidos.xls";
		$nameHeader = "Todas los productos menos vendidos";

		if ( $range != NULL && $range != ''){
			
			if(!empty(explode('a', $range)[1])){
				$from = explode('a', $range)[0];
				$to = explode('a', $range)[1];
				$where = "DATE_FORMAT(ventas.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
				$ReportModel = $ReportModel->where($where);
				$name = "reporte-productos-menos-vendidos-$from-$to.xls";
				$nameHeader = "Desde $from hasta $to";
			}else{
				$where = "DATE_FORMAT(ventas.creado_en, '%Y-%m-%d') = '$range'";
				$ReportModel = $ReportModel->where($where);
				$name = "reporte-productos-más-vendidos-$range.xls";
				$nameHeader = "Del día $range";
			}

		}

		$ReportModel = $ReportModel->get()->getResult();

		if(!$ReportModel){
			var_dump($ReportModel);
		}


		header("Pragma: public");
		header("Expires: 0");
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=$name");
		header("Pragma: no-cache");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

		echo utf8_decode("
		
		<table>
			<tr>

				<td style='background-color:white; width:350px'>
					
					<div style='font-size:12px; text-align:left; line-height:15px; margin-left: 20px'>
						
						<br>
						<strong style='font-size: 22px'>Reporte de productos menos vendidos</strong>
						<br>
						<strong>$nameHeader</strong>

					</div>

				</td>

				<td style='width:150px;'>
					
				</td>

				<td style='background-color:white; width:140px'>

				
					
				</td>

				<td style='background-color:white; width:140px'>

					<div style='font-size:12px; text-align:right; margin-left: 50px'>
						<br>
						<strong style='font-size: 18px'>Generado:</strong>
						<br>
						". date('d-m-Y H:i') . "

					</div>
					
				</td>

			</tr>
		</table>
		
		");

		echo utf8_decode("
		
		<table>
		
		<tr>
			
			<td style='width:150px; margin-left: 20px'>
				<div style='font-size:12px; text-align: center; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong style='font-size: 20px'>$this->businessName</strong>
					
					<br>

				</div>

            </td>

			<td style='background-color:white; width:210px'>
				
				<div style='font-size:12px; text-align:right; line-height:15px;'>
					
					<br>
					<strong>RIF:</strong> $this->businessIdentification

					<br>
					<strong>Dirección:</strong> $this->businessAddress

				</div>

			</td>

			<td style='background-color:white; width:140px'>

				<div style='font-size:12px; text-align:right; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong>Teléfono:</strong> $this->businessPhone
					
					<br>
					

				</div>
				
			</td>

		</tr>

	</table>

		");
		
		echo "<br>";
		echo utf8_decode("<table border='0'> 

		<tr> 
			<td style='font-weight:bold; border:1px solid #eee;'>CÓDIGO</td> 
			<td style='font-weight:bold; border:1px solid #eee;'>NOMBRE</td>
			<td style='font-weight:bold; border:1px solid #eee;'>CATEGORÍA</td>
			<td style='font-weight:bold; border:1px solid #eee;'>MARCA</td>			
			<td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD</td>
			<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>		
		</tr>");

		foreach ($ReportModel as $row => $item){


			echo utf8_decode("<tr>
						<td style='border:1px solid #eee;'>".$item->codigo."</td>
						<td style='border:1px solid #eee;'>$item->nombre $item->ancho_numero/$item->alto_numero</td>
						<td style='border:1px solid #eee;'>".$item->categoria."</td>
						<td style='border:1px solid #eee;'>".$item->marca."</td>
						<td style='border:1px solid #eee;'>".$item->cantidad."</td>
						<td style='border:1px solid #eee;'>".number_format($item->total, 2)."</td></tr>");
		}

		
		echo "</table>";
	}

	public function getBestCustomersReportExcel($range = NULL)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ReportModel = new ReportModel();
		$ReportModel = $ReportModel->getBestCustomers();

		$name = "reporte-mejores-clientes.xls";
		$nameHeader = "Mejores clientes";

		if ( $range != NULL && $range != ''){
			
			if(!empty(explode('a', $range)[1])){
				$from = explode('a', $range)[0];
				$to = explode('a', $range)[1];
				$where = "DATE_FORMAT(ventas.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
				$ReportModel = $ReportModel->where($where);
				$name = "reporte-mejores-clientes-$from-$to.xls";
				$nameHeader = "Desde $from hasta $to";
			}else{
				$where = "DATE_FORMAT(ventas.creado_en, '%Y-%m-%d') = '$range'";
				$ReportModel = $ReportModel->where($where);
				$name = "reporte-mejores-clientes-$range.xls";
				$nameHeader = "Del día $range";
			}

		}

		$ReportModel = $ReportModel->get()->getResult();

		if(!$ReportModel){
			var_dump($ReportModel);
		}


		header("Pragma: public");
		header("Expires: 0");
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=$name");
		header("Pragma: no-cache");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

		echo utf8_decode("
		
		<table>
			<tr>

				<td style='background-color:white; width:350px'>
					
					<div style='font-size:12px; text-align:left; line-height:15px; margin-left: 20px'>
						
						<br>
						<strong style='font-size: 22px'>Reporte de mejores clientes</strong>
						<br>
						<strong>$nameHeader</strong>

					</div>

				</td>

				<td style='width:150px;'>
					
				</td>

				<td style='background-color:white; width:140px'>

				
					
				</td>

				<td style='background-color:white; width:140px'>

					<div style='font-size:12px; text-align:right; margin-left: 50px'>
						<br>
						<strong style='font-size: 18px'>Generado:</strong>
						<br>
						". date('d-m-Y H:i') . "

					</div>
					
				</td>

			</tr>
		</table>
		
		");

		echo utf8_decode("
		
		<table>
		
		<tr>
			
			<td style='width:150px; margin-left: 20px'>
				<div style='font-size:12px; text-align: center; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong style='font-size: 20px'>$this->businessName</strong>
					
					<br>

				</div>

            </td>

			<td style='background-color:white; width:210px'>
				
				<div style='font-size:12px; text-align:right; line-height:15px;'>
					
					<br>
					<strong>RIF:</strong> $this->businessIdentification

					<br>
					<strong>Dirección:</strong> $this->businessAddress

				</div>

			</td>

			<td style='background-color:white; width:140px'>

				<div style='font-size:12px; text-align:right; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong>Teléfono:</strong> $this->businessPhone
					
					<br>
					

				</div>
				
			</td>

		</tr>

	</table>

		");
		
		echo "<br>";
		echo utf8_decode("<table border='0'> 

		<tr> 
			<td style='font-weight:bold; border:1px solid #eee;'>IDENTIFICACIÓN</td> 
			<td style='font-weight:bold; border:1px solid #eee;'>NOMBRE</td>
			<td style='font-weight:bold; border:1px solid #eee;'>TELÉFONO</td>		
			<td style='font-weight:bold; border:1px solid #eee;'>DIRECCIÓN</td>		
			<td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD DE PRODUCTOS</td>
			<td style='font-weight:bold; border:1px solid #eee;'>TOTAL PAGADO</td>		
		</tr>");

		foreach ($ReportModel as $row => $item){


			echo utf8_decode("<tr>
						<td style='border:1px solid #eee;'>".$item->identificacion."</td>
						<td style='border:1px solid #eee;'>".$item->nombre."</td>
						<td style='border:1px solid #eee;'>".$item->telefono."</td>
						<td style='border:1px solid #eee;'>".$item->direccion."</td>
						<td style='border:1px solid #eee;'>".$item->cantidad."</td>
						<td style='border:1px solid #eee;'>".number_format($item->total, 2)."</td></tr>");
		}

		
		echo "</table>";
	}
}
