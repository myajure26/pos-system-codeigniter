<?php 
namespace App\Controllers;
use App\Models\ProviderModel;
use App\Models\AuditModel;
use \Hermawan\DataTables\DataTable;

class ProviderController extends BaseController
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
		"module"		=> "Proveedores",
		"action"		=> "",
		"description"	=> ""
	];

	public function createProvider()
	{
		helper('providerValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(createProviderValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$data = [
			"code" 		=> $this->request->getPost('code'),
			"name" 		=> $this->request->getPost('name'),
			"rifLetter" => $this->request->getPost('rifLetter'),
			"rif" 		=> $this->request->getPost('rif'),
			"address" 	=> $this->request->getPost('address'),
			"phone" 	=> $this->request->getPost('phone'),
			"phone2" 	=> $this->request->getPost('phone2'),
			"type" 		=> $this->request->getPost('providerType')
		];

		$ProviderModel = new ProviderModel();
		$provider = $ProviderModel->createProvider($data);

		if(!$provider){
			$this->errorMessage['text'] = "Error al guardar el proveedor en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('id');
		$this->auditContent['user_id'] 		= $auditUserId;
		$this->auditContent['action'] 		= "Crear proveedor";
		$this->auditContent['description'] 	= "Se ha creado al proveedor con ID #" . $ProviderModel->getLastId() . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "El proveedor se ha creado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function getProviders()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ProviderModel = new ProviderModel();
				
		return DataTable::of($ProviderModel->getProviders())
			->hide('rifLetter')
			->edit('rif', function($row){
				return $row->rifLetter . "-" . $row->rif;
			})
			->edit('phone', function($row){
				if($row->phone2 != ''){
					return $row->phone . "<br>" . $row->phone2;
				}
				return $row->phone;

			})
			->hide('phone2')
			->add('Acciones', function($row){
				return '<div class="btn-list"> 
                            <button type="button" class="btnUpdate btn btn-sm btn-primary waves-effect" data-id="'.$row->id.'" data-type="providers" data-bs-toggle="modal" data-bs-target="#updateModal">
                                <i class="far fa-edit"></i>
                            </button>
                            <button type="button" class="btnDelete btn btn-sm btn-danger waves-effect" data-id="'.$row->id.'" data-type="providers">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>';
			}, 'last') 
			->toJson();
	}

	public function getProviderById($id)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ProviderModel = new ProviderModel();
		$provider = $ProviderModel->getProviderById(['id' => $id]);
		if(!$provider){
			return false;
		}
		return json_encode($provider);
	}

	public function updateProvider()
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
		$data = [
			"code" 		=> $this->request->getPost('code'),
			"name" 		=> $this->request->getPost('name'),
			"rifLetter" => $this->request->getPost('rifLetter'),
			"rif" 		=> $this->request->getPost('rif'),
			"address" 	=> $this->request->getPost('address'),
			"phone" 	=> $this->request->getPost('phone'),
			"phone2" 	=> $this->request->getPost('phone2'),
			"type" 		=> $this->request->getPost('providerType')
		];

		$ProviderModel = new ProviderModel();
		$provider = $ProviderModel->updateProvider($data, $id);

		if(!$provider){
			$this->errorMessage['text'] = "Error actualizar al proveedor en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('id');
		$this->auditContent['user_id'] 		= $auditUserId;
		$this->auditContent['action'] 		= "Actualizar proveedor";
		$this->auditContent['description'] 	= "Se ha actualizado al proveedor con ID #" . $id . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "El proveedor se ha actualizado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function deleteProvider()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$id = $this->request->getPost('id');

		$ProviderModel = new ProviderModel();
		$deleteProvider = $ProviderModel->deleteProvider($id);

		if(!$deleteProvider){
			$this->errorMessage['text'] = "El proveedor no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('id');
		$this->auditContent['user_id'] 		= $auditUserId;
		$this->auditContent['action'] 		= "Eliminar proveedor";
		$this->auditContent['description'] 	= "Se ha eliminado al proveedor con ID #" . $id . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "Proveedor eliminado";
		$this->successMessage['text'] 		= "Puede recuperarlo desde la papelera";
		return sweetAlert($this->successMessage);
	}
}
