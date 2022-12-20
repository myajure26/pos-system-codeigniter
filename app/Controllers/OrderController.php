<?php 
namespace App\Controllers;
use App\Models\OrderModel;
use App\Models\AuditModel;
use \Hermawan\DataTables\DataTable;

class OrderController extends BaseController
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
		"modulo"		=> "Pedidos",
		"accion"		=> "",
		"descripcion"	=> ""
	];

	public function createOrder()
	{
		helper('orderValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(createOrderValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$order = [
			"ci_rif_proveedor" 	=> $this->request->getPost('provider'),
			"ci_usuario" 		=> $this->session->get('identification'),
			"id_tipo_documento" => $this->request->getPost('receipt'),
			"id_moneda"			=> $this->request->getPost('coin')
		];

		$productCode = $this->request->getPost('productCode');
		$productQuantity = $this->request->getPost('productQuantity');
		$productPrice = $this->request->getPost('productPrice');

		$orderDetails = [];

		for($i = 0; $i < count($productCode); $i++){

			$price = str_replace(',', '', $productPrice[$i]);
			$price = floatval($price);

			if($productQuantity[$i] <= 0){
				$this->errorMessage['text'] = "La cantidad tiene que ser mayor a 0, por favor revisa la fila #$productCode[$i]";
				return sweetAlert($this->errorMessage);
			}

			if($price <= 0){
				$this->errorMessage['text'] = "El precio tiene que ser mayor a 0, por favor revisa la fila #$productCode[$i]";
				return sweetAlert($this->errorMessage);
			}

			$data = [
				"cod_producto"		=> $productCode[$i],
				"cant_producto"		=> $productQuantity[$i],
				"precio_producto"	=> $price
			];

			array_push($orderDetails, $data);

		}
		
		$OrderModel = new OrderModel();
		$order = $OrderModel->createOrder($order, $orderDetails);

		if(!$order){
			$this->errorMessage['text'] = "Error al registrar el pedido, intenta nuevamente.";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Crear pedido";
		$this->auditContent['descripcion'] 	= "Se ha creado el pedido con identificacion #" . $order . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "El pedido se ha registrado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function getProviders()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$db      	= \Config\Database::connect();
		$providers 	= $db
						->table('proveedores')
						->select('identificacion, nombre, telefono, direccion')
						->where('estado', 1);
				
		return DataTable::of($providers)
			->add('Seleccionar', function($row){
				return '<div class="btn-list"> 
							<button type="button" class="btn-select-provider btn-select-provider-assign-order btn btn-sm btn-primary waves-effect" data-id="'.$row->identificacion.'" data-type="providers">
                                <i class="fas fa-check"></i>
                            </button>
                        </div>';
			}, 'first') 
			->toJson();
	}

	public function getProducts()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$db = \Config\Database::connect();
		$products = $db
			->table('producto_proveedor')
			->select('productos.codigo, productos.nombre, ancho_caucho.ancho_numero, alto_caucho.alto_numero, categorias.categoria, marcas.marca, cant_producto as cantidad, stock_maximo')
			->join('proveedores', 'proveedores.identificacion = producto_proveedor.ci_rif_proveedor')
			->join('productos', 'productos.codigo = producto_proveedor.cod_producto')
			->join('ancho_caucho', 'ancho_caucho.id_ancho_caucho = productos.id_ancho_caucho')
			->join('alto_caucho', 'alto_caucho.id_alto_caucho = productos.id_alto_caucho')
			->join('marcas', 'marcas.identificacion = productos.marca')
			->join('categorias', 'categorias.identificacion = productos.categoria')
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
			->filter(function ($builder, $request) {

				if($request->provider != ''){
					$builder->where('producto_proveedor.ci_rif_proveedor', $request->provider);
				}
		
			})
			->toJson();
	}

	public function getOrders()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$OrderModel = new OrderModel();
				
		return DataTable::of($OrderModel->getOrders())
			->hide('simbolo')
			->edit('estado_pedido', function($row){
						
				if($row->estado_pedido == 0){
					return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-danger text-danger p-2 px-3">Anulado</a></div>';
				}

				if($row->estado_pedido == 2){
					return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-warning text-warning p-2 px-3">Pendiente</a></div>';
				}

				return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-success text-success p-2 px-3">Procesado</a></div>';
			})
			->edit('fecha', function($row){
				return date('m-d-Y H:i:s', strtotime($row->fecha));
			})
			->add('total', function($row){
				$db      	= \Config\Database::connect();
				$db 		= $db
								->table('detalle_pedido')
								->select('SUM(precio_producto*cant_producto) as total')
								->where('id_pedido', $row->id_pedido)
								->get()->getResultArray();

				$total = number_format($db[0]['total'], 2);
				return "$row->simbolo $total";
				
			})
			->add('Acciones', function($row){
				if($row->estado_pedido == 1){
					return '<div class="btn-list"> 
								<button type="button" class="btnPrint btn btn-sm btn-primary waves-effect" data-id="'.$row->id_pedido.'" data-type="orders"> 
									<i class="fa fa-print"></i>
								</button> 
							</div>';
				}

				if($row->estado_pedido == 2){
					return '<div class="btn-list"> 
								<button type="button" class="btnView btn btn-sm btn-primary waves-effect" data-id="'.$row->id_pedido.'" data-type="orders" data-bs-toggle="modal" data-bs-target="#viewModal">
									<i class="far fa-eye"></i>
								</button>
								<button type="button" class="acceptOrder btn btn-sm btn-success waves-effect" data-id="'.$row->id_pedido.'" data-type="orders">
									<i class="fas fa-check"></i>
								</button>
								<button type="button" class="btnPrint btn btn-sm btn-primary waves-effect" data-id="'.$row->id_pedido.'" data-type="orders"> 
									<i class="fa fa-print"></i>
								</button> 
								<button type="button" class="btnDelete btn btn-sm btn-danger waves-effect" data-id="'.$row->id_pedido.'" data-type="orders">
									<i class="fas fa-times"></i>
								</button>
							</div>';
				}

				return '<div class="btn-list"> 
							<button type="button" class="btnPrint btn btn-sm btn-primary waves-effect" data-id="'.$row->id_pedido.'" data-type="orders"> 
								<i class="fa fa-print"></i>
							</button> 
						</div>';

			}, 'last') 
			->filter(function ($builder, $request) {
		
				if($request->range != ''){

					if(!empty(explode(' a ', $request->range)[1])){
						$from = explode(' a ', $request->range)[0];
						$to = explode(' a ', $request->range)[1];
						$where = "DATE_FORMAT(pedido.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
						$builder->where($where);
					}else{
						$where = "DATE_FORMAT(pedido.creado_en, '%Y-%m-%d') = '$request->range'";
						$builder->where($where);
					}
					
				}

				if($request->status != ''){
					$builder->where('pedido.estado_pedido', $request->status);
				}
		
			})
			->toJson();
	}

	public function getOrderById($identification)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$OrderModel = new OrderModel();
		$order = $OrderModel->getOrderById(['pedido.id_pedido' => $identification]);
		if(!$order){
			return false;
		}

		return json_encode($order);
	}

	public function acceptOrder()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$order = $this->request->getPost('order');

		$acceptOrder = new OrderModel();
		$acceptOrder = $acceptOrder->acceptOrder($order);

		if( $acceptOrder == 'empty' ){

			return 'empty';

		}

		if( !$acceptOrder ){

			return false;

		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Aceptar pedido";
		$this->auditContent['descripcion'] 	= "Se ha aceptado el pedido con identificacion " . $order . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "El pedido se ha aceptado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function deleteProductOrder()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}
		
		$order = $this->request->getPost('order');
		$product = $this->request->getPost('product');

		$deleteProductOrder = new OrderModel();
		$deleteProductOrder = $deleteProductOrder->deleteProductOrder($order, $product);

		if( !$deleteProductOrder ){
			return false;
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Eliminar producto del pedido";
		$this->auditContent['descripcion'] 	= "Se ha eliminado el producto ". $product ." del pedido #" . $order . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);

	}

	public function updateOrder()
	{
		helper('orderValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(updateOrderValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$identification = $this->request->getPost('identification');

		$order = [
			"id_tipo_documento" => $this->request->getPost('receipt'),
			"id_moneda"			=> $this->request->getPost('coin')
		];

		$orderId = $this->request->getPost('orderId');
		$productCode = $this->request->getPost('productCode');
		$productQuantity = $this->request->getPost('productQuantity');
		$productPrice = $this->request->getPost('productPrice');

		$orderDetails = [];

		for($i = 0; $i < count($productCode); $i++){

			$price = str_replace(',', '', $productPrice[$i]);
			$price = floatval($price);

			if($productQuantity[$i] <= 0){
				$this->errorMessage['text'] = "La cantidad tiene que ser mayor a 0, por favor revisa la fila #$productCode[$i]";
				return sweetAlert($this->errorMessage);
			}

			if($price <= 0){
				$this->errorMessage['text'] = "El precio tiene que ser mayor a 0, por favor revisa la fila #$productCode[$i]";
				return sweetAlert($this->errorMessage);
			}

			$data = [
				"id_detalle_pedido"	=> $orderId[$i],
				"cod_producto"		=> $productCode[$i],
				"cant_producto"		=> $productQuantity[$i],
				"precio_producto"	=> $price
			];

			array_push($orderDetails, $data);

		}
		
		$OrderModel = new OrderModel();
		$order = $OrderModel->updateOrder($order, $orderDetails, $identification);

		if(!$order){
			$this->errorMessage['text'] = "Error al guardar el pedido, intenta nuevamente.";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Actualizar pedido";
		$this->auditContent['descripcion'] 	= "Se ha actualizado el pedido con identificacion #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "El pedido se ha registrado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function deleteOrder()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$identification = $this->request->getPost('identification');

		$OrderModel = new OrderModel();
		$deleteOrder = $OrderModel->deleteOrder($identification);

		if(!$deleteOrder){
			$this->errorMessage['text'] = "La pedido no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Eliminar pedido";
		$this->auditContent['descripcion'] 	= "Se ha anulado la pedido con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "El pedido ha sido anulado";
		return sweetAlert($this->successMessage);
	}

}
