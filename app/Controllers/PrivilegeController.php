<?php 
namespace App\Controllers;
use App\Models\PrivilegeModel;
use App\Models\AuditModel;
use \Hermawan\DataTables\DataTable;

class PrivilegeController extends BaseController
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
		"modulo"		=> "Privilegios",
		"accion"		=> "",
		"descripcion"	=> ""
	];

	public function createPrivilege()
	{
		helper('privilegeValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(createPrivilegeValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$name = $this->request->getPost('name');
		$permissions = $this->request->getPost('permissions');

		$PrivilegeModel = new PrivilegeModel();
		$privilege = $PrivilegeModel->createPrivilege([
									'nombre' => $name,
									'permisos' => $permissions
								]);

		if(!$privilege){
			$this->errorMessage['text'] = "Error al guardar en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Crear privilegio";
		$this->auditContent['descripcion'] 	= "Se ha creado el privilegio con identificación #" . $PrivilegeModel->getLastId() . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "El privilegio se ha creado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function getPrivileges()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$PrivilegeModel = new PrivilegeModel();
				
		return DataTable::of($PrivilegeModel->getPrivileges())
			->edit('estado', function($row){
							
				if($row->estado == 0){
					return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-danger text-danger p-2 px-3">Desactivado</a></div>';
				}

				return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-success text-success p-2 px-3">Activado</a></div>';
			})
			->edit('permisos', function($row){
							
				if($row->permisos == 1){
					return 'Superadmin';
				}

				if($row->permisos == 2){
					return 'Vendedor';
				}

				if($row->permisos == 3){
					return 'Almacenista';
				}

			})
			->add('Acciones', function($row){
				if($row->estado == 1){
					return '<div class="btn-list"> 
								<button type="button" class="btnView btn btn-sm btn-primary waves-effect" data-id="'.$row->identificacion.'" data-type="privileges" data-bs-toggle="modal" data-bs-target="#viewModal">
									<i class="far fa-eye"></i>
								</button>
								<button type="button" class="btnDelete btn btn-sm btn-danger waves-effect" data-id="'.$row->identificacion.'" data-type="privileges">
									<i class="far fa-trash-alt"></i>
								</button>
							</div>';
				}

				return '<div class="btn-list"> 
								<button type="button" class="btnRecover btn btn-sm btn-success waves-effect" data-id="'.$row->identificacion.'" data-type="privileges">
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

	public function getPrivilegeById($identification)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$PrivilegeModel = new PrivilegeModel();
		$privilege = $PrivilegeModel->getPrivilegeById(['identificacion' => $identification]);
		if(!$privilege){
			return false;
		}
		return json_encode($privilege);
	}

	public function updatePrivilege()
	{
		helper('privilegeValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(updatePrivilegeValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$identification = $this->request->getPost('identification');
		$name = $this->request->getPost('name');
		$permissions = $this->request->getPost('permissions');

		$PrivilegeModel = new PrivilegeModel();
		$privilege = $PrivilegeModel->updatePrivilege([
										"nombre" => $name,
										"permisos" => $permissions
									], $identification);

		if(!$privilege){
			$this->errorMessage['text'] = "Error actualizar el privilegio en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Actualizar privilegio";
		$this->auditContent['descripcion'] 	= "Se ha actualizado el privilegio con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "El privilegio se ha actualizado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function deletePrivilege()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$identification = $this->request->getPost('identification');

		$PrivilegeModel = new PrivilegeModel();
		$deletePrivilege = $PrivilegeModel->deletePrivilege($identification);

		if(!$deletePrivilege){
			$this->errorMessage['text'] = "El privilegio no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Eliminar privilegio";
		$this->auditContent['descripcion'] 	= "Se ha eliminado el privilegio con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "Privilegio eliminado";
		$this->successMessage['text'] 		= "Puede recuperarlo desde la papelera";
		return sweetAlert($this->successMessage);
	}

	public function recoverPrivilege()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$identification = $this->request->getPost('identification');

		$PrivilegeModel = new PrivilegeModel();
		$recoverPrivilege = $PrivilegeModel->recoverPrivilege($identification);

		if(!$recoverPrivilege){
			$this->errorMessage['text'] = "El privilegio no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Recuperar privilegio";
		$this->auditContent['descripcion'] 	= "Se ha recuperado al privilegio con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "¡Exito!";
		$this->successMessage['text'] 		= "El privilegio ha sido recuperado";
		return sweetAlert($this->successMessage);
	}
}
