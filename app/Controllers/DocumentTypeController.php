<?php 
namespace App\Controllers;
use App\Models\DocumentTypeModel;
use App\Models\AuditModel;
use \Hermawan\DataTables\DataTable;

class DocumentTypeController extends BaseController
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
		"modulo"		=> "Tipos de documento",
		"accion"		=> "",
		"descripcion"	=> ""
	];

	public function createDocumentType()
	{
		helper('documentTypeValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(createDocumentTypeValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$name = $this->request->getPost('name');

		$DocumentTypeModel = new DocumentTypeModel();
		$documentType = $DocumentTypeModel->createDocumentType(['nombre' => $name]);

		if(!$documentType){
			$this->errorMessage['text'] = "Error al guardar en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Crear tipo de documento";
		$this->auditContent['descripcion'] 	= "Se ha creado el tipo de documento con identificación #" . $DocumentTypeModel->getLastId() . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "El tipo de documento se ha creado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function getDocumentsType()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$DocumentTypeModel = new DocumentTypeModel();
				
		return DataTable::of($DocumentTypeModel->getDocumentsType())
			->edit('estado', function($row){
							
				if($row->estado == 0){
					return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-danger text-danger p-2 px-3">Desactivado</a></div>';
				}

				return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-success text-success p-2 px-3">Activado</a></div>';
			})
			->add('Acciones', function($row){
				if($row->estado == 1){
					return '<div class="btn-list"> 
								<button type="button" class="btnView btn btn-sm btn-primary waves-effect" data-id="'.$row->identificacion.'" data-type="document_type" data-bs-toggle="modal" data-bs-target="#viewModal">
									<i class="far fa-eye"></i>
								</button>
								<button type="button" class="btnDelete btn btn-sm btn-danger waves-effect" data-id="'.$row->identificacion.'" data-type="document_type">
									<i class="far fa-trash-alt"></i>
								</button>
							</div>';
				}

				return '<div class="btn-list"> 
								<button type="button" class="btnRecover btn btn-sm btn-success waves-effect" data-id="'.$row->identificacion.'" data-type="document_type">
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

	public function getDocumentTypeById($identification)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$DocumentTypeModel = new DocumentTypeModel();
		$documentType = $DocumentTypeModel->getDocumentTypeById(['identificacion' => $identification]);
		if(!$documentType){
			return false;
		}

		return json_encode($documentType);
	}

	public function updateDocumentType()
	{
		helper('documentTypeValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(updateDocumentTypeValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$identification = $this->request->getPost('identification');
		$name = $this->request->getPost('name');

		$DocumentTypeModel = new DocumentTypeModel();
		$documentType = $DocumentTypeModel->updateDocumentType(["nombre" => $name], $identification);

		if(!$documentType){
			$this->errorMessage['text'] = "Error actualizar el tipo de documento en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Actualizar tipo de documento";
		$this->auditContent['descripcion'] 	= "Se ha actualizado el tipo de documento con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "El tipo de documento se ha actualizado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function deleteDocumentType()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$identification = $this->request->getPost('identification');

		$DocumentTypeModel = new DocumentTypeModel();
		$deleteDocumentType = $DocumentTypeModel->deleteDocumentType($identification);

		if(!$deleteDocumentType){
			$this->errorMessage['text'] = "El tipo de documento no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Eliminar tipo de documento";
		$this->auditContent['descripcion'] 	= "Se ha eliminado el tipo de documento con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "Tipo de documento eliminado";
		$this->successMessage['text'] 		= "Puede recuperarlo desde la papelera";
		return sweetAlert($this->successMessage);
	}

	public function recoverDocumentType()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$identification = $this->request->getPost('identification');

		$DocumentTypeModel = new DocumentTypeModel();
		$recoverDocumentType = $DocumentTypeModel->recoverDocumentType($identification);

		if(!$recoverDocumentType){
			$this->errorMessage['text'] = "El tipo de documento no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Recuperar tipo de documento";
		$this->auditContent['descripcion'] 	= "Se ha recuperado al tipo de documento con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "¡Exito!";
		$this->successMessage['text'] 		= "El tipo de documento ha sido recuperado";
		return sweetAlert($this->successMessage);
	}
}
