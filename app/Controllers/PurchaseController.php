<?php 
namespace App\Controllers;
use App\Models\PurchaseModel;
use App\Models\AuditModel;
use \Hermawan\DataTables\DataTable;

class PurchaseController extends BaseController
{
	protected $errorMessage = [
		"alert" => "simple",
		"type" => "error",
		"title" => "¡Oops!",
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
		"modulo"		=> "Compras",
		"accion"		=> "",
		"descripcion"	=> ""
	];

	public function createPurchase()
	{
		helper('purchaseValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(createPurchaseValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$purchase = [
			"proveedor" 	=> $this->request->getPost('provider'),
			"usuario" 		=> $this->session->get('identification'),
			"fecha" 		=> $this->request->getPost('date'),
			"tipo_documento"=> $this->request->getPost('receipt'),
			"referencia" => $this->request->getPost('reference'),
			"moneda" 		=> $this->request->getPost('coin')
		];

		if(strtotime($purchase['fecha']) > strtotime(date('Y-m-d'))){
			$this->errorMessage['text'] = "La fecha de la compra no puede ser mayor a la fecha actual";
			return sweetAlert($this->errorMessage);
		}

		$productCode = $this->request->getPost('productCode');
		$productQuantity = $this->request->getPost('productQuantity');
		$productPrice = $this->request->getPost('productPrice');

		$purchaseDetails = [];

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
				"producto"	=> $productCode[$i],
				"cantidad"	=> $productQuantity[$i],
				"precio"		=> $price
			];

			array_push($purchaseDetails, $data);

		}
		
		$PurchaseModel = new PurchaseModel();
		$purchase = $PurchaseModel->createPurchase($purchase, $purchaseDetails);

		if(!$purchase){
			$this->errorMessage['text'] = "Error al registrar la compra, intenta nuevamente.";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Crear compra";
		$this->auditContent['descripcion'] 	= "Se ha creado la compra con identificacion " . $purchase . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "La compra se ha registrado correctamente";
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
						->select('codigo, nombre, identificacion')
						->where('estado', 1);
				
		return DataTable::of($providers)
			->add('Seleccionar', function($row){
				return '<div class="btn-list"> 
							<button type="button" class="btn-select-provider btn btn-sm btn-primary waves-effect" data-id="'.$row->codigo.'" data-type="providers">
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

	public function getPurchases()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$PurchaseModel = new PurchaseModel();
				
		return DataTable::of($PurchaseModel->getPurchases())
			->edit('estado', function($row){
						
				if($row->estado == 0){
					return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-danger text-danger p-2 px-3">Desactivado</a></div>';
				}

				return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-success text-success p-2 px-3">Activado</a></div>';
			})
			->add('Acciones', function($row){
				if($row->estado == 1){
					return '<div class="btn-list"> 
								<button type="button" class="btnView btn btn-sm btn-primary waves-effect" data-id="'.$row->identificacion.'" data-type="purchases" data-bs-toggle="modal" data-bs-target="#viewModal">
									<i class="far fa-eye"></i>
								</button>
								<button type="button" class="btnDelete btn btn-sm btn-danger waves-effect" data-id="'.$row->identificacion.'" data-type="purchases">
									<i class="far fa-trash-alt"></i>
								</button>
							</div>';
				}

				return '<div class="btn-list"> 
								<button type="button" class="btnRecover btn btn-sm btn-success waves-effect" data-id="'.$row->identificacion.'" data-type="purchases">
									<i class="fas fa-check"></i>
								</button>
							</div>';

			}, 'last') 
			->filter(function ($builder, $request) {
		
				if ($request->status == ''){
					return true;
				}
				
				return $builder->where('compras.estado', $request->status);
		
			})
			->toJson();
	}

	public function getPurchaseById($identification)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$PurchaseModel = new PurchaseModel();
		$purchase = $PurchaseModel->getPurchaseById(['compras.identificacion' => $identification]);
		if(!$purchase){
			return false;
		}
		return json_encode($purchase);
	}

	public function updatePurchase()
	{
		helper('purchaseValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(updatePurchaseValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$identification = $this->request->getPost('identification');
		$purchase = [
			"proveedor" 	=> $this->request->getPost('provider'),
			"fecha" 		=> $this->request->getPost('date'),
			"tipo_documento"=> $this->request->getPost('receipt'),
			"referencia" => $this->request->getPost('reference'),
			"moneda" 		=> $this->request->getPost('coin'),
			"actualizado_en" => date("Y-m-d H:i:s")
		];

		if(strtotime($purchase['fecha']) > strtotime(date('Y-m-d'))){
			$this->errorMessage['text'] = "La fecha de la compra no puede ser mayor a la fecha actual";
			return sweetAlert($this->errorMessage);
		}
		
		$purchaseDetailsId = $this->request->getPost('purchaseDetailsId');
		$productCode = $this->request->getPost('productCode');
		$productQuantity = $this->request->getPost('productQuantity');
		$productPrice = $this->request->getPost('productPrice');

		$purchaseDetails = [];

		for($i = 0; $i < count($productCode); $i++){

			$price = str_replace(',', '', $productPrice[$i]);
			$price = floatval($price);

			if($productQuantity[$i] <= 0){
				$this->errorMessage['text'] = "La cantidad tiene que ser mayor a 0, por favor revisa la fila #$productId[$i]";
				return sweetAlert($this->errorMessage);
			}

			if($price <= 0){
				$this->errorMessage['text'] = "El precio tiene que ser mayor a 0, por favor revisa la fila #$productId[$i]";
				return sweetAlert($this->errorMessage);
			}

			$data = [
				"identificacion"=> $purchaseDetailsId[$i],
				"producto"	=> $productCode[$i],
				"cantidad"	=> $productQuantity[$i],
				"precio"	=> $price,
				"compra" 	=> $identification
			];

			array_push($purchaseDetails, $data);

		}

		$PurchaseModel = new PurchaseModel();
		$purchase = $PurchaseModel->updatePurchase($purchase, $purchaseDetails, $identification);

		if(!$purchase){
			$this->errorMessage['text'] = "Error al actualizar la compra en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Actualizar compra";
		$this->auditContent['descripcion'] 	= "Se ha actualizado la compra con identificación" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "La compra se ha actualizado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function deletePurchase()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$identification = $this->request->getPost('identification');

		$PurchaseModel = new PurchaseModel();
		$deletePurchase = $PurchaseModel->deletePurchase($identification);

		if(!$deletePurchase){
			$this->errorMessage['text'] = "La compra no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Eliminar compra";
		$this->auditContent['descripcion'] 	= "Se ha eliminado la compra con identificación" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "Compra eliminada";
		$this->successMessage['text'] 		= "Puede recuperarlo desde la papelera";
		return sweetAlert($this->successMessage);
	}

	public function recoverPurchase()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$identification = $this->request->getPost('identification');

		$PurchaseModel = new PurchaseModel();
		$recoverPurchase = $PurchaseModel->recoverPurchase($identification);

		if(!$recoverPurchase){
			$this->errorMessage['text'] = "La compra no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Recuperar compra";
		$this->auditContent['descripcion'] 	= "Se ha recuperado la compra con identificación " . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "¡Exito!";
		$this->successMessage['text'] 		= "La compra ha sido recuperado";
		return sweetAlert($this->successMessage);
	}
}
