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
		"modulo"		=> "Productos",
		"accion"		=> "",
		"descripcion"	=> ""
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
		
		if(!is_numeric($price)) {
			$this->errorMessage['text'] = "Por favor introduce un precio válido";
			return sweetAlert($this->errorMessage);
		}
		
		$price = floatval($price);

		$ProductModel = new ProductModel();
		$product = $ProductModel->createProduct([
									'codigo' 			=> $this->request->getPost('code'),
									'nombre' 			=> $this->request->getPost('name'),
									'id_ancho_caucho' 	=> $this->request->getPost('wide'),
									'id_alto_caucho' 	=> $this->request->getPost('high'),
									'marca' 			=> $this->request->getPost('brand'),
									'categoria' 		=> $this->request->getPost('category'),
									'precio' 			=> $price
								]);

		if(!$product){
			$this->errorMessage['text'] = "Error al guardar el producto en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Crear producto";
		$this->auditContent['descripcion'] 	= "Se ha creado el producto con código " . $this->request->getPost('code') . " exitosamente.";
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
			->edit('precio', function($row){
				$price = number_format($row->precio, 2);
				return $this->symbol . $price;
			})
			->hide('ancho_numero')
			->hide('alto_numero')
			->edit('nombre', function($row){
				return "$row->nombre $row->ancho_numero/$row->alto_numero";
			})
			->edit('estado', function($row){
						
				if($row->estado == 0){
					return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-danger text-danger p-2 px-3">Desactivado</a></div>';
				}

				return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-success text-success p-2 px-3">Activado</a></div>';
			})
			->add('Acciones', function($row){
				if($row->estado == 1){
					return '<div class="btn-list"> 
								<button type="button" class="btnView btn btn-sm btn-primary waves-effect" data-id="'.$row->codigo.'" data-type="products" data-bs-toggle="modal" data-bs-target="#viewModal">
									<i class="far fa-eye"></i>
								</button>
								<button type="button" class="btnDelete btn btn-sm btn-danger waves-effect" data-id="'.$row->codigo.'" data-type="products">
									<i class="far fa-trash-alt"></i>
								</button>
							</div>';
				}

				return '<div class="btn-list"> 
								<button type="button" class="btnRecover btn btn-sm btn-success waves-effect" data-id="'.$row->codigo.'" data-type="products">
									<i class="fas fa-check"></i>
								</button>
							</div>';

			}, 'last') 
			->filter(function ($builder, $request) {
		
				if($request->range != ''){

					if(!empty(explode(' a ', $request->range)[1])){
						$from = explode(' a ', $request->range)[0];
						$to = explode(' a ', $request->range)[1];
						$where = "DATE_FORMAT(productos.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
						$builder->where($where);
					}else{
						$where = "DATE_FORMAT(productos.creado_en, '%Y-%m-%d') = '$request->range'";
						$builder->where($where);
					}
					
				}

				if($request->status != ''){
					$builder->where('productos.estado', $request->status);
				}
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

	public function getProductById($code)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ProductModel = new ProductModel();
		$product = $ProductModel->getProductById(['codigo' => $code]);
		if(!$product){
			return false;
		}
		$product[0]['precio'] = number_format($product[0]['precio'], 2);

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
		
		if(!is_numeric($price)) {
			$this->errorMessage['text'] = "Por favor introduce un precio válido";
			return sweetAlert($this->errorMessage);
		}
		
		$price 	= floatval($price);
		$code 	= $this->request->getPost('code');

		$ProductModel = new ProductModel();
		$product = $ProductModel->updateProduct([
									'nombre' 			=> $this->request->getPost('name'),
									'id_ancho_caucho' 	=> $this->request->getPost('wide'),
									'id_alto_caucho' 	=> $this->request->getPost('high'),
									'marca' 			=> $this->request->getPost('brand'),
									'categoria' 		=> $this->request->getPost('category'),
									'precio' 			=> $price
								], $code);

		if(!$product){
			$this->errorMessage['text'] = "Error actualizar el producto en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Actualizar producto";
		$this->auditContent['descripcion'] 	= "Se ha actualizado el producto con código " . $code . " exitosamente.";
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

		$code = $this->request->getPost('identification');

		$ProductModel 	= new ProductModel();
		$deleteProduct 	= $ProductModel->deleteProduct($code);

		if(!$deleteProduct){
			$this->errorMessage['text'] = "El producto no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Eliminar producto";
		$this->auditContent['descripcion'] 	= "Se ha eliminado el producto con código " . $code . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "Producto eliminado";
		$this->successMessage['text'] 		= "Puede recuperarlo desde la papelera";
		return sweetAlert($this->successMessage);
	}

	public function recoverProduct()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$code = $this->request->getPost('identification');

		$ProductModel = new ProductModel();
		$recoverProduct = $ProductModel->recoverProduct($code);

		if(!$recoverProduct){
			$this->errorMessage['text'] = "El producto no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Recuperar producto";
		$this->auditContent['descripcion'] 	= "Se ha recuperado al producto con código " . $code . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "¡Exito!";
		$this->successMessage['text'] 		= "El producto ha sido recuperado";
		return sweetAlert($this->successMessage);
	}
}
