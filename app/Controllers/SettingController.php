<?php 
namespace App\Controllers;
use App\Models\SettingModel;
use App\Models\AuditModel;

class SettingController extends BaseController
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
		"module"		=> "Centro de control",
		"action"		=> "",
		"description"	=> ""
	];
	public function setCoins()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$principalCoin = $this->request->getPost('setPrincipalCoin');
		$secondaryCoin = $this->request->getPost('setSecondaryCoin');

		if(empty($principalCoin) && empty($secondaryCoin)){
			$this->errorMessage['text'] = "Tienes que seleccionar una moneda principal y una moneda secundaria";
			return sweetAlert($this->errorMessage);
		}

		$SettingModel = new SettingModel();
		$setPrincipalCoin = $SettingModel->updateSetting([
									'value' => $principalCoin
								], 'principalCoin');
		$setSecondaryCoin = $SettingModel->updateSetting([
									'value' => $secondaryCoin
								], 'secondaryCoin');
		if(!$setPrincipalCoin || !$setSecondaryCoin){
			$this->errorMessage['text'] = "Error actualizar la información en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('id');
		$this->auditContent['user_id'] 		= $auditUserId;
		$this->auditContent['action'] 		= "Establecer monedas";
		$this->auditContent['description'] 	= "Se han establecido las monedas " . $principalCoin . " y " . $secondaryCoin . " como monedas principal y secundaria";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "Las monedas se han establecido correctamente";
		return sweetAlert($this->successMessage);

	}
}