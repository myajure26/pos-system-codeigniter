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
		if(!$this->validate('categories')){

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
		$this->auditContent['user_id'] = $auditUserId;
		$this->auditContent['action'] = "Crear categoría";
		$this->auditContent['description'] = "Se ha creado la categoría con ID #" . $CategoryModel->getLastId() . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "La categoría se ha creado correctamente";
		$this->successMessage['ajaxReload'] = "categories";
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
                            <button type="button" class="btnUpdateCategory btn btn-sm btn-primary waves-effect" category-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#updateCategoryModal">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button type="button" class="btnDeleteCategory btn btn-sm btn-danger waves-effect" category-id="'.$row->id.'">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>';
			}, 'last') 
			->toJson();
	}
}