<?php 
namespace App\Controllers;
use App\Models\CategoryModel;
use App\Models\AuditModel;
use \Hermawan\DataTables\DataTable;

class CategoryController extends BaseController
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
		"modulo"		=> "Categorías",
		"accion"		=> "",
		"descripcion"	=> ""
	];

	public function createCategory()
	{
		helper('categoryValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(createCategoryValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$name = $this->request->getPost('name');

		$CategoryModel = new CategoryModel();
		$category = $CategoryModel->createCategory(['categoria' => $name]);

		if(!$category){
			$this->errorMessage['text'] = "Error al guardar la categoría en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Crear categoría";
		$this->auditContent['descripcion'] 	= "Se ha creado la categoría con identificación #" . $CategoryModel->getLastId() . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "La categoría se ha creado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function getCategories()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$CategoryModel = new CategoryModel();
				
		return DataTable::of($CategoryModel->getCategories())
			->edit('estado', function($row){
									
				if($row->estado == 0){
					return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-danger text-danger p-2 px-3">Desactivado</a></div>';
				}

				return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-success text-success p-2 px-3">Activado</a></div>';
			})
			->add('Acciones', function($row){
				if($row->estado == 1){
					return '<div class="btn-list"> 
								<button type="button" class="btnView btn btn-sm btn-primary waves-effect" data-id="'.$row->identificacion.'" data-type="categories" data-bs-toggle="modal" data-bs-target="#viewModal">
									<i class="far fa-eye"></i>
								</button>
								<button type="button" class="btnDelete btn btn-sm btn-danger waves-effect" data-id="'.$row->identificacion.'" data-type="categories">
									<i class="far fa-trash-alt"></i>
								</button>
							</div>';
				}

				return '<div class="btn-list"> 
								<button type="button" class="btnRecover btn btn-sm btn-success waves-effect" data-id="'.$row->identificacion.'" data-type="categories">
									<i class="fas fa-check"></i>
								</button>
							</div>';

			}, 'last') 
			->filter(function ($builder, $request) {
		
				if ($request->status == ''){
					return true;
				}
				
				return $builder->where('estado', $request->status);
		
			})
			->toJson();
	}

	public function getCategoryById($identification)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$CategoryModel = new CategoryModel();
		$category = $CategoryModel->getCategoryById(['identificacion' => $identification]);
		if(!$category){
			return false;
		}
		return json_encode($category);
	}

	public function updateCategory()
	{
		helper('categoryValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(updateCategoryValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$identification = $this->request->getPost('identification');
		$name = $this->request->getPost('name');

		$CategoryModel = new CategoryModel();
		$category = $CategoryModel->updateCategory($name, $identification);

		if(!$category){
			$this->errorMessage['text'] = "Error actualizar la categoría en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Actualizar categoría";
		$this->auditContent['descripcion'] 	= "Se ha actualizado la categoría con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "La categoría se ha actualizado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function deleteCategory()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$identification = $this->request->getPost('identification');

		$CategoryModel = new CategoryModel();
		$deleteCategory = $CategoryModel->deleteCategory($identification);

		if(!$deleteCategory){
			$this->errorMessage['text'] = "La categoría no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Eliminar categoría";
		$this->auditContent['descripcion'] 	= "Se ha eliminado la categoría con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "Categoría eliminada";
		$this->successMessage['text'] 		= "Puede recuperarla desde la papelera";
		return sweetAlert($this->successMessage);
	}

	public function recoverCategory()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$identification = $this->request->getPost('identification');

		$CategoryModel = new CategoryModel();
		$recoverCategory = $CategoryModel->recoverCategory($identification);

		if(!$recoverCategory){
			$this->errorMessage['text'] = "La categoría no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Recuperar categoría";
		$this->auditContent['descripcion'] 	= "Se ha recuperado la categoría con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "¡Exito!";
		$this->successMessage['text'] 		= "La categoría ha sido recuperada";
		return sweetAlert($this->successMessage);
	}
}
