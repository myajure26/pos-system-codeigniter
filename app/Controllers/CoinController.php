<?php 
namespace App\Controllers;
use App\Models\CoinModel;
use App\Models\AuditModel;
use \Hermawan\DataTables\DataTable;

class CoinController extends BaseController
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
		"modulo"		=> "Monedas",
		"accion"		=> "",
		"descripcion"	=> ""
	];

	public function createCoin()
	{
		helper('coinValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(createCoinValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$name = $this->request->getPost('name');
		$symbol = $this->request->getPost('symbol');

		$CoinModel = new CoinModel();
		$coin = $CoinModel->createCoin([
									'moneda' => $name,
									'simbolo' => $symbol
								]);

		if(!$coin){
			$this->errorMessage['text'] = "Error al guardar la moneda en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Crear moneda";
		$this->auditContent['descripcion'] 	= "Se ha creado la moneda con identificación #" . $CoinModel->getLastId() . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "La moneda se ha creado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function getCoins()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$CoinModel = new CoinModel();
				
		return DataTable::of($CoinModel->getCoins())
			->edit('estado', function($row){
								
				if($row->estado == 0){
					return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-danger text-danger p-2 px-3">Desactivado</a></div>';
				}

				return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-success text-success p-2 px-3">Activado</a></div>';
			})
			->add('Acciones', function($row){
				if($row->estado == 1){
					return '<div class="btn-list"> 
								<button type="button" class="btnView btn btn-sm btn-primary waves-effect" data-id="'.$row->identificacion.'" data-type="coins" data-bs-toggle="modal" data-bs-target="#viewModal">
									<i class="far fa-eye"></i>
								</button>
								<button type="button" class="btnDelete btn btn-sm btn-danger waves-effect" data-id="'.$row->identificacion.'" data-type="coins">
									<i class="far fa-trash-alt"></i>
								</button>
							</div>';
				}

				return '<div class="btn-list"> 
								<button type="button" class="btnRecover btn btn-sm btn-success waves-effect" data-id="'.$row->identificacion.'" data-type="coins">
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

	public function getCoinById($identification)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$CoinModel = new CoinModel();
		$coin = $CoinModel->getCoinById(['identificacion' => $identification]);
		if(!$coin){
			return false;
		}

		return json_encode($coin);
	}

	public function updateCoin()
	{
		helper('coinValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(updateCoinValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$identification = $this->request->getPost('identification');
		$name = $this->request->getPost('name');
		$symbol = $this->request->getPost('symbol');

		$CoinModel = new CoinModel();
		$coin = $CoinModel->updateCoin([
										"moneda" => $name,
										"simbolo" => $symbol
									], $identification);

		if(!$coin){
			$this->errorMessage['text'] = "Error actualizar la moneda en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Actualizar moneda";
		$this->auditContent['descripcion'] 	= "Se ha actualizado la moneda con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "La moneda se ha actualizado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function deleteCoin()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$identification = $this->request->getPost('identification');

		$CoinModel = new CoinModel();
		$deleteCoin = $CoinModel->deleteCoin($identification);

		if(!$deleteCoin){
			$this->errorMessage['text'] = "La moneda no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Eliminar moneda";
		$this->auditContent['descripcion'] 	= "Se ha eliminado la moneda con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "Moneda eliminada";
		$this->successMessage['text'] 		= "Puede recuperarla desde la papelera";
		return sweetAlert($this->successMessage);
	}

	public function recoverCoin()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$identification = $this->request->getPost('identification');

		$CoinModel = new CoinModel();
		$recoverCoin = $CoinModel->recoverCoin($identification);

		if(!$recoverCoin){
			$this->errorMessage['text'] = "La moneda no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Recuperar moneda";
		$this->auditContent['descripcion'] 	= "Se ha recuperado la moneda con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "¡Exito!";
		$this->successMessage['text'] 		= "La moneda ha sido recuperado";
		return sweetAlert($this->successMessage);
	}
}
