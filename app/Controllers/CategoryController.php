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
		"user"			=> "",
		"module"		=> "Categorías",
		"action"		=> "",
		"description"	=> ""
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
		$category = $CategoryModel->createCategory(['category' => $name]);

		if(!$category){
			$this->errorMessage['text'] = "Error al guardar la categoría en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('id');
		$this->auditContent['user_id'] 		= $auditUserId;
		$this->auditContent['action'] 		= "Crear categoría";
		$this->auditContent['description'] 	= "Se ha creado la categoría con ID #" . $CategoryModel->getLastId() . " exitosamente.";
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
			->add('Acciones', function($row){
				return '<div class="btn-list"> 
                            <button type="button" class="btnUpdate btn btn-sm btn-primary waves-effect" data-id="'.$row->id.'" data-type="categories" data-bs-toggle="modal" data-bs-target="#updateModal">
                                <i class="far fa-edit"></i>
                            </button>
                            <button type="button" class="btnDelete btn btn-sm btn-danger waves-effect" data-id="'.$row->id.'" data-type="categories">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>';
			}, 'last') 
			->toJson();
	}

	public function getCategoryById($id)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$CategoryModel = new CategoryModel();
		$category = $CategoryModel->getCategoryById(['id' => $id]);
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

		$id = $this->request->getPost('id');
		$name = $this->request->getPost('name');

		$CategoryModel = new CategoryModel();
		$category = $CategoryModel->updateCategory($name, $id);

		if(!$category){
			$this->errorMessage['text'] = "Error actualizar la categoría en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('id');
		$this->auditContent['user_id'] 		= $auditUserId;
		$this->auditContent['action'] 		= "Actualizar categoría";
		$this->auditContent['description'] 	= "Se ha actualizado la categoría con ID #" . $id . " exitosamente.";
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

		$id = $this->request->getPost('id');

		$CategoryModel = new CategoryModel();
		$deleteCategory = $CategoryModel->deleteCategory($id);

		if(!$deleteCategory){
			$this->errorMessage['text'] = "La categoría no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('id');
		$this->auditContent['user_id'] 		= $auditUserId;
		$this->auditContent['action'] 		= "Eliminar categoría";
		$this->auditContent['description'] 	= "Se ha eliminado la categoría con ID #" . $id . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "Categoría eliminada";
		$this->successMessage['text'] 		= "Puede recuperarla desde la papelera";
		return sweetAlert($this->successMessage);
	}
}
