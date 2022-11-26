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
		"modulo"		=> "Proveedores",
		"accion"		=> "",
		"descripcion"	=> ""
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
			"codigo" 			=> $this->request->getPost('code'),
			"nombre" 			=> $this->request->getPost('name'),
			"identificacion" 	=> $this->request->getPost('identification'),
			"direccion" 		=> $this->request->getPost('address'),
			"telefono" 			=> $this->request->getPost('phone')
		];

		$ProviderModel = new ProviderModel();
		$provider = $ProviderModel->createProvider($data);

		if(!$provider){
			$this->errorMessage['text'] = "Error al guardar el proveedor en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Crear proveedor";
		$this->auditContent['descripcion'] 	= "Se ha creado al proveedor con código " . $data['codigo'] . " exitosamente.";
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
			->edit('estado', function($row){
					
				if($row->estado == 0){
					return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-danger text-danger p-2 px-3">Desactivado</a></div>';
				}

				return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-success text-success p-2 px-3">Activado</a></div>';
			})
			->add('Acciones', function($row){
				if($row->estado == 1){
					return '<div class="btn-list"> 
								<button type="button" class="btnView btn btn-sm btn-primary waves-effect" data-id="'.$row->codigo.'" data-type="providers" data-bs-toggle="modal" data-bs-target="#viewModal">
									<i class="far fa-eye"></i>
								</button>
								<button type="button" class="btnDelete btn btn-sm btn-danger waves-effect" data-id="'.$row->codigo.'" data-type="providers">
									<i class="far fa-trash-alt"></i>
								</button>
							</div>';
				}

				return '<div class="btn-list"> 
								<button type="button" class="btnRecover btn btn-sm btn-success waves-effect" data-id="'.$row->codigo.'" data-type="providers">
									<i class="fas fa-check"></i>
								</button>
							</div>';

			}, 'last') 
			->filter(function ($builder, $request) {
        
				if($request->range != ''){

					if(!empty(explode(' a ', $request->range)[1])){
						$from = explode(' a ', $request->range)[0];
						$to = explode(' a ', $request->range)[1];
						$where = "DATE_FORMAT(proveedores.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
						$builder->where($where);
					}else{
						$where = "DATE_FORMAT(proveedores.creado_en, '%Y-%m-%d') = '$request->range'";
						$builder->where($where);
					}
					
				}

				if($request->status != ''){
					$builder->where('proveedores.estado', $request->status);
				}
		
			})
			->toJson();
	}

	public function getProviderById($identification)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ProviderModel = new ProviderModel();
		$provider = $ProviderModel->getProviderById(['codigo' => $identification]);
		if(!$provider){
			return false;
		}

		return json_encode($provider);
	}

	public function updateProvider()
	{
		helper('providerValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(updateProviderValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$code = $this->request->getPost('code');
		$data = [
			"codigo" 		=> $this->request->getPost('code'),
			"nombre" 		=> $this->request->getPost('name'),
			"identificacion"=> $this->request->getPost('identification'),
			"direccion" 	=> $this->request->getPost('address'),
			"telefono" 		=> $this->request->getPost('phone')
		];

		$ProviderModel = new ProviderModel();
		$provider = $ProviderModel->updateProvider($data, $code);

		if(!$provider){
			$this->errorMessage['text'] = "Error actualizar al proveedor en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Actualizar proveedor";
		$this->auditContent['descripcion'] 	= "Se ha actualizado al proveedor con código " . $data['codigo'] . " exitosamente.";
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

		$code = $this->request->getPost('identification');

		$ProviderModel = new ProviderModel();
		$deleteProvider = $ProviderModel->deleteProvider($code);

		if(!$deleteProvider){
			$this->errorMessage['text'] = "El proveedor no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Eliminar proveedor";
		$this->auditContent['descripcion'] 	= "Se ha eliminado al proveedor con código " . $code . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "Proveedor eliminado";
		$this->successMessage['text'] 		= "Puede recuperarlo desde la papelera";
		return sweetAlert($this->successMessage);
	}

	public function recoverProvider()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$code = $this->request->getPost('identification');

		$ProviderModel = new ProviderModel();
		$recoverProvider = $ProviderModel->recoverProvider($code);

		if(!$recoverProvider){
			$this->errorMessage['text'] = "El proveedor no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Recuperar proveedor";
		$this->auditContent['descripcion'] 	= "Se ha recuperado al proveedor con código " . $code . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "¡Exito!";
		$this->successMessage['text'] 		= "El proveedor ha sido recuperado";
		return sweetAlert($this->successMessage);
	}
}
