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
		"modulo"		=> "Clientes",
		"accion"		=> "",
		"descripcion"	=> ""
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
			"identificacion" 			=> $this->request->getPost('identification'),
			"nombre" 					=> $this->request->getPost('name'),
			"direccion" 				=> $this->request->getPost('address'),
			"telefono" 					=> $this->request->getPost('phone'),
		];

		$CustomerModel = new CustomerModel();
		$customer = $CustomerModel->createCustomer($data);

		if(!$customer){
			$this->errorMessage['text'] = "Error al guardar al cliente en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Crear cliente";
		$this->auditContent['descripcion'] 	= "Se ha creado al cliente con identificacion " . $data['identificacion'] . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		

		if( $this->request->getPost('saveCustomerSale') ){
			$this->successMessage['alert'] 		= "simple";
			$this->successMessage['text'] 		= "El cliente se ha creado correctamente";
			return sweetAlert($this->successMessage);
		}

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
			->edit('estado', function($row){
						
				if($row->estado == 0){
					return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-danger text-danger p-2 px-3">Desactivado</a></div>';
				}

				return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-success text-success p-2 px-3">Activado</a></div>';
			})
			->add('Acciones', function($row){
				if($row->estado == 1){
					return '<div class="btn-list"> 
								<button type="button" class="btnView btn btn-sm btn-primary waves-effect" data-id="'.$row->identificacion.'" data-type="customers" data-bs-toggle="modal" data-bs-target="#viewModal">
									<i class="far fa-eye"></i>
								</button>
								<button type="button" class="btnDelete btn btn-sm btn-danger waves-effect" data-id="'.$row->identificacion.'" data-type="customers">
									<i class="far fa-trash-alt"></i>
								</button>
							</div>';
				}

				return '<div class="btn-list"> 
								<button type="button" class="btnRecover btn btn-sm btn-success waves-effect" data-id="'.$row->identificacion.'" data-type="customers">
									<i class="fas fa-check"></i>
								</button>
							</div>';

			}, 'last') 
			->filter(function ($builder, $request) {
		
				if($request->range != ''){

					if(!empty(explode(' a ', $request->range)[1])){
						$from = explode(' a ', $request->range)[0];
						$to = explode(' a ', $request->range)[1];
						$where = "DATE_FORMAT(clientes.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
						$builder->where($where);
					}else{
						$where = "DATE_FORMAT(clientes.creado_en, '%Y-%m-%d') = '$request->range'";
						$builder->where($where);
					}
					
				}

				if($request->status != ''){
					$builder->where('clientes.estado', $request->status);
				}
		
			})
			->toJson();
	}

	public function getCustomerById($identification)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$CustomerModel = new CustomerModel();
		$customer = $CustomerModel->getCustomerById(['identificacion' => $identification]);
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

		$identification = $this->request->getPost('identification');
		$data = [
			"identificacion" 		=> $this->request->getPost('identification'),
			"nombre" 				=> $this->request->getPost('name'),
			"direccion" 			=> $this->request->getPost('address'),
			"telefono" 				=> $this->request->getPost('phone')
		];

		$CustomerModel = new CustomerModel();
		$customer = $CustomerModel->updateCustomer($data, $identification);

		if(!$customer){
			$this->errorMessage['text'] = "Error actualizar al cliente en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Actualizar cliente";
		$this->auditContent['descripcion'] 	= "Se ha actualizado al cliente con identificación " . $identification . " exitosamente.";
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

		$identification = $this->request->getPost('identification');

		$CustomerModel = new CustomerModel();
		$deleteCustomer = $CustomerModel->deleteCustomer($identification);

		if(!$deleteCustomer){
			$this->errorMessage['text'] = "El cliente no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Eliminar cliente";
		$this->auditContent['descripcion'] 	= "Se ha eliminado al cliente con identificación " . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "Cliente eliminado";
		$this->successMessage['text'] 		= "Puede recuperarlo desde la papelera";
		return sweetAlert($this->successMessage);
	}

	public function recoverCustomer()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$identification = $this->request->getPost('identification');

		$CustomerModel = new CustomerModel();
		$recoverCustomer = $CustomerModel->recoverCustomer($identification);

		if(!$recoverCustomer){
			$this->errorMessage['text'] = "El cliente no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Recuperar cliente";
		$this->auditContent['descripcion'] 	= "Se ha recuperado al cliente con identificación " . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "¡Exito!";
		$this->successMessage['text'] 		= "El cliente ha sido recuperado";
		return sweetAlert($this->successMessage);
	}
}
