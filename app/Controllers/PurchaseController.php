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
		"user"			=> "",
		"module"		=> "Compras",
		"action"		=> "",
		"description"	=> ""
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
			"provider" 	=> $this->request->getPost('provider'),
			"date" 		=> $this->request->getPost('date'),
			"receipt" 	=> $this->request->getPost('receipt'),
			"reference" => $this->request->getPost('reference'),
			"tax" 		=> $this->request->getPost('tax'),
			"coin" 		=> $this->request->getPost('coin')
		];

		if(strtotime($purchase['date']) > strtotime(date('Y-m-d'))){
			$this->errorMessage['text'] = "La fecha de la compra no puede ser mayor a la fecha actual";
			return sweetAlert($this->errorMessage);
		}

		$productId = $this->request->getPost('productId');
		$productQuantity = $this->request->getPost('productQuantity');
		$productPrice = $this->request->getPost('productPrice');

		$purchaseDetails = [];

		for($i = 0; $i < count($productId); $i++){

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
				"product"	=> $productId[$i],
				"quantity"	=> $productQuantity[$i],
				"price"		=> $price
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
		$auditUserId = $this->session->get('id');
		$this->auditContent['user_id'] 		= $auditUserId;
		$this->auditContent['action'] 		= "Crear compra";
		$this->auditContent['description'] 	= "Se ha creado la compra con ID #" . $PurchaseModel->getLastId() . " exitosamente.";
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
						->table('providers')
						->select('id, code, name, rif')
						->where('deleted_at', NULL);
				
		return DataTable::of($providers)
			->add('Seleccionar', function($row){
				return '<div class="btn-list"> 
							<button type="button" class="btn-select-provider btn btn-sm btn-primary waves-effect" data-id="'.$row->id.'" data-type="providers">
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
						->table('products')
						->select('products.id, code, name, brands.brand, categories.category')
						->join('brands', 'brands.id = products.brand')
						->join('categories', 'categories.id = products.category')
						->where('products.deleted_at', NULL);
				
		return DataTable::of($products)
			->add('Seleccionar', function($row){
				return '<div class="btn-list"> 
							<button type="button" class="btn-select-product btn btn-sm btn-primary waves-effect" data-id="'.$row->id.'" data-type="products">
                                <i class="fas fa-check"></i>
                            </button>
                        </div>';
			}, 'first') 
			->toJson();
	}

	public function getProviderById($id)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ProviderModel = new ProviderModel();
		$provider = $ProviderModel->getProviderById(['id' => $id]);
		if(!$provider){
			return false;
		}
		return json_encode($provider);
	}

	public function updateProvider()
	{
		helper('providerValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(updateProviderValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$id = $this->request->getPost('id');
		$data = [
			"code" 		=> $this->request->getPost('code'),
			"name" 		=> $this->request->getPost('name'),
			"rif" 		=> $this->request->getPost('identification'),
			"address" 	=> $this->request->getPost('address'),
			"phone" 	=> $this->request->getPost('phone'),
			"phone2" 	=> $this->request->getPost('phone2'),
			"type" 		=> $this->request->getPost('providerType')
		];

		$ProviderModel = new ProviderModel();
		$provider = $ProviderModel->updateProvider($data, $id);

		if(!$provider){
			$this->errorMessage['text'] = "Error actualizar al proveedor en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('id');
		$this->auditContent['user_id'] 		= $auditUserId;
		$this->auditContent['action'] 		= "Actualizar proveedor";
		$this->auditContent['description'] 	= "Se ha actualizado al proveedor con ID #" . $id . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "El proveedor se ha actualizado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function deleteProvider()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$id = $this->request->getPost('id');

		$ProviderModel = new ProviderModel();
		$deleteProvider = $ProviderModel->deleteProvider($id);

		if(!$deleteProvider){
			$this->errorMessage['text'] = "El proveedor no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('id');
		$this->auditContent['user_id'] 		= $auditUserId;
		$this->auditContent['action'] 		= "Eliminar proveedor";
		$this->auditContent['description'] 	= "Se ha eliminado al proveedor con ID #" . $id . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "Proveedor eliminado";
		$this->successMessage['text'] 		= "Puede recuperarlo desde la papelera";
		return sweetAlert($this->successMessage);
	}
}
