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
			->edit('cant_producto', function($row){
							
				if($row->cant_producto <= 5){
					return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-danger text-dark p-2 px-3">'.$row->cant_producto.'</a></div>';
				}
				
				if($row->cant_producto <= 15){
					return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-warning text-dark p-2 px-3">'.$row->cant_producto.'</a></div>';
				}

				return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-success text-dark p-2 px-3">'.$row->cant_producto.'</a></div>';
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
			->hide('codigo')
			->hide('nombre')
			->hide('direccion')
			->hide('telefono')
			->hide('idProveedor')
			->edit('total', function($row){
				
				return number_format($row->total, 2);

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
			->edit('subtotal', function($row){
				return number_format($row->subtotal, 2);
			})
			->add('total_impuesto', function($row){
				return number_format((($row->subtotal*$row->impuesto)/100), 2);
			})
			->add('total', function($row){
				
				return '$ ' . number_format(((($row->subtotal*$row->impuesto)/100)+$row->subtotal), 2);

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
						->select('identificacion, nombre, direccion, telefono, codigo')
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
						->select('productos.codigo, nombre, marcas.marca, categorias.categoria')
						->join('marcas', 'marcas.identificacion = productos.marca')
						->join('categorias', 'categorias.identificacion = productos.categoria')
						->where('productos.estado', 1);
				
		return DataTable::of($products)
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

	public function getPurchaseReportExcel($range)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(empty(explode('a', $range)[1])){
			
			return "Ha ocurrido un error";
		}

		$from = explode('a', $range)[0];
		$to	= explode('a', $range)[1];

		$ReportModel = new ReportModel();
		$getPurchaseReportExcel = $ReportModel->getPurchaseReportExcel($from, $to);

		if(!$getPurchaseReportExcel){
			return "Error";
		}

		$name = "reporte-compras-$from-$to.xls";

		header("Pragma: public");
		header("Expires: 0");
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=$name");
		header("Pragma: no-cache");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

		echo utf8_decode("
		
		<table>
		
		<tr>
			
			<td style='width:150px;'>
                <h2 style='font-size: 20px'>Digenca</h2>
            </td>

			<td style='background-color:white; width:210px'>
				
				<div style='font-size:12px; text-align:right; line-height:15px;'>
					
					<br>
					<strong>RIF:</strong> J-285346256

					<br>
					<strong>Dirección:</strong> Av. Venezuela con calle 37

				</div>

			</td>

			<td style='background-color:white; width:140px'>

				<div style='font-size:12px; text-align:right; line-height:15px; margin-left: 50px'>
					
					<br>
					Teléfono: 04121546367
					
					<br>
					digencacom@example.com

				</div>
				
			</td>

			<td style='background-color:white; width:140px'>

				<div style='font-size:12px; text-align:right; line-height:15px; margin-left: 50px'>
					
					<br>
					Reporte de compras
					
					<br>
					$from a $to

				</div>
				
			</td>

			<td style='background-color:white; width:140px'>

				<div style='font-size:12px; text-align:right; line-height:15px; margin-left: 50px'>
					
					<br>
					Generado
					
					<br>
					". date('Y-m-d H:i:s') . "

				</div>
				
			</td>

		</tr>

	</table>

		");
		
		echo "<br>";

		echo utf8_decode("<table border='0'> 

		<tr> 
			<td style='font-weight:bold; border:1px solid #eee;'>REFERENCIA</td> 
			<td style='font-weight:bold; border:1px solid #eee;'>PROVEEDOR</td>
			<td style='font-weight:bold; border:1px solid #eee;'>USUARIO</td>
			<td style='font-weight:bold; border:1px solid #eee;'>TIPO DE DOCUMENTO</td>
			<td style='font-weight:bold; border:1px solid #eee;'>MONEDA</td>
			<td style='font-weight:bold; border:1px solid #eee;'>CÓDIGO</td>	
			<td style='font-weight:bold; border:1px solid #eee;'>PRODUCTO</td>	
			<td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD</td>
			<td style='font-weight:bold; border:1px solid #eee;'>PRECIO UNITARIO</td>
			<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>			
			<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>		
		</tr>");

			foreach ($getPurchaseReportExcel as $row => $item){


				echo utf8_decode("<tr>
							<td style='border:1px solid #eee;'>".$item->referencia."</td> 
							<td style='border:1px solid #eee;'>".$item->proveedor."</td>
							<td style='border:1px solid #eee;'>".$item->usuario."</td>
							<td style='border:1px solid #eee;'>".$item->tipo_documento."</td>
							<td style='border:1px solid #eee;'>".$item->moneda."</td>
							<td style='border:1px solid #eee;'>");


				$getPurchaseDetailReportExcel = $ReportModel->getPurchaseDetailReportExcel($item->identificacion);

				$total = 0;

				foreach ($getPurchaseDetailReportExcel as $row2 => $item2){

					echo utf8_decode($item2->codigo."<br>");
					$total = $total + ($item2->cantidad * $item2->precio);
				}

				echo utf8_decode("</td><td style='border:1px solid #eee;'>");

				foreach ($getPurchaseDetailReportExcel as $row2 => $item2){

						echo utf8_decode($item2->nombreProducto."<br>");
				}

				echo utf8_decode("</td><td style='border:1px solid #eee;'>");

				foreach ($getPurchaseDetailReportExcel as $row2 => $item2){

						echo utf8_decode($item2->cantidad."<br>");

				}

				echo utf8_decode("</td><td style='border:1px solid #eee;'>");

				foreach ($getPurchaseDetailReportExcel as $row2 => $item2){

					echo utf8_decode($item2->precio."<br>");

				}

			echo utf8_decode("</td>	
					<td style='border:1px solid #eee;'>".number_format($total, 2)."</td>
					<td style='border:1px solid #eee;'>".$item->fecha."</td>		
						</tr>");
		}


			echo "</table>";

	}

	public function getSaleReportExcel($range)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(empty(explode('a', $range)[1])){
			
			return "Ha ocurrido un error";
		}

		$from = explode('a', $range)[0];
		$to	= explode('a', $range)[1];

		$ReportModel = new ReportModel();
		$getSaleReportExcel = $ReportModel->getSaleReportExcel($from, $to);

		if(!$getSaleReportExcel){
			return "Error";
		}

		$name = "reporte-ventas-$from-$to.xls";

		header("Pragma: public");
		header("Expires: 0");
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=$name");
		header("Pragma: no-cache");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

		echo utf8_decode("
		
		<table>
		
		<tr>
			
			<td style='width:150px;'>
                <h2 style='font-size: 20px'>Digenca</h2>
            </td>

			<td style='background-color:white; width:210px'>
				
				<div style='font-size:12px; text-align:right; line-height:15px;'>
					
					<br>
					<strong>RIF:</strong> J-285346256

					<br>
					<strong>Dirección:</strong> Av. Venezuela con calle 37

				</div>

			</td>

			<td style='background-color:white; width:140px'>

				<div style='font-size:12px; text-align:right; line-height:15px; margin-left: 50px'>
					
					<br>
					Teléfono: 04121546367
					
					<br>
					digencacom@example.com

				</div>
				
			</td>
			<td style='background-color:white; width:140px'>

				<div style='font-size:12px; text-align:right; line-height:15px; margin-left: 50px'>
					
					<br>
					Reporte de ventas
					
					<br>
					$from a $to

				</div>
				
			</td>

			<td style='background-color:white; width:140px'>

				<div style='font-size:12px; text-align:right; line-height:15px; margin-left: 50px'>
					
					<br>
					Generado
					
					<br>
					". date('Y-m-d H:i:s') . "

				</div>
				
			</td>

		</tr>

	</table>

		");
		
		echo "<br>";

		echo utf8_decode("<table border='0'> 

		<tr> 
			<td style='font-weight:bold; border:1px solid #eee;'>FACTURA</td> 
			<td style='font-weight:bold; border:1px solid #eee;'>CLIENTE</td>
			<td style='font-weight:bold; border:1px solid #eee;'>VENDEDOR</td>
			<td style='font-weight:bold; border:1px solid #eee;'>TIPO DE DOCUMENTO</td>
			<td style='font-weight:bold; border:1px solid #eee;'>MÉTODO DE PAGO</td>
			<td style='font-weight:bold; border:1px solid #eee;'>MONEDA</td>
			<td style='font-weight:bold; border:1px solid #eee;'>TASA</td>
			<td style='font-weight:bold; border:1px solid #eee;'>IMPUESTO</td>
			<td style='font-weight:bold; border:1px solid #eee;'>CÓDIGO</td>	
			<td style='font-weight:bold; border:1px solid #eee;'>PRODUCTO</td>	
			<td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD</td>
			<td style='font-weight:bold; border:1px solid #eee;'>PRECIO UNITARIO</td>
			<td style='font-weight:bold; border:1px solid #eee;'>SUBTOTAL</td>
			<td style='font-weight:bold; border:1px solid #eee;'>IMPUESTO</td>
			<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>			
			<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>		
		</tr>");

			foreach ($getSaleReportExcel as $row => $item){


				echo utf8_decode("<tr>
							<td style='border:1px solid #eee;'>".$item->identificacion."</td> 
							<td style='border:1px solid #eee;'>".$item->cliente."</td>
							<td style='border:1px solid #eee;'>".$item->usuario."</td>
							<td style='border:1px solid #eee;'>".$item->tipo_documento."</td>
							<td style='border:1px solid #eee;'>".$item->metodo_pago."</td>
							<td style='border:1px solid #eee;'>".$item->moneda."</td>
							<td style='border:1px solid #eee;'>".$item->tasa."</td>
							<td style='border:1px solid #eee;'>".$item->impuesto."</td>
							<td style='border:1px solid #eee;'>");


				$getSaleDetailReportExcel = $ReportModel->getSaleDetailReportExcel($item->identificacion);

				$subtotal = 0;

				foreach ($getSaleDetailReportExcel as $row2 => $item2){

					echo utf8_decode($item2->codigo."<br>");

					$subtotal = $subtotal + ($item2->cantidad * $item2->precio);
				}

				echo utf8_decode("</td><td style='border:1px solid #eee;'>");

				foreach ($getSaleDetailReportExcel as $row2 => $item2){

						echo utf8_decode($item2->nombreProducto."<br>");
				}

				echo utf8_decode("</td><td style='border:1px solid #eee;'>");

				foreach ($getSaleDetailReportExcel as $row2 => $item2){

						echo utf8_decode($item2->cantidad."<br>");

				}

				echo utf8_decode("</td><td style='border:1px solid #eee;'>");

				foreach ($getSaleDetailReportExcel as $row2 => $item2){

					echo utf8_decode($item2->precio."<br>");

				}

				$subtotal = $subtotal * $item->tasa;
				$tax = ($subtotal * $item->impuesto) / 100;
				$total = $subtotal + $tax;

			echo utf8_decode("</td>	
					<td style='border:1px solid #eee;'>".number_format($subtotal, 2)."</td>
					<td style='border:1px solid #eee;'>".number_format($tax, 2)."</td>
					<td style='border:1px solid #eee;'>".number_format($total, 2)."</td>
					<td style='border:1px solid #eee;'>".date('Y-m-d', strtotime($item->fecha))."</td>		
						</tr>");
		}


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
					<strong style='font-size: 20px'>DIGENCA</strong>
					
					<br>

				</div>

            </td>

			<td style='background-color:white; width:210px'>
				
				<div style='font-size:12px; text-align:right; line-height:15px;'>
					
					<br>
					<strong>RIF:</strong> J-285346256

					<br>
					<strong>Dirección:</strong> Av. Venezuela con calle 37

				</div>

			</td>

			<td style='background-color:white; width:140px'>

				<div style='font-size:12px; text-align:right; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong>Teléfono:</strong> 02512736478
					
					<br>
					digencacom@example.com

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
			<td style='font-weight:bold; border:1px solid #eee;'>IMPUESTO</td>
			<td style='font-weight:bold; border:1px solid #eee;'>SUBTOTAL</td>
			<td style='font-weight:bold; border:1px solid #eee;'>TOTAL IMPUESTO</td>
			<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>			
		</tr>");

		$grandSubTotal = 0;
		$grandTax = 0;
		$grandTotal = 0;
		foreach ($ReportModel as $row => $item){

			$tax = ($item->subtotal * $item->impuesto) / 100;
			$total = $item->subtotal + $tax;
			$grandSubTotal += $item->subtotal;
			$grandTax += $tax;
			$grandTotal += $total;

			echo utf8_decode("<tr>
						<td style='border:1px solid #eee;'>".$item->identificacion."</td>
						<td style='border:1px solid #eee;'>".date('Y-m-d', strtotime($item->fecha))."</td>
						<td style='border:1px solid #eee;'>".$item->usuario."</td>
						<td style='border:1px solid #eee;'>".$item->impuesto."</td>
						<td style='border:1px solid #eee;'>".$item->subtotal."</td>
						<td style='border:1px solid #eee;'>".number_format($tax, 2)."</td>
						<td style='border:1px solid #eee;'>".number_format($total, 2)."</td>
						</tr>");

		}
		echo utf8_decode("<tr>
					<td style='border:1px solid #eee;'></td>
					<td style='border:1px solid #eee;'></td> 
					<td style='border:1px solid #eee;'></td>
					<td style='border:1px solid #eee;'></td>
					<td style='border:1px solid #eee;'></td>
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
					<strong style='font-size: 20px'>DIGENCA</strong>
					
					<br>

				</div>

            </td>

			<td style='background-color:white; width:210px'>
				
				<div style='font-size:12px; text-align:right; line-height:15px;'>
					
					<br>
					<strong>RIF:</strong> J-285346256

					<br>
					<strong>Dirección:</strong> Av. Venezuela con calle 37

				</div>

			</td>

			<td style='background-color:white; width:140px'>

				<div style='font-size:12px; text-align:right; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong>Teléfono:</strong> 02512736478
					
					<br>
					digencacom@example.com

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
					<strong>Descripción:</strong> ".$ReportModel[0]->producto."


				</div>

			</td>

			<td style='background-color:white; width:140px'>

				<div style='font-size:12px; text-align:right; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong>Categoría:</strong> ".$ReportModel[0]->categoria."
					
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
				$name = "reporte-compras-por-cliente-$from-$to.xls";
				$nameHeader = "Desde $from hasta $to";
			}else{
				$where = "DATE_FORMAT(compras.creado_en, '%Y-%m-%d') = '$range'";
				$ReportModel = $ReportModel->where($where);
				$name = "reporte-compras-por-cliente-$range.xls";
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
					<strong style='font-size: 20px'>DIGENCA</strong>
					
					<br>

				</div>

            </td>

			<td style='background-color:white; width:210px'>
				
				<div style='font-size:12px; text-align:right; line-height:15px;'>
					
					<br>
					<strong>RIF:</strong> J-285346256

					<br>
					<strong>Dirección:</strong> Av. Venezuela con calle 37

				</div>

			</td>

			<td style='background-color:white; width:140px'>

				<div style='font-size:12px; text-align:right; line-height:15px; margin-left: 50px'>
					
					<br>
					<strong>Teléfono:</strong> 02512736478
					
					<br>
					digencacom@example.com

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
			<td style='font-weight:bold; border:1px solid #eee; width: 50px;'>FACTURA</td> 
			<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>		
			<td style='font-weight:bold; border:1px solid #eee;'>USUARIO</td>
			<td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD</td>
			<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>			
		</tr>");

		$grandTotal = 0;
		foreach ($ReportModel as $row => $item){

			$grandTotal += $item->total;

			echo utf8_decode("<tr>
						<td style='border:1px solid #eee;'>".$item->identificacion."</td>
						<td style='border:1px solid #eee;'>".date('Y-m-d', strtotime($item->fecha))."</td>
						<td style='border:1px solid #eee;'>".$item->usuario."</td>
						<td style='border:1px solid #eee;'>".$item->cantidad."</td>
						<td style='border:1px solid #eee;'>".number_format($item->total, 2)."</td>
						</tr>");

		}
		echo utf8_decode("<tr>
					<td style='border:1px solid #eee;'></td>
					<td style='border:1px solid #eee;'></td>
					<td style='border:1px solid #eee;'></td>
					<td style='border:1px solid #eee;'></td>
					<td style='border:1px solid #eee;'>".number_format($grandTotal, 2)."</td>
					</tr>");
		
		echo "</table>";
	}
}
