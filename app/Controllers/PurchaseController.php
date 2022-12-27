<?php 
namespace App\Controllers;
use App\Models\PurchaseModel;
use App\Models\AuditModel;
use \Hermawan\DataTables\DataTable;

class PurchaseController extends BaseController
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
		"modulo"		=> "Compras",
		"accion"		=> "",
		"descripcion"	=> ""
	];

	public function getPurchases()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$PurchaseModel = new PurchaseModel();
				
		return DataTable::of($PurchaseModel->getPurchases())
			->hide('simbolo')
			->edit('estado', function($row){
						
				if($row->estado == 0){
					return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-danger text-danger p-2 px-3">Anulada</a></div>';
				}

				return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-success text-success p-2 px-3">Procesada</a></div>';
			})
			->add('total', function($row){
				$db      	= \Config\Database::connect();
				$db 		= $db
								->table('detalle_compra')
								->select('SUM(precio*cantidad) as total')
								->where('compra', $row->identificacion)
								->get()->getResultArray();

				$total = number_format($db[0]['total'], 2);
				return "$row->simbolo $total";
				
			})
			->add('Acciones', function($row){
				return '<div class="btn-list"> 
								<button type="button" class="btnPrint btn btn-sm btn-primary waves-effect" data-id="'.$row->identificacion.'" data-type="purchases"> 
									<i class="fa fa-print"></i>
								</button> 
							</div>';


			}, 'last') 
			->filter(function ($builder, $request) {
		
				if($request->range != ''){

					if(!empty(explode(' a ', $request->range)[1])){
						$from = explode(' a ', $request->range)[0];
						$to = explode(' a ', $request->range)[1];
						$where = "DATE_FORMAT(compras.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
						$builder->where($where);
					}else{
						$where = "DATE_FORMAT(compras.creado_en, '%Y-%m-%d') = '$request->range'";
						$builder->where($where);
					}
					
				}
		
			})
			->toJson();
	}

}
