<?php 
namespace App\Controllers;
use App\Models\BrandModel;
use App\Models\AuditModel;
use \Hermawan\DataTables\DataTable;

class BrandController extends BaseController
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
		"module"		=> "Marcas",
		"action"		=> "",
		"description"	=> ""
	];

	public function createBrand()
	{
		helper('brandValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(createBrandValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$name = $this->request->getPost('name');

		$BrandModel = new BrandModel();
		$brand = $BrandModel->createBrand(['brand' => $name]);

		if(!$brand){
			$this->errorMessage['text'] = "Error al guardar la marca en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('id');
		$this->auditContent['user_id'] 		= $auditUserId;
		$this->auditContent['action'] 		= "Crear marca";
		$this->auditContent['description'] 	= "Se ha creado la marca con ID #" . $BrandModel->getLastId() . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "La marca se ha creado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function getBrands()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$BrandModel = new BrandModel();
				
		return DataTable::of($BrandModel->getBrands())
			->add('Acciones', function($row){
				return '<div class="btn-list"> 
                            <button type="button" class="btnUpdate btn btn-sm btn-primary waves-effect" data-id="'.$row->id.'" data-type="brands" data-bs-toggle="modal" data-bs-target="#updateModal">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button type="button" class="btnDelete btn btn-sm btn-danger waves-effect" data-id="'.$row->id.'" data-type="brands">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>';
			}, 'last') 
			->toJson();
	}

	public function getBrandById($id)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$BrandModel = new BrandModel();
		$brand = $BrandModel->getBrandById(['id' => $id]);
		if(!$brand){
			return false;
		}
		return json_encode($brand);
	}

	public function updateBrand()
	{
		helper('brandValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}
		
		if(!$this->validate(updateBrandValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$id = $this->request->getPost('id');
		$name = $this->request->getPost('name');

		$BrandModel = new BrandModel();
		$brand = $BrandModel->updateBrand($name, $id);

		if(!$brand){
			$this->errorMessage['text'] = "Error actualizar la marca en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('id');
		$this->auditContent['user_id'] 		= $auditUserId;
		$this->auditContent['action'] 		= "Actualizar marca";
		$this->auditContent['description'] 	= "Se ha actualizado la marca con ID #" . $id . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "La marca se ha actualizado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function deleteBrand()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$id = $this->request->getPost('id');

		$BrandModel = new BrandModel();
		$deleteBrand = $BrandModel->deleteBrand($id);

		if(!$deleteBrand){
			$this->errorMessage['text'] = "La marca no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('id');
		$this->auditContent['user_id'] 		= $auditUserId;
		$this->auditContent['action'] 		= "Eliminar marca";
		$this->auditContent['description'] 	= "Se ha eliminado la marca con ID #" . $id . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "Marca eliminada";
		$this->successMessage['text'] 		= "Puede recuperarla desde la papelera";
		return sweetAlert($this->successMessage);
	}
}
