<?php 
namespace App\Controllers;
use App\Models\CustomerModel;
use App\Models\AuditModel;
use \Hermawan\DataTables\DataTable;

class CustomerController extends BaseController
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
		"module"		=> "Clientes",
		"action"		=> "",
		"description"	=> ""
	];

	public function createCustomer()
	{
		helper('customerValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(createCustomerValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}
		
		$data = [
			"name" 						=> $this->request->getPost('name'),
			"identification" 			=> $this->request->getPost('identification'),
			"address" 					=> $this->request->getPost('address'),
			"phone" 					=> $this->request->getPost('phone'),
		];

		$CustomerModel = new CustomerModel();
		$customer = $CustomerModel->createCustomer($data);

		if(!$customer){
			$this->errorMessage['text'] = "Error al guardar al cliente en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('id');
		$this->auditContent['user'] 		= $auditUserId;
		$this->auditContent['action'] 		= "Crear cliente";
		$this->auditContent['description'] 	= "Se ha creado al cliente con ID #" . $CustomerModel->getLastId() . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "El cliente se ha creado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function getCustomers()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$CustomerModel = new CustomerModel();
				
		return DataTable::of($CustomerModel->getCustomers())
			->add('Acciones', function($row){
				return '<div class="btn-list"> 
							<button type="button" class="btnView btn btn-sm btn-primary waves-effect" data-id="'.$row->id.'" data-type="customers" data-bs-toggle="modal" data-bs-target="#viewModal">
                                <i class="far fa-eye"></i>
                            </button>
                            <button type="button" class="btnDelete btn btn-sm btn-danger waves-effect" data-id="'.$row->id.'" data-type="customers">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>';
			}, 'last') 
			->toJson();
	}

	public function getCustomerById($id)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$CustomerModel = new CustomerModel();
		$customer = $CustomerModel->getCustomerById(['id' => $id]);
		if(!$customer){
			return false;
		}
		return json_encode($customer);
	}

	public function updateCustomer()
	{
		helper('customerValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(updateCustomerValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$id = $this->request->getPost('id');
		$data = [
			"name" 					=> $this->request->getPost('name'),
			"identification" 		=> $this->request->getPost('identification'),
			"address" 				=> $this->request->getPost('address'),
			"phone" 				=> $this->request->getPost('phone')
		];

		$CustomerModel = new CustomerModel();
		$customer = $CustomerModel->updateCustomer($data, $id);

		if(!$customer){
			$this->errorMessage['text'] = "Error actualizar al cliente en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('id');
		$this->auditContent['user'] 		= $auditUserId;
		$this->auditContent['action'] 		= "Actualizar cliente";
		$this->auditContent['description'] 	= "Se ha actualizado al cliente con ID #" . $id . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "El cliente se ha actualizado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function deleteCustomer()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$id = $this->request->getPost('id');

		$CustomerModel = new CustomerModel();
		$deleteCustomer = $CustomerModel->deleteCustomer($id);

		if(!$deleteCustomer){
			$this->errorMessage['text'] = "El cliente no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('id');
		$this->auditContent['user'] 		= $auditUserId;
		$this->auditContent['action'] 		= "Eliminar cliente";
		$this->auditContent['description'] 	= "Se ha eliminado al cliente con ID #" . $id . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "Cliente eliminado";
		$this->successMessage['text'] 		= "Puede recuperarlo desde la papelera";
		return sweetAlert($this->successMessage);
	}
}
