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
		"usuario"		=> "",
		"modulo"		=> "Impuestos",
		"accion"		=> "",
		"descripcion"	=> ""
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
									'impuesto' => $name,
									'porcentaje' => $percentage
								]);

		if(!$tax){
			$this->errorMessage['text'] = "Error al guardar el impuesto en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Crear impuesto";
		$this->auditContent['descripcion'] 	= "Se ha creado el impuesto con identificación #" . $TaxModel->getLastId() . " exitosamente.";
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
			->edit('estado', function($row){
							
				if($row->estado == 0){
					return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-danger text-danger p-2 px-3">Desactivado</a></div>';
				}

				return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-success text-success p-2 px-3">Activado</a></div>';
			})
			->add('Acciones', function($row){
				if($row->estado == 1){
					return '<div class="btn-list"> 
								<button type="button" class="btnView btn btn-sm btn-primary waves-effect" data-id="'.$row->identificacion.'" data-type="taxes" data-bs-toggle="modal" data-bs-target="#viewModal">
									<i class="far fa-eye"></i>
								</button>
								<button type="button" class="btnDelete btn btn-sm btn-danger waves-effect" data-id="'.$row->identificacion.'" data-type="taxes">
									<i class="far fa-trash-alt"></i>
								</button>
							</div>';
				}

				return '<div class="btn-list"> 
								<button type="button" class="btnRecover btn btn-sm btn-success waves-effect" data-id="'.$row->identificacion.'" data-type="taxes">
									<i class="fas fa-check"></i>
								</button>
							</div>';

			}, 'last') 
			->filter(function ($builder, $request) {
		
				if($request->status != ''){
					$builder->where('estado', $request->status);
				}
		
			})
			->toJson();
	}

	public function getTaxById($identification)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$TaxModel = new TaxModel();
		$tax = $TaxModel->getTaxById(['identificacion' => $identification]);
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

		$identification = $this->request->getPost('identification');
		$name = $this->request->getPost('name');
		$percentage = $this->request->getPost('percentage');

		$TaxModel = new TaxModel();
		$tax = $TaxModel->updateTax([
									"impuesto" => $name,
									"porcentaje" => $percentage
								], $identification);

		if(!$tax){
			$this->errorMessage['text'] = "Error actualizar el impuesto en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Actualizar impuesto";
		$this->auditContent['descripcion'] 	= "Se ha actualizado el impuesto con identificación #" . $identification . " exitosamente.";
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

		$identification = $this->request->getPost('identification');

		$TaxModel = new TaxModel();
		$deleteTax = $TaxModel->deleteTax($identification);

		if(!$deleteTax){
			$this->errorMessage['text'] = "El impuesto no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Eliminar impuesto";
		$this->auditContent['descripcion'] 	= "Se ha eliminado el impuesto con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "Impuesto eliminado";
		$this->successMessage['text'] 		= "Puede recuperarlo desde la papelera";
		return sweetAlert($this->successMessage);
	}

	public function recoverTax()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$identification = $this->request->getPost('identification');

		$TaxModel = new TaxModel();
		$recoverTax = $TaxModel->recoverTax($identification);

		if(!$recoverTax){
			$this->errorMessage['text'] = "El impuesto no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Recuperar impuesto";
		$this->auditContent['descripcion'] 	= "Se ha recuperado al impuesto con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "¡Exito!";
		$this->successMessage['text'] 		= "El impuesto ha sido recuperado";
		return sweetAlert($this->successMessage);
	}
}
