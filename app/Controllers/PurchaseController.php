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
				"precio"	=> $price
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
			->hide('simbolo')
			->edit('estado', function($row){
						
				if($row->estado == 0){
					return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-danger text-danger p-2 px-3">Anulada</a></div>';
				}

				return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-success text-success p-2 px-3">Procesada</a></div>';
			})
			->add('total', function($row){
				$db      	= \Config\Database::connect();
				$db 		= $db
								->table('detalle_compra')
								->select('SUM(precio*cantidad) as total')
								->where('compra', $row->identificacion)
								->get()->getResultArray();

				$total = number_format($db[0]['total'], 2);
				return "$row->simbolo $total";
				
			})
			->add('Acciones', function($row){
				if($row->estado == 1){
					return '<div class="btn-list"> 
								<button type="button" class="btnView btn btn-sm btn-primary waves-effect" data-id="'.$row->identificacion.'" data-type="purchases" data-bs-toggle="modal" data-bs-target="#viewModal">
									<i class="far fa-eye"></i>
								</button>
								<button type="button" class="btnDelete btn btn-sm btn-danger waves-effect" data-id="'.$row->identificacion.'" data-type="purchases">
									<i class="fas fa-times"></i>
								</button>
							</div>';
				}

				return '<div class="btn-list"> 
							<button type="button" class="btnView btn btn-sm btn-primary waves-effect" data-id="'.$row->identificacion.'" data-type="purchases" data-bs-toggle="modal" data-bs-target="#viewModal">
								<i class="far fa-eye"></i>
							</button>
						</div>';

			}, 'last') 
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

				if($request->status != ''){
					$builder->where('compras.estado', $request->status);
				}
		
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
		$this->auditContent['descripcion'] 	= "Se ha eliminado la compra con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "La compra ha sido anulada";
		return sweetAlert($this->successMessage);
	}

}
