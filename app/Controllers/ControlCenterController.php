<?php 
namespace App\Controllers;
use App\Models\ControlCenterModel;
use App\Models\AuditModel;
use \Hermawan\DataTables\DataTable;

class ControlCenterController extends BaseController
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
		"modulo"		=> "Centro de control",
		"accion"		=> "",
		"descripcion"	=> ""
	];
	public function createCoinPrice()
	{
		helper('controlCenterValidation');
		helper('generateCode');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(createCoinPriceValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$principalCoin = $this->request->getPost('principalCoin');
		$secondaryCoin = $this->request->getPost('secondaryCoin');
		
		// Dar formato al precio
		$price = str_replace(',', '', $this->request->getPost('price'));
		
		if(!is_numeric($price)) {
			$this->errorMessage['text'] = "Por favor introduce un precio válido";
			return sweetAlert($this->errorMessage);
		}
		
		$price = floatval($price);
		
		if($price <= 0) {
			$this->errorMessage['text'] = "El precio tiene que ser mayor a 0";
			return sweetAlert($this->errorMessage);
		}

		$data = [
			"identificacion" 	=> generateCode('PM', 'precio_monedas', 'identificacion'),
			"moneda_principal" 	=> $this->principalCoin,
			"moneda_secundaria" => $secondaryCoin,
			"precio" 			=> $price,
		];

		$ControlCenterModel = new ControlCenterModel();
		$createCoinPrice = $ControlCenterModel->createCoinPrice($data);
		if(!$createCoinPrice){
			$this->errorMessage['text'] = "Error al guardar los datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Establecer precio monedas";
		$this->auditContent['descripcion'] 	= "Se ha establecido precio de moneda con identificación # " . $data['identificacion'] . " exitosamente";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "Las monedas se han establecido correctamente";
		return sweetAlert($this->successMessage);

	}

	public function getCoinPrices()
	{	
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ControlCenterModel = new ControlCenterModel();
				
		return DataTable::of($ControlCenterModel->getCoinPrices())
			->edit('estado', function($row){
								
				if($row->estado == 0){
					return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-danger text-danger p-2 px-3">Desactivado</a></div>';
				}

				return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-success text-success p-2 px-3">Activado</a></div>';
			})
			->edit('creado_en', function($row){
				return date('d-m-Y H:i:s', strtotime($row->creado_en));
			})
			->add('Acciones', function($row){
				if($row->estado == 1){
					return '<div class="btn-list"> 
								<button type="button" class="btnView btn btn-sm btn-primary waves-effect" data-id="'.$row->identificacion.'" data-type="coinPrices" data-bs-toggle="modal" data-bs-target="#viewModal">
									<i class="far fa-eye"></i>
								</button>
								<button type="button" class="btnDelete btn btn-sm btn-danger waves-effect" data-id="'.$row->identificacion.'" data-type="coinPrices">
									<i class="far fa-trash-alt"></i>
								</button>
							</div>';
				}

				return '<div class="btn-list"> 
								<button type="button" class="btnRecover btn btn-sm btn-success waves-effect" data-id="'.$row->identificacion.'" data-type="coinPrices">
									<i class="fas fa-check"></i>
								</button>
							</div>';

			}, 'last') 
			->filter(function ($builder, $request) {
		
				if($request->range != ''){

					if(!empty(explode(' a ', $request->range)[1])){
						$from = explode(' a ', $request->range)[0];
						$to = explode(' a ', $request->range)[1];
						$where = "DATE_FORMAT(precio_monedas.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
						$builder->where($where);
					}else{
						$where = "DATE_FORMAT(precio_monedas.creado_en, '%Y-%m-%d') = '$request->range'";
						$builder->where($where);
					}
					
				}

				if($request->status != ''){
					$builder->where('precio_monedas.estado', $request->status);
				}
		
			})
			->toJson();
	}

	public function getCoinPriceById($identification)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ControlCenterModel = new ControlCenterModel();
		$coinPrices = $ControlCenterModel->getCoinPriceById(['identificacion' => $identification]);
		if(!$coinPrices){
			return false;
		}

		$coinPrices[0]['creado_en'] = date('d-m-Y H:i:s', strtotime($coinPrices[0]['creado_en']));
		$coinPrices[0]['actualizado_en'] = date('d-m-Y H:i:s', strtotime($coinPrices[0]['actualizado_en']));

		return json_encode($coinPrices);
	}

	public function updateCoinPrice()
	{
		helper('controlCenterValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(updateCoinPriceValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$identification = $this->request->getPost('identification');
		$principalCoin = $this->request->getPost('principalCoin');
		$secondaryCoin = $this->request->getPost('secondaryCoin');
				
		// ? Comprobar las fechas, ya que si es diferente a la actual no se pueden actualizar
		$date = $this->request->getPost('date');
		$date = date('d-m-Y', strtotime($date));
		$today = date('d-m-Y');

		if($date != $today) {
			$this->errorMessage['text'] = "Ya el precio no se puede actualizar, prueba creando uno nuevo";
			return sweetAlert($this->errorMessage);
		}
		
		// Dar formato al precio
		$price = str_replace(',', '', $this->request->getPost('price'));
		
		if(!is_numeric($price)) {
			$this->errorMessage['text'] = "Por favor introduce un precio válido";
			return sweetAlert($this->errorMessage);
		}
		
		$price = floatval($price);
		
		if($price <= 0) {
			$this->errorMessage['text'] = "El precio tiene que ser mayor a 0";
			return sweetAlert($this->errorMessage);
		}

		$ControlCenterModel = new ControlCenterModel();
		$coinPrice = $ControlCenterModel->updateCoinPrice([
										"moneda_secundaria" => $secondaryCoin,
										"precio"			=> $price
									], $identification);

		if(!$coinPrice){
			$this->errorMessage['text'] = "Error actualizar los datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Actualizar precio de monedas";
		$this->auditContent['descripcion'] 	= "Se ha actualizado el precio de monedas con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "El precio de moneda se ha actualizado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function deleteCoinPrice()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$identification = $this->request->getPost('identification');

		$ControlCenterModel = new ControlCenterModel();
		$deleteCoinPrice = $ControlCenterModel->deleteCoinPrice($identification);

		if(!$deleteCoinPrice){
			$this->errorMessage['text'] = "El registro no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Eliminar precio de moneda";
		$this->auditContent['descripcion'] 	= "Se ha eliminado el precio de moneda con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "Registro eliminado";
		$this->successMessage['text'] 		= "Puede recuperarla desde la papelera";
		return sweetAlert($this->successMessage);
	}

	public function recoverCoinPrice()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$identification = $this->request->getPost('identification');

		$ControlCenterModel = new ControlCenterModel();
		$recoverCoinPrice = $ControlCenterModel->recoverCoinPrice($identification);

		if(!$recoverCoinPrice){
			$this->errorMessage['text'] = "El registro no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Recuperar precio de moneda";
		$this->auditContent['descripcion'] 	= "Se ha recuperado el precio de moneda con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "¡Exito!";
		$this->successMessage['text'] 		= "Registro recuperado";
		return sweetAlert($this->successMessage);
	}
}