<?php 
namespace App\Controllers;
use App\Models\PaymentMethodModel;
use App\Models\AuditModel;
use \Hermawan\DataTables\DataTable;

class PaymentMethodController extends BaseController
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
		"modulo"		=> "Método de pago",
		"accion"		=> "",
		"descripcion"	=> ""
	];

	public function createPaymentMethod()
	{
		helper('paymentMethodValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(createPaymentMethodValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$name = $this->request->getPost('name');

		$PaymentMethodModel = new PaymentMethodModel();
		$paymentMethod = $PaymentMethodModel->createPaymentMethod([
									'nombre' => $name
								]);

		if(!$paymentMethod){
			$this->errorMessage['text'] = "Error al guardar el método de pago en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Crear método de pago";
		$this->auditContent['descripcion'] 	= "Se ha creado la método de pago con identificación #" . $PaymentMethodModel->getLastId() . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "La método de pago se ha creado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function getPaymentMethods()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$PaymentMethodModel = new PaymentMethodModel();
				
		return DataTable::of($PaymentMethodModel->getPaymentMethods())
			->edit('estado', function($row){
								
				if($row->estado == 0){
					return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-danger text-danger p-2 px-3">Desactivado</a></div>';
				}

				return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-success text-success p-2 px-3">Activado</a></div>';
			})
			->add('Acciones', function($row){
				if($row->estado == 1){
					return '<div class="btn-list"> 
								<button type="button" class="btnView btn btn-sm btn-primary waves-effect" data-id="'.$row->identificacion.'" data-type="payment_method" data-bs-toggle="modal" data-bs-target="#viewModal">
									<i class="far fa-eye"></i>
								</button>
								<button type="button" class="btnDelete btn btn-sm btn-danger waves-effect" data-id="'.$row->identificacion.'" data-type="payment_method">
									<i class="far fa-trash-alt"></i>
								</button>
							</div>';
				}

				return '<div class="btn-list"> 
								<button type="button" class="btnRecover btn btn-sm btn-success waves-effect" data-id="'.$row->identificacion.'" data-type="payment_method">
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

	public function getPaymentMethodById($identification)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$PaymentMethodModel = new PaymentMethodModel();
		$paymentMethod = $PaymentMethodModel->getPaymentMethodById(['id_metodo_pago' => $identification]);
		if(!$paymentMethod){
			return false;
		}

		return json_encode($paymentMethod);
	}

	public function updatePaymentMethod()
	{
		helper('paymentMethodValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(updatePaymentMethodValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$identification = $this->request->getPost('identification');
		$name = $this->request->getPost('name');

		$PaymentMethodModel = new PaymentMethodModel();
		$paymentMethod = $PaymentMethodModel->updatePaymentMethod([
										"nombre" => $name
									], $identification);

		if(!$paymentMethod){
			$this->errorMessage['text'] = "Error actualizar el método de pago en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Actualizar método de pago";
		$this->auditContent['descripcion'] 	= "Se ha actualizado el método de pago con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "El método de pago se ha actualizado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function deletePaymentMethod()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$identification = $this->request->getPost('identification');

		$PaymentMethodModel = new PaymentMethodModel();
		$deletePaymentMethod = $PaymentMethodModel->deletePaymentMethod($identification);

		if(!$deletePaymentMethod){
			$this->errorMessage['text'] = "El método de pago no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Eliminar método de pago";
		$this->auditContent['descripcion'] 	= "Se ha eliminado el método de pago con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "Método de pago eliminada";
		$this->successMessage['text'] 		= "Puede recuperarlo desde la papelera";
		return sweetAlert($this->successMessage);
	}

	public function recoverPaymentMethod()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$identification = $this->request->getPost('identification');

		$PaymentMethodModel = new PaymentMethodModel();
		$recoverPaymentMethod = $PaymentMethodModel->recoverPaymentMethod($identification);

		if(!$recoverPaymentMethod){
			$this->errorMessage['text'] = "El método de pago no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Recuperar método de pago";
		$this->auditContent['descripcion'] 	= "Se ha recuperado el método de pago con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "¡Exito!";
		$this->successMessage['text'] 		= "El método de pago ha sido recuperado";
		return sweetAlert($this->successMessage);
	}
}
