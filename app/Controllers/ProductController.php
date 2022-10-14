<?php 
namespace App\Controllers;
use App\Models\ProductModel;
use App\Models\AuditModel;
use \Hermawan\DataTables\DataTable;

class ProductController extends BaseController
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
		"module"		=> "Productos",
		"action"		=> "",
		"description"	=> ""
	];

	public function createProduct()
	{
		helper('ProductValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(createProductValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		// Dar formato al precio
		$price = str_replace(',', '', $this->request->getPost('price'));
		$price = floatval($price);	

		$ProductModel = new ProductModel();
		$product = $ProductModel->createProduct([
									'code' 			=> $this->request->getPost('code'),
									'name' 			=> $this->request->getPost('name'),
									'description' 	=> $this->request->getPost('description'),
									'brand' 		=> $this->request->getPost('brand'),
									'category' 		=> $this->request->getPost('category'),
									'coin' 			=> $this->request->getPost('coin'),
									'price' 		=> $price,
									'tax' 			=> $this->request->getPost('tax')
								]);

		if(!$product){
			$this->errorMessage['text'] = "Error al guardar el producto en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('id');
		$this->auditContent['user'] 		= $auditUserId;
		$this->auditContent['action'] 		= "Crear producto";
		$this->auditContent['description'] 	= "Se ha creado el producto con ID #" . $ProductModel->getLastId() . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "El producto se ha creado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function getProducts()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ProductModel = new ProductModel();
				
		return DataTable::of($ProductModel->getProducts())
			->edit('price', function($row){
				$price = number_format($row->price, 2);
				return $row->symbol . $price;
			})
			->hide('symbol')
			->add('Acciones', function($row){
				return '<div class="btn-list"> 
                            <button type="button" class="btnView btn btn-sm btn-primary waves-effect" data-id="'.$row->id.'" data-type="products" data-bs-toggle="modal" data-bs-target="#viewModal">
                                <i class="far fa-eye"></i>
                            </button>
                            <button type="button" class="btnDelete btn btn-sm btn-danger waves-effect" data-id="'.$row->id.'" data-type="products">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>';
			}, 'last') 
			->toJson();
	}

	public function getProductById($id)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ProductModel = new ProductModel();
		$product = $ProductModel->getProductById(['id' => $id]);
		if(!$product){
			return false;
		}
		$product[0]['price'] = number_format($product[0]['price'], 2);
		return json_encode($product);
	}

	public function updateProduct()
	{
		helper('productValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(updateProductValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		// Dar formato al precio
		$price 	= str_replace(',', '', $this->request->getPost('price'));
		$price 	= floatval($price);
		$id 	= $this->request->getPost('id');

		$ProductModel = new ProductModel();
		$product = $ProductModel->updateProduct([
									'code' 			=> $this->request->getPost('code'),
									'name' 			=> $this->request->getPost('name'),
									'description' 	=> $this->request->getPost('description'),
									'brand' 		=> $this->request->getPost('brand'),
									'category' 		=> $this->request->getPost('category'),
									'coin' 			=> $this->request->getPost('coin'),
									'price' 		=> $price,
									'tax' 			=> $this->request->getPost('tax')
								], $id);

		if(!$product){
			$this->errorMessage['text'] = "Error actualizar el producto en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('id');
		$this->auditContent['user'] 		= $auditUserId;
		$this->auditContent['action'] 		= "Actualizar producto";
		$this->auditContent['description'] 	= "Se ha actualizado el producto con ID #" . $id . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "El producto se ha actualizado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function deleteProduct()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$id = $this->request->getPost('id');

		$ProductModel 	= new ProductModel();
		$deleteProduct 	= $ProductModel->deleteProduct($id);

		if(!$deleteProduct){
			$this->errorMessage['text'] = "El producto no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('id');
		$this->auditContent['user'] 		= $auditUserId;
		$this->auditContent['action'] 		= "Eliminar producto";
		$this->auditContent['description'] 	= "Se ha eliminado el producto con ID #" . $id . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "Producto eliminado";
		$this->successMessage['text'] 		= "Puede recuperarlo desde la papelera";
		return sweetAlert($this->successMessage);
	}
}
