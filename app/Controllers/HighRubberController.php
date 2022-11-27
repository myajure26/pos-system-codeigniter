<?php 
namespace App\Controllers;
use App\Models\HighRubberModel;
use App\Models\AuditModel;
use \Hermawan\DataTables\DataTable;

class HighRubberController extends BaseController
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
		"modulo"		=> "Alto caucho",
		"accion"		=> "",
		"descripcion"	=> ""
	];

	public function createHighRubber()
	{
		helper('highRubberValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(createHighRubberValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$highNumber = $this->request->getPost('highNumber');

		$HighRubberModel = new HighRubberModel();
		$high = $HighRubberModel->createHighRubber(['alto_numero' => $highNumber]);

		if(!$high){
			$this->errorMessage['text'] = "Error al guardar el registro";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Crear alto caucho";
		$this->auditContent['descripcion'] 	= "Se ha creado la medida con identificación #" . $HighRubberModel->getLastId() . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "La medida se ha creado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function getHighRubbers()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$HighRubberModel = new HighRubberModel();
				
		return DataTable::of($HighRubberModel->getHighRubbers())
			->edit('estado_alto_caucho', function($row){
									
				if($row->estado_alto_caucho == 0){
					return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-danger text-danger p-2 px-3">Desactivado</a></div>';
				}

				return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-success text-success p-2 px-3">Activado</a></div>';
			})
			->add('Acciones', function($row){
				if($row->estado_alto_caucho == 1){
					return '<div class="btn-list"> 
								<button type="button" class="btnView btn btn-sm btn-primary waves-effect" data-id="'.$row->id_alto_caucho.'" data-type="highRubber" data-bs-toggle="modal" data-bs-target="#viewModal">
									<i class="far fa-eye"></i>
								</button>
								<button type="button" class="btnDelete btn btn-sm btn-danger waves-effect" data-id="'.$row->id_alto_caucho.'" data-type="highRubber">
									<i class="far fa-trash-alt"></i>
								</button>
							</div>';
				}

				return '<div class="btn-list"> 
								<button type="button" class="btnRecover btn btn-sm btn-success waves-effect" data-id="'.$row->id_alto_caucho.'" data-type="highRubber">
									<i class="fas fa-check"></i>
								</button>
							</div>';

			}, 'last') 
			->filter(function ($builder, $request) {
		
				if($request->range != ''){

					if(!empty(explode(' a ', $request->range)[1])){
						$from = explode(' a ', $request->range)[0];
						$to = explode(' a ', $request->range)[1];
						$where = "DATE_FORMAT(alto_caucho.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
						$builder->where($where);
					}else{
						$where = "DATE_FORMAT(alto_caucho.creado_en, '%Y-%m-%d') = '$request->range'";
						$builder->where($where);
					}
					
				}

				if($request->status != ''){
					$builder->where('alto_caucho.estado_alto_caucho', $request->status);
				}
		
			})
			->toJson();
	}

	public function getHighRubberById($identification)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$HighRubberModel = new HighRubberModel();
		$high = $HighRubberModel->getHighRubberById(['id_alto_caucho' => $identification]);
		if(!$high){
			return false;
		}

		return json_encode($high);
	}

	public function updateHighRubber()
	{
		helper('highRubberValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}
		
		if(!$this->validate(updateHighRubberValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$identification = $this->request->getPost('identification');
		$highNumber = $this->request->getPost('highNumber');

		$HighRubberModel = new HighRubberModel();
		$high = $HighRubberModel->updateHighRubber($highNumber, $identification);

		if(!$high){
			$this->errorMessage['text'] = "Error actualizar la medida en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Actualizar alto caucho";
		$this->auditContent['descripcion'] 	= "Se ha actualizado la medida con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "La medida se ha actualizado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function deleteHighRubber()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$identification = $this->request->getPost('identification');

		$HighRubberModel = new HighRubberModel();
		$deleteHighRubber = $HighRubberModel->deleteHighRubber($identification);

		if(!$deleteHighRubber){
			$this->errorMessage['text'] = "La medida no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Eliminar alto caucho";
		$this->auditContent['descripcion'] 	= "Se ha eliminado la medida con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "Medida eliminada";
		$this->successMessage['text'] 		= "Puede recuperarla desde la papelera";
		return sweetAlert($this->successMessage);
	}

	public function recoverHighRubber()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$identification = $this->request->getPost('identification');

		$HighRubberModel = new HighRubberModel();
		$recoverHighRubber = $HighRubberModel->recoverHighRubber($identification);

		if(!$recoverHighRubber){
			$this->errorMessage['text'] = "La medida no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Recuperar alto caucho";
		$this->auditContent['descripcion'] 	= "Se ha recuperado la medida con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "¡Exito!";
		$this->successMessage['text'] 		= "La medida ha sido recuperada";
		return sweetAlert($this->successMessage);
	}
}
