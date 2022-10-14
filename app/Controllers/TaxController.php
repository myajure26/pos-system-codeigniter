<?php 
namespace App\Controllers;
use App\Models\TaxModel;
use App\Models\AuditModel;
use \Hermawan\DataTables\DataTable;

class TaxController extends BaseController
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
		"module"		=> "Impuestos",
		"action"		=> "",
		"description"	=> ""
	];

	public function createTax()
	{
		helper('taxValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(createTaxValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$name = $this->request->getPost('name');
		$percentage = $this->request->getPost('percentage');

		$TaxModel = new TaxModel();
		$tax = $TaxModel->createTax([
									'tax' => $name,
									'percentage' => $percentage
								]);

		if(!$tax){
			$this->errorMessage['text'] = "Error al guardar el impuesto en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('id');
		$this->auditContent['user'] 		= $auditUserId;
		$this->auditContent['action'] 		= "Crear impuesto";
		$this->auditContent['description'] 	= "Se ha creado el impuesto con ID #" . $TaxModel->getLastId() . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "El impuesto se ha creado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function getTaxes()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$TaxModel = new TaxModel();
				
		return DataTable::of($TaxModel->getTaxes())
			->add('Acciones', function($row){
				return '<div class="btn-list"> 
                            <button type="button" class="btnView btn btn-sm btn-primary waves-effect" data-id="'.$row->id.'" data-type="taxes" data-bs-toggle="modal" data-bs-target="#viewModal">
                                <i class="far fa-eye"></i>
                            </button>
                            <button type="button" class="btnDelete btn btn-sm btn-danger waves-effect" data-id="'.$row->id.'" data-type="taxes">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>';
			}, 'last') 
			->toJson();
	}

	public function getTaxById($id)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$TaxModel = new TaxModel();
		$tax = $TaxModel->getTaxById(['id' => $id]);
		if(!$tax){
			return false;
		}
		return json_encode($tax);
	}

	public function updateTax()
	{
		helper('taxValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(updateTaxValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$id = $this->request->getPost('id');
		$name = $this->request->getPost('name');
		$percentage = $this->request->getPost('percentage');

		$TaxModel = new TaxModel();
		$tax = $TaxModel->updateTax([
									"tax" => $name,
									"percentage" => $percentage
								], $id);

		if(!$tax){
			$this->errorMessage['text'] = "Error actualizar el impuesto en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('id');
		$this->auditContent['user'] 		= $auditUserId;
		$this->auditContent['action'] 		= "Actualizar impuesto";
		$this->auditContent['description'] 	= "Se ha actualizado el impuesto con ID #" . $id . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "El impuesto se ha actualizado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function deleteTax()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$id = $this->request->getPost('id');

		$TaxModel = new TaxModel();
		$deleteTax = $TaxModel->deleteTax($id);

		if(!$deleteTax){
			$this->errorMessage['text'] = "El impuesto no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('id');
		$this->auditContent['user'] 		= $auditUserId;
		$this->auditContent['action'] 		= "Eliminar impuesto";
		$this->auditContent['description'] 	= "Se ha eliminado el impuesto con ID #" . $id . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "Impuesto eliminado";
		$this->successMessage['text'] 		= "Puede recuperarlo desde la papelera";
		return sweetAlert($this->successMessage);
	}
}
