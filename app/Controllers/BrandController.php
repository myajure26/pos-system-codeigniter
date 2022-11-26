<?php 
namespace App\Controllers;
use App\Models\BrandModel;
use App\Models\AuditModel;
use \Hermawan\DataTables\DataTable;

class BrandController extends BaseController
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
		"modulo"		=> "Marcas",
		"accion"		=> "",
		"descripcion"	=> ""
	];

	public function createBrand()
	{
		helper('brandValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(createBrandValidation())){

			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$name = $this->request->getPost('name');

		$BrandModel = new BrandModel();
		$brand = $BrandModel->createBrand(['marca' => $name]);

		if(!$brand){
			$this->errorMessage['text'] = "Error al guardar la marca en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Crear marca";
		$this->auditContent['descripcion'] 	= "Se ha creado la marca con identificación #" . $BrandModel->getLastId() . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "La marca se ha creado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function getBrands()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$BrandModel = new BrandModel();
				
		return DataTable::of($BrandModel->getBrands())
			->edit('estado', function($row){
									
				if($row->estado == 0){
					return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-danger text-danger p-2 px-3">Desactivado</a></div>';
				}

				return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-success text-success p-2 px-3">Activado</a></div>';
			})
			->add('Acciones', function($row){
				if($row->estado == 1){
					return '<div class="btn-list"> 
								<button type="button" class="btnView btn btn-sm btn-primary waves-effect" data-id="'.$row->identificacion.'" data-type="brands" data-bs-toggle="modal" data-bs-target="#viewModal">
									<i class="far fa-eye"></i>
								</button>
								<button type="button" class="btnDelete btn btn-sm btn-danger waves-effect" data-id="'.$row->identificacion.'" data-type="brands">
									<i class="far fa-trash-alt"></i>
								</button>
							</div>';
				}

				return '<div class="btn-list"> 
								<button type="button" class="btnRecover btn btn-sm btn-success waves-effect" data-id="'.$row->identificacion.'" data-type="brands">
									<i class="fas fa-check"></i>
								</button>
							</div>';

			}, 'last') 
			->filter(function ($builder, $request) {
		
				if($request->range != ''){

					if(!empty(explode(' a ', $request->range)[1])){
						$from = explode(' a ', $request->range)[0];
						$to = explode(' a ', $request->range)[1];
						$where = "DATE_FORMAT(marcas.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
						$builder->where($where);
					}else{
						$where = "DATE_FORMAT(marcas.creado_en, '%Y-%m-%d') = '$request->range'";
						$builder->where($where);
					}
					
				}

				if($request->status != ''){
					$builder->where('marcas.estado', $request->status);
				}
		
			})
			->toJson();
	}

	public function getBrandById($identification)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$BrandModel = new BrandModel();
		$brand = $BrandModel->getBrandById(['identificacion' => $identification]);
		if(!$brand){
			return false;
		}

		return json_encode($brand);
	}

	public function updateBrand()
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

		$identification = $this->request->getPost('identification');
		$name = $this->request->getPost('name');

		$BrandModel = new BrandModel();
		$brand = $BrandModel->updateBrand($name, $identification);

		if(!$brand){
			$this->errorMessage['text'] = "Error actualizar la marca en la base de datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Actualizar marca";
		$this->auditContent['descripcion'] 	= "Se ha actualizado la marca con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "La marca se ha actualizado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function deleteBrand()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$identification = $this->request->getPost('identification');

		$BrandModel = new BrandModel();
		$deleteBrand = $BrandModel->deleteBrand($identification);

		if(!$deleteBrand){
			$this->errorMessage['text'] = "La marca no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Eliminar marca";
		$this->auditContent['descripcion'] 	= "Se ha eliminado la marca con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "Marca eliminada";
		$this->successMessage['text'] 		= "Puede recuperarla desde la papelera";
		return sweetAlert($this->successMessage);
	}

	public function recoverBrand()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$identification = $this->request->getPost('identification');

		$BrandModel = new BrandModel();
		$recoverBrand = $BrandModel->recoverBrand($identification);

		if(!$recoverBrand){
			$this->errorMessage['text'] = "La marca no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Recuperar marca";
		$this->auditContent['descripcion'] 	= "Se ha recuperado la marca con identificación #" . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "¡Exito!";
		$this->successMessage['text'] 		= "La marca ha sido recuperada";
		return sweetAlert($this->successMessage);
	}
}
