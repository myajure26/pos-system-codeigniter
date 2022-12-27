<?php 
namespace App\Controllers;
use App\Models\WideRubberModel;
use App\Models\AuditModel;
use \Hermawan\DataTables\DataTable;

class WideRubberController extends BaseController
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
		"modulo"		=> "Ancho caucho",
		"accion"		=> "",
		"descripcion"	=> ""
	];

	public function createWideRubber()
	{
		helper('wideRubberValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(createWideRubberValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$wideNumber = $this->request->getPost('wideNumber');

		$WideRubberModel = new WideRubberModel();
		$wide = $WideRubberModel->createWideRubber(['ancho_numero' => $wideNumber]);

		if(!$wide){
			$this->errorMessage['text'] = "Error al guardar el registro";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Crear ancho caucho";
		$this->auditContent['descripcion'] 	= "Se ha creado la medida con identificación #" . $WideRubberModel->getLastId() . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "La medida se ha creado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function getWideRubbers()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$WideRubberModel = new WideRubberModel();
				
		return DataTable::of($WideRubberModel->getWideRubbers())
			->edit('estado_ancho_caucho', function($row){
									
				if($row->estado_ancho_caucho == 0){
					return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-danger text-danger p-2 px-3">Desactivado</a></div>';
				}

				return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-success text-success p-2 px-3">Activado</a></div>';
			})
			->add('Acciones', function($row){
				if($row->estado_ancho_caucho == 1){
					return '<div class="btn-list"> 
								<button type="button" class="btnView btn btn-sm btn-primary waves-effect" data-id="'.$row->id_ancho_caucho.'" data-type="wideRubber" data-bs-toggle="modal" data-bs-target="#viewModal">
									<i class="far fa-eye"></i>
								</button>
								<button type="button" class="btnDelete btn btn-sm btn-danger waves-effect" data-id="'.$row->id_ancho_caucho.'" data-type="wideRubber">
									<i class="far fa-trash-alt"></i>
								</button>
							</div>';
				}

				return '<div class="btn-list"> 
								<button type="button" class="btnRecover btn btn-sm btn-success waves-effect" data-id="'.$row->id_ancho_caucho.'" data-type="wideRubber">
									<i class="fas fa-check"></i>
								</button>
							</div>';

			}, 'last') 
			->filter(function ($builder, $request) {
		
				if($request->range != ''){

					if(!empty(explode(' a ', $request->range)[1])){
						$from = explode(' a ', $request->range)[0];
						$to = explode(' a ', $request->range)[1];
						$where = "DATE_FORMAT(ancho_caucho.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
						$builder->where($where);
					}else{
						$where = "DATE_FORMAT(ancho_caucho.creado_en, '%Y-%m-%d') = '$request->range'";
						$builder->where($where);
					}
					
				}

				if($request->status != ''){
					$builder->where('ancho_caucho.estado_ancho_caucho', $request->status);
				}
		
			})
			->toJson();
	}

	public function getWideRubberById($identification)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$WideRubberModel = new WideRubberModel();
		$wide = $WideRubberModel->getWideRubberById(['id_ancho_caucho' => $identification]);
		if(!$wide){
			return false;
		}

		$wide[0]['creado_en'] = date('d-m-Y H:i:s', strtotime($wide[0]['creado_en']));
		$wide[0]['actualizado_en'] = date('d-m-Y H:i:s', strtotime($wide[0]['actualizado_en']));

		return json_encode($wide);
	}

	public function updateWideRubber()
	{
		helper('wideRubberValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}
		
		if(!$this->validate(updateWideRubberValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$identification = $this->request->getPost('identification');
		$wideNumber = $this->request->getPost('wideNumber');

		$WideRubberModel = new WideRubberModel();
		$wide = $WideRubberModel->updateWideRubber($wideNumber, $identification);

		if(!$wide){
			$this->errorMessage['text'] = "Error actualizar la medida en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Actualizar ancho caucho";
		$this->auditContent['descripcion'] 	= "Se ha actualizado la medida con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "La medida se ha actualizado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function deleteWideRubber()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$identification = $this->request->getPost('identification');

		$WideRubberModel = new WideRubberModel();
		$deleteWideRubber = $WideRubberModel->deleteWideRubber($identification);

		if(!$deleteWideRubber){
			$this->errorMessage['text'] = "La medida no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Eliminar ancho caucho";
		$this->auditContent['descripcion'] 	= "Se ha eliminado la medida con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "Medida eliminada";
		$this->successMessage['text'] 		= "Puede recuperarla desde la papelera";
		return sweetAlert($this->successMessage);
	}

	public function recoverWideRubber()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$identification = $this->request->getPost('identification');

		$WideRubberModel = new WideRubberModel();
		$recoverWideRubber = $WideRubberModel->recoverWideRubber($identification);

		if(!$recoverWideRubber){
			$this->errorMessage['text'] = "La medida no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Recuperar ancho caucho";
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
