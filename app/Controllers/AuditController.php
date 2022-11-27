<?php 
namespace App\Controllers;
use App\Models\AuditModel;
use \Hermawan\DataTables\DataTable;

class AuditController extends BaseController
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
		"modulo"		=> "Configuración",
		"accion"		=> "",
		"descripcion"	=> ""
	];
	public function getAudits()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$AuditModel = new AuditModel();
				
		return DataTable::of($AuditModel->getAudits())
			->filter(function ($builder, $request) {
					
				if($request->range != ''){

					if(!empty(explode(' a ', $request->range)[1])){
						$from = explode(' a ', $request->range)[0];
						$to = explode(' a ', $request->range)[1];
						$where = "DATE_FORMAT(auditoria.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
						$builder->where($where);
					}else{
						$where = "DATE_FORMAT(auditoria.creado_en, '%Y-%m-%d') = '$request->range'";
						$builder->where($where);
					}
					
				}

			})
			->toJson();
	}

	public function settingsUpdate()
	{
		helper('settingValidation');
		
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		
		if(!$this->validate(settingValidation())){
			
			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}
			
		}
		
		$identification = $this->request->getPost('identification');
		$name = $this->request->getPost('name');
		
		$db = \Config\Database::connect();
		$db = $db->table('configuracion');
		$db->where('nom_configuracion', 'sistema_nombre')->set('valor_configuracion', $this->request->getPost('systemName'))->update();
		$db->where('nom_configuracion', 'moneda_principal')->set('valor_configuracion', $this->request->getPost('principalCoin'))->update();
		$db->where('nom_configuracion', 'empresa_nombre')->set('valor_configuracion', $this->request->getPost('name'))->update();
		$db->where('nom_configuracion', 'empresa_rif')->set('valor_configuracion', $this->request->getPost('identification'))->update();
		$db->where('nom_configuracion', 'empresa_direccion')->set('valor_configuracion', $this->request->getPost('address'))->update();
		$db->where('nom_configuracion', 'empresa_telefono')->set('valor_configuracion', $this->request->getPost('phone'))->update();

		if(!$db){
			$this->errorMessage['text'] = "Ha ocurrido un error";
			return sweetAlert($this->errorMessage);
		}


		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Actualizar configuración";
		$this->auditContent['descripcion'] 	= "Se ha actualizado la configuración del sistema exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "reload";
		$this->successMessage['text'] 		= "Cierra sesión para ver los cambios";
		$this->successMessage['url'] 		= base_url();
		
		return sweetAlert($this->successMessage);
				
		
	}
}